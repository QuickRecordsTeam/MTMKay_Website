<?php

namespace App\Http\Controllers;

use App\Constant\ProgramEnrollmentStatus;
use App\Constant\Roles;
use App\Http\Requests\EnrollmentRequest;
use App\Mail\EnrollmentMail;
use App\Mail\EnrollmentNotification;
use App\Mail\NewStudentMail;
use App\Models\Enrollment;
use App\Models\Program;
use App\Models\Role;
use App\Models\TrainingSlot;
use App\Models\User;
use App\Services\FapshiService;
use App\Traits\SubscriptionTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    use SubscriptionTrait;

    public function enrollStudent($slug, EnrollmentRequest $request)
{
    $program = Program::where('slug', $slug)->firstOrFail();

    // Validate user input
    $request->validate([
        'training_slot' => 'required|exists:training_slots,id',
        'amount'        => 'required|numeric|min:500|max:' . $program->cost,
        'medium'        => 'required|string|in:MTN,ORANGE',
    ]);

    // Check if slot is available
    if ($this->validateEnrollmentNumber($request)) {
        return response()->json([
            'message' => 'Training slot already reached the maximum number of available seats. Please apply with another slot',
            'status'  => 409,
            'code'    => 'MAXIMUM_ENROLLMENT_REACHED'
        ], 409);
    }

    // Get or create student
    $student = $this->fetchStudent($request) ?? $this->createStudentAccount($request);

    // Ensure only one enrollment per student
    if ($this->checkIfStudentEnrollAnyTrainingSlot($student->id)) {
        return response()->json([
            'message' => 'You can only enroll for one training slot',
            'status'  => 409,
            'code'    => 'ALREADY_ENROLLED'
        ], 409);
    }

    // Create enrollment
    $transactionId = uniqid("txn_");
    $enrollment = Enrollment::create([
        'program_id'            => $program->id,
        'user_id'               => $student->id,
        'has_completed_payment' => false,
        'training_slot_id'      => $request['training_slot'],
        'status'                => 'pending_payment',
        'transaction_id'        => $transactionId,
    ]);

    // Create pending transaction with requested amount
    $enrollment->paymentTransactions()->create([
        'amount_deposited' => $request->amount,
        'payment_date'     => now(),
        'external_id'      => $transactionId,
    ]);

    // Clean phone format
    $rawPhone   = preg_replace('/[^0-9]/', '', $student->telephone);
    $cleanPhone = preg_replace('/^237/', '', $rawPhone);

    // Initiate payment with Fapshi
    $paymentData = [
        'amount'     => (int) $request->amount,
        'phone'      => $cleanPhone,
        'medium'     => strtolower($request->medium) === 'mtn' ? 'mobile money' : 'orange money',
        'name'       => $student->name,
        'email'      => $student->email,
        'userId'     => (string) $student->id,
        'externalId' => $transactionId,
        'message'    => "Enrollment payment for {$program->title}",
    ];

    $response = app(FapshiService::class)->initiatePayment($paymentData);

    // Debug log for testing
    \Log::info('Fapshi Response:', $response);

    $isSuccess = (
        (isset($response['message']) && $response['message'] === 'Accepted') ||
        (isset($response['status']) && $response['status'] === 'success') ||
        (isset($response['transId']) && !empty($response['transId']))
    );

    if ($isSuccess) {
        return response()->json([
            'message' => 'Payment request sent to your phone. Please confirm to complete enrollment.',
            'status'  => 200,
            'code'    => 'PAYMENT_INITIATED',
            'details' => $response,
        ]);
    }

    return response()->json([
        'message' => 'Unable to initiate payment',
        'status'  => 400,
        'code'    => 'PAYMENT_FAILED',
        'details' => $response,
    ]);
}

    public function createStudentAccount(EnrollmentRequest $request)
    {

        $role = Role::where('name', Roles::TRAINEE)->firstOrFail();

        $trainingSlot = TrainingSlot::findOrFail($request['training_slot']);

        if(!isset($trainingSlot)){
            return redirect()->back()->with(['status', 'Training Slot does not exist']);
        }

        $request->validate([
            'email' => 'unique:users,email'
        ]);
        $student = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'telephone' => $request['telephone'],
            'address'  => $request['address'],
            'password' => Hash::make('password'),
            'role_id'   => $role->id,
        ]);

        $data = $this->setEmailData($request, $trainingSlot, $student);

        Mail::to($request['email'])->send(new EnrollmentMail($data));


        return $student;
    }

    public function completeEnrollment(Request $request)
    {

       $expires      = Carbon::create($request['expires']);
       $user         = User::where('slug', $request['stud'])->firstOrFail();
       $trainingSlot = TrainingSlot::where('slug', $request['trainingSlot'])->firstOrFail();
       $has_expire   = Carbon::now()->greaterThan($expires);
       $enrollment = Enrollment::where('training_slot_id', $trainingSlot->id)->where('user_id', $user->id)->first();

       if(isset($enrollment) && !isset($enrollment->enrollment_date)){
           $user->update([
               'email_verified_at' => Carbon::now()
           ]);
           $enrollment->update([
               'enrollment_date' => Carbon::now()
           ]);

           $this->updateTrainingSlotStatus($trainingSlot);

           $program_link = url()->query('training-detail', ['slug' => $trainingSlot->program->slug]);

           $emailData = [
               'name'                => $user['name'],
               'email'               => $user['email'],
               'program'             => $trainingSlot->program,
               'is_first_time'       => true,
               'program_image'       => $trainingSlot->program->getImagePath($trainingSlot->program, $trainingSlot->program->image_path),
               'program_link'        => $program_link,
               'verificationUrl'     => str_replace('amp;', '', $this->generationEnrollmentVerificationLink($trainingSlot->program, $user, $trainingSlot)),
               'subscription_link'   => $this->generationSubscriptionLinkUsingEmail($user['email']),
               'unsubscription_link' => $this->generationUnSubscriptionLinkUsingEmail($user['email']),
               'trainingSlot'       => $trainingSlot
           ];

           $this->sendNotificationsUponEnrollment($user['email'], $emailData, $trainingSlot->program, $user, $trainingSlot);
       }

       $data = [
           'student'           => $user,
           'program'           => $trainingSlot->program,
           'has_expire'        => $has_expire,
           'message'           => $has_expire ? 'Program Enrollment Link has Expired': 'Program Enrollment Completed Successfully',
           'program_link'      => url()->query('training-detail', ['slug' => $trainingSlot->program->slug]),
           'trainingSlot'      => $trainingSlot
       ];


       return view('pages.verification.enrollment')->with($data);
    }


    private function setEmailData($request, $trainingSlot, $student)
    {
        $program_link = url()->query('training-detail', ['slug' => $trainingSlot->program->slug]);
        return  [
            'name'                => $request['name'],
            'email'               => $request['email'],
            'program'             => $trainingSlot->program,
            'is_first_time'       => true,
            'program_image'       => $trainingSlot->program->getImagePath($trainingSlot->program, $trainingSlot->program->image_path),
            'program_link'        => $program_link,
            'verificationUrl'     => str_replace('amp;', '', $this->generationEnrollmentVerificationLink($trainingSlot->program, $student, $trainingSlot)),
            'subscription_link'   => $this->generationSubscriptionLinkUsingEmail($request['email']),
            'unsubscription_link' => $this->generationUnSubscriptionLinkUsingEmail($request['email']),
            'trainingSlot'        => $trainingSlot
        ];
    }

    private function sendNotificationsUponEnrollment($studentEmail, $emailData, $program, $exist, $trainingSlot)
    {
        try {
            Mail::to($studentEmail)->send(new NewStudentMail($emailData));

        }catch (\Exception $e){
            return  response()->json(['message' => 'Could not sent email notification mail to student', 'code' => 'FAILED']);
        }

        try {
            $data = [
                'program'        => $program->title,
                'studentName'    => $exist->name,
                'studentEmail'   => $exist->email,
                'studentPhone'   => $exist->telephone,
                'studentAddress' => $exist->address,
                'adminEmail'     => env('MAIL_FROM_ADDRESS'),
                'trainingSlot'   => $trainingSlot
            ];

            Mail::to(env('MAIL_FROM_ADDRESS'))->send(new EnrollmentNotification($data));

        }catch (\Exception $e){
            return  response()->json(['message' => 'Could not sent email notification mail to admin', 'code' => 'FAILED']);
        }

        return true;
    }

    private function generationEnrollmentVerificationLink($program, $student, $trainingSlot)
    {
        return urldecode(url()->query(env('ENROLLMENT_VERIFICATION_URL'), ['trainingSlot' => $trainingSlot->slug, 'prog' => $program->slug, 'stud' => $student->slug,'expires' => strtotime(Carbon::now()->addHours(24))]));
    }

    private function fetchStudent($request)
    {
        return User::where('email', $request['email'])->first();
    }

    private function checkIfStudentEnrollAnyTrainingSlot($userId)
    {
        return Enrollment::where('user_id', $userId)->whereNotNull('enrollment_date')->first();
    }

    private function updateTrainingSlotStatus($trainingSlot)
    {
        $diffInEnrollment = ($trainingSlot->available_seats - count($trainingSlot->enrollments));
        if($trainingSlot->status = ProgramEnrollmentStatus::AVAILABLE){
            if($diffInEnrollment >= 1 && $diffInEnrollment <= 5){
                $trainingSlot->update([
                    'status' => ProgramEnrollmentStatus::ALMOST_FULL
                ]);
            }
            elseif($diffInEnrollment == 0){
                $trainingSlot->update([
                    'status' => ProgramEnrollmentStatus::FULL
                ]);
            }
        }
    }

    private function validateEnrollmentNumber(EnrollmentRequest $request)
    {
        $trainingSlot = TrainingSlot::findOrFail($request['training_slot']);

        
        return ($trainingSlot->countCompletedEnrollments($trainingSlot->id) >= $trainingSlot->available_seats);
    }

    public function checkEnrollmentStatus($transactionId)
{
    $transaction = \App\Models\PaymentTransaction::where('external_id', $transactionId)
        ->with('enrollment')
        ->first();

    if (!$transaction) {
        return response()->json([
            'status' => 'not_found',
            'message' => 'Transaction not found',
        ], 404);
    }

    return response()->json([
        'status' => $transaction->enrollment->status,
        'has_completed_payment' => $transaction->enrollment->has_completed_payment,
    ]);
}


}
