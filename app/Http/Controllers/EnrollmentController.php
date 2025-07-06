<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Program;
use App\Traits\PaymentTransactionTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EnrollmentController extends Controller
{

    use PaymentTransactionTrait;
    public function __construct()
    {

        $tabs = Session::get("tabs");
        if(!isset($tabs)){
            Session::put("tabs", []);
        }
    }

    public function index(Request $request)
    {
        $trainees = Enrollment::whereNotNull('enrollment_date');
        $filter = $request['filter'];
        $sort  = $request['sort'];
        $programSlug  = $request['program_slug'];
        $program      = Program::where('slug', $programSlug)->first();

        if(isset($filter)){
            switch ($filter){
                case "COMPLETED":
                    $trainees = $trainees->where('has_completed_payment', true);
                    break;
                case 'IN_COMPLETE':
                    $trainees = $trainees->where('has_completed_payment', false);
                    break;
            }
        }
        if(isset($sort)){
             switch ($sort) {
                case 'DATE_ASC':
                    $trainees->orderBy('created_at');
                    break;
                default:
                    $trainees->orderByDesc('created_at');
                    break;
            }
        }

        if(isset($programId) && $programId !== "ALL"){
            $trainees = $trainees->whereHas('trainingSlot', function ($query) use ($program){
                $query->where('program_id', $program->id);
            });
        }

        $trainees = $trainees->paginate(15);
        $programs = Program::all();
        $date     = Carbon::now();
        $data = [
            'trainees' => $trainees,
            'date'     => $date,
            'programs' => $programs
        ];
        return view('pages.management.trainee.trainees')->with($data);
    }

    public function deleteTrainee(Request $request)
    {
        $slug = $request['slug'];
        $enrollment = Enrollment::where('slug', $slug)->firstOrFail();

        $enrollment->delete();

        return redirect()->route('manage-students')->with('status', 'Student Enrollment deleted successfully');
    }

    public function viewStudent(Request $request)
    {
        $slug = $request['slug'];
        $enrollment = Enrollment::where('slug', $slug)->firstOrFail();

        $data = [
            'enrollment' => $enrollment
        ];

        return view('pages.management.trainee.profile')->with($data);
    }
}
