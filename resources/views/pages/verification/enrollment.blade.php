@section('title', 'Enrollment Confirmation')
<x-guest-nav-layout>
     <h3 class="flex justify-center my-3 font-bold">{{$message}}</h3>

    @if(!$has_expire)
        <div class="flex justify-start my-3">
            <label><span class="fw-bold">Student Name:</span> <span class="mx-2">{{$student->name}}</span></label>
        </div>

        <div class="flex justify-start my-3">
            <label><span class="fw-bold">Student Email:</span> <span class="mx-2 my-2">{{$student->email}}</span></label>
        </div>

        <div class="flex justify-start my-3">
            <label><span class="fw-bold">Student Telephone:</span> <span class="mx-2 my-2">{{$student->telephone}}</span></label>
        </div>
        <div class="flex justify-start my-3">
            <label><span class="fw-bolder">Program Title:</span> <span class="mx-2 my-2">{{$program->title}}</span></label>
        </div>
        <div class="flex justify-start my-3">
            <label><span class="fw-bold">Program Duration:</span> <span class="mx-2 my-2">{{$program->duration}} Months</span></label>
        </div>
        <div class="flex justify-start my-3">
            <label><span class="fw-bold">Training Schedule:</span> <br>
                <span class="mx-2 my-2">Period: {{$trainingSlot->name}}</span><br>
                <span class="mx-2 my-2">Start Time: {{date('h:i A', strtotime($trainingSlot->start_time))}}</span><br>
                <span class="mx-2 my-2">End Time: {{date('h:i A', strtotime($trainingSlot->end_time))}}</span>
            </label>
        </div>
    @endif


   <div class="my-5">
       <a href="{{$program_link}}">
           <x-primary-button>
               Check out your training program
           </x-primary-button>
       </a>
   </div>
</x-guest-nav-layout>

