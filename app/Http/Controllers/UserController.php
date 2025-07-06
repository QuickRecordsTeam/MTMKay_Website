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

        $isNotOpenForEnrollment = $this->validateEnrollmentNumber($request);

        if($isNotOpenForEnrollment){
            return response()->json(['message' => 'Training slot already reach the maximum number of avalaible seats. Please apply with another slot', 'status' => 200, 'code' => 'MAXIMUM_ENROLLMENT_REACHED']);
        }

        $exist   = $this->fetchStudent($request);


         if (!isset($exist)){
            
            $student = $this->createStudentAccount($request);
            
            if($this->checkIfStudentEnrollAnyTrainingSlot($student->id) !== null){
                return response()->json(['message' => 'You can only enrollment for one training slot', 'status' => 200, 'code' => 'ENROLLED']);
            }else{
                Enrollment::create([
                    'program_id'            => $program->id,
                    'user_id'               => $student->id,
                    'has_completed_payment' => false,
                    'training_slot_id'      => $request['training_slot']
                ]);
            }

            return response()->json(['message' => 'Successfully enrolled new student', 'status' => 200, 'code' =>  'NEW_ACCOUNT_CREATION' ]);

        }else {
              
            if($this->checkIfStudentEnrollAnyTrainingSlot($exist->id) !== null){
                return response()->json(['message' => 'You can only enrollment for one training slot', 'status' => 200, 'code' => 'ENROLLED']);
            }
            else {
                $savedEnrollment = Enrollment::create([
                    'program_id'             => $program->id,
                    'user_id'                => $exist->id,
                    'has_completed_payment'  => false,
                    'enrollment_date'        => Carbon::now(),
                    'training_slot_id'       => $request['training_slot']
                ]);

                $emailData = $this->setEmailData($request, $savedEnrollment->trainingSlot, $exist);
                $this->sendNotificationsUponEnrollment($request, $emailData, $program, $exist, $savedEnrollment->trainingSlot);
            }

            return response()->json(['message' => 'Successfully enrolled new student', 'status' => 200, 'code' => 'EXISTING_ACCOUNT']);
        }
        
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

}
