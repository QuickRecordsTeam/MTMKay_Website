@section('title', 'MTMKay-Training Program details')

<x-guest-layout>
    @push('style')
    <style>
        .form-step {
            display: none;
        }
        .form-step.active {
            display: block;
        }
        .d-none {
            display: none !important;
        }
        
        /* Add smooth transitions */
        .form-step {
            transition: opacity 0.3s ease;
        }
        
        /* Add step indicator styling */
        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .step {
            text-align: center;
            margin: 0 15px;
        }
        .step-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #e9ecef;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 5px;
            font-weight: bold;
        }
        .step.active .step-circle {
            background: #4a6cf7;
            color: white;
        }
        .step-label {
            font-size: 12px;
            color: #6c757d;
        }
        .step.active .step-label {
            color: #4a6cf7;
            font-weight: bold;
        }
    </style>
    @endpush

    <!--================Home Banner Area =================-->
    <section class="banner_area">
        <div class="banner_inner banner_training d-flex align-items-center">
            <div class="overlay bg-parallax" data-stellar-ratio="0.9" data-stellar-vertical-offset="0" data-background=""></div>
            <div class="container">
                <div class="banner_content text-center">
                    <h2 class="banner_hero_text">{{$program->title}}</h2>
                    <div class="page_link banner_hero_btn">
                        <a href="{{route('home')}}">Home</a>
                        <a href="{{route('training')}}">Program</a>
                        <a href="#">Program Details</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Home Banner Area =================-->

    <!--================Course Details Area =================-->
    <section class="course_details_area p_120">
        <div class="container">
            <div class="row course_details_inner">
                <div class="col-lg-8">
                    <div class="c_details_img">
                        <img class="img-fluid" src="{{$program->getImagePath($program, $program->image_path) ?? ''}}" alt="" width="100%" height="20px">
                    </div>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="objectives-tab" data-toggle="tab" href="#objectives" role="tab" aria-controls="objectives" aria-selected="true">Objectives</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="eligibility-tab" data-toggle="tab" href="#eligibility" role="tab" aria-controls="eligibility" aria-selected="false">Eligibility</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="outline-tab" data-toggle="tab" href="#outline" role="tab" aria-controls="outline" aria-selected="false">Course Outline</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="job_opportunities-tab" data-toggle="tab" href="#job_opportunities" role="tab" aria-controls="job_opportunities" aria-selected="false">Job Opportunities</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="training_resources-tab" data-toggle="tab" href="#training_resources" role="tab" aria-controls="training_resources" aria-selected="false">Training Resources</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="training-slot-tab" data-toggle="tab" href="#training_slots" role="tab" aria-controls="training_slots" aria-selected="false">Training Slots</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="objectives" role="tabpanel" aria-labelledby="objectives-tab">
                            <div class="objctive_text">
                                <p>{!!($program->objective) !!}</p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="eligibility" role="tabpanel" aria-labelledby="eligibility-tab">
                            <div class="objctive_text">
                                <p>{!! $program->eligibility !!}</p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="outline" role="tabpanel" aria-labelledby="outline-tab">
                            <div class="objctive_text">
                                @foreach($program->programOutlines as $key => $outline)
                                    <h6>{{substr($outline->period, 0, strlen($outline->period) - 1 )}} {{$key+1}}</h6>
                                    <p href="#">{!! $outline->topic !!}</p>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane fade" id="job_opportunities" role="tabpanel" aria-labelledby="job_opportunities-tab">
                            <div class="objctive_text">
                                <p>{!! $program->job_opportunities !!}</p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="training_resources" role="tabpanel" aria-labelledby="training_resources-tab">
                            <div class="objctive_text">
                                <p>{!! $program->training_resources !!}</p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="training_slots" role="tabpanel" aria-labelledby="training-slot-tab">
                            <div class="objctive_text">
                                <p>Our Training Programs normally runs through from Monday to Friday. You can find this different slots  and their status below</p>
                            </div>
                            @foreach($trainingSlots as $slot)
                                <div class="objctive_text">
                                    <h6>Name: {{$slot->name}}</h6>
                                    <p>Start Time: {{$slot->start_time}}</p>
                                    <p>End Time: {{$slot->end_time}}</p>
                                    <p>Available Seats: {{$slot->available_seats}}</p>
                                    <p>Enrolled Number: {{$slot->countCompletedEnrollments($slot->id)}}</p>
                                    @if(\App\Constant\ProgramEnrollmentStatus::AVAILABLE == $slot->status)
                                        <p style="color: #0E9F6E">Status: {{$slot->status}}</p>
                                    @elseif(\App\Constant\ProgramEnrollmentStatus::ALMOST_FULL == $slot->status)
                                        <p style="color: #e0a800">Status: {{str_replace('_', ' ', $slot->status)}}</p>
                                    @else
                                        <p style="color: #b21f2d">Status: {{$slot->status}}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="c_details_list">
                        <ul class="list">
                            <li><a href="#">Trainer’s Name <span>{{$program->trainer_name}}</span></a></li>
                            <li><a href="#">Program Fee <span>{{number_format($program->cost)}} XAF</span></a></li>
                            <li><a href="#">Duration <span>{{$program->duration}} months</span></a></li>
                        </ul>
                        <a class="main_btn" href="#" id="enrollmentBtn">Enroll for Program</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Course Details Area =================-->

    <!--=================Enrollment Form ========================-->
<div id="success" class="modal modal-message fade mt-5" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered mt-5 enrollment_modal">
        <div class="modal-content">
            <div class="modal-header pb-3">
                <button type="button" id="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-close"></i>
                </button>
                <h2 class="mb-0 title_color w-100 text-center">Enrollment Form</h2>
            </div>
            <div class="modal-body px-4">
                <form action="{{ route('enroll-student', ['slug' => $program->slug]) }}"  
                      id="enrollmentForm" method="POST">
                    @csrf

                    <!-- Personal Information -->
                    <h5 class="mb-3 text-primary">Personal Information</h5>
                    <div class="form-group">
                        <input type="text" id="name" name="name" placeholder="Full Name" required class="form-control py-2">
                    </div>
                    <div class="form-group">
                        <input type="email" id="email" name="email" placeholder="Email address" required class="form-control py-2">
                    </div>
                    <div class="form-group">
                        <input type="tel" id="telephone" name="telephone" placeholder="678901234" required class="form-control py-2">
                    </div>
                    <div class="form-group">
                        <input type="text" id="address" name="address" placeholder="Address" required class="form-control py-2">
                    </div>

                    <!-- Training Slot -->
                    <div class="form-group pb-5 w-full">
                        <h5 class="mt-4 mb-2 text-primary w-100">Training Details</h5>
                        <select id="training_slot" name="training_slot" required class="form-control py-2">
                            <option value="">-- Select Training Slot --</option>
                            @foreach($availableSlots as $slot)
                                <option value="{{ $slot->id }}">{{ $slot->name }} {{ $slot->start_time }} - {{ $slot->end_time }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Payment -->
                    <div class="form-group pb-5 w-full">
                        <h5 class="mt-4 mb-2 text-primary w-100">Payment Details</h5>
                        <select id="medium" name="medium" required class="form-control py-2">
                            <option value="">-- Select Payment Method --</option>
                            <option value="MTN">MTN MoMo</option>
                            <option value="ORANGE">Orange Money</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="number" id="amount" name="amount" placeholder="Enter Amount"
                            min="500" step="100" required class="form-control py-2">
                    </div>


                    <!-- Submit -->
                    <div class="text-center mt-4">
                        <button type="submit" class="btn main_btn btn-block submit_enroll_button" id="submitEnrollment">
                            <span class="btn-text">Enroll & Pay</span>
                        </button>
                        <div class="spinner mt-3 loader" style="display: none"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--================End of Enrollment Form====================-->

<!--======== Payment initiation modal ==============================-->
    <div id="payment-initiation" class="modal modal-message fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-close"></i>
                    </button>
                    <h2>Payment Initiated</h2>
                    <p>A payment request has been sent to your phone. Please approve it to complete your enrollment.</p>
                </div>
            </div>
        </div>
    </div>
    <!--======== End Payment initiation modal ==============================-->

    <!--================Contact Success and Error message Area =================-->
    <div id="success_new_account" class="modal modal-message fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-close"></i>
                    </button>
                    <h2>Thank you</h2>
                    <p>Please verify your student account to complete your enrollment...</p>
                </div>
            </div>
        </div>
    </div>

    <!--========Success modal for enrollment ==============================-->
    <div id="success_exist_acc" class="modal modal-message fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-close"></i>
                    </button>
                    <h2>Thank you</h2>
                    <p>Your enrollment completed successfully...</p>
                </div>
            </div>
        </div>
    </div>
    <!--========Success modal for enrollment ==============================-->

    <!--========Success modal for first time enrollment ==============================-->
    <div id="success_enrolled" class="modal modal-message fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-close"></i>
                    </button>
                    <h2>Thank you</h2>
                    <p>You have already Enrolled for this training slot...</p>
                </div>
            </div>
        </div>
    </div>
    <!--======== End Success modal for first time enrollment =====================-->

     <!-- =========Modals error ===================================-->
    <div id="payment-failed" class="modal modal-message fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-close"></i>
                    </button>
                    <h2>Payment Failed</h2>
                    <p> Something went wrong, Please try again! </p>
                </div>
            </div>
        </div>
    </div>
    <!--================End Contact Success and Error message Area =================-->

    <!-- =========Modals error ===================================-->
    <div id="error" class="modal modal-message fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-close"></i>
                    </button>
                    <h2>Sorry !</h2>
                    <p> Something went wrong </p>
                </div>
            </div>
        </div>
    </div>
    <!--================End Contact Success and Error message Area =================-->

    <!-- =========Modals error ===================================-->
    <div id="maximum-slot" class="modal modal-message fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-close"></i>
                    </button>
                    <h2>Sorry !</h2>
                    <p> We have reached the maximum enrollment for this slot. Please apply through another slot </p>
                </div>
            </div>
        </div>
    </div>
    <!--================End Contact Success and Error message Area =================-->

@push('scripts')
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        console.log("DOM loaded - initializing enrollment form");
        
        const form = document.getElementById("enrollmentForm");
        const loader = document.querySelector(".loader");
        
        // STEP 1: Fix the modal opening first
        const enrollmentBtn = document.getElementById("enrollmentBtn");
        if (enrollmentBtn) {
            enrollmentBtn.addEventListener("click", function(e) {
                e.preventDefault();
                console.log("Enrollment button clicked");
                // Show the enrollment modal using Bootstrap
                $('#success').modal('show');
            });
        }

        // STEP 2: Next/Back button functionality (attach immediately after DOM ready)
        const nextStepBtn = document.querySelector(".next_step");
        const prevStepBtn = document.querySelector(".prev_step");

        if (nextStepBtn) {
            nextStepBtn.addEventListener("click", function () {
                console.log("Next button clicked");
                if (validateStep1()) {
                    const step1 = document.querySelector(".step-1");
                    const step2 = document.querySelector(".step-2");
                    if (step1 && step2) {
                        step1.classList.remove("active");
                        step1.classList.add("d-none");
                        step2.classList.remove("d-none");
                        step2.classList.add("active");
                        console.log("Moved to step 2");
                    }
                }
            });
        }

        if (prevStepBtn) {
            prevStepBtn.addEventListener("click", function () {
                console.log("Back button clicked");
                const step1 = document.querySelector(".step-1");
                const step2 = document.querySelector(".step-2");
                if (step1 && step2) {
                    step2.classList.remove("active");
                    step2.classList.add("d-none");
                    step1.classList.remove("d-none");
                    step1.classList.add("active");
                    console.log("Moved to step 1");
                }
            });
        }

        // Form validation function
        function validateStep1() {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const telephone = document.getElementById('telephone').value;
            const address = document.getElementById('address').value;
            const trainingSlot = document.getElementById('training_slot').value;
            
            if (!name || !email || !telephone || !address || !trainingSlot) {
                alert('Please fill in all required fields');
                return false;
            }
            
            // Basic email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Please enter a valid email address');
                return false;
            }
            
            return true;
        }

        // STEP 3: Form submission handler
        if (form) {
            form.addEventListener("submit", async function (e) {
                e.preventDefault();
                console.log("Form submission started");
                
                if (loader) loader.style.display = "block";

                try {
                    let response = await fetch("{{ route('enroll-student', ['slug' => $program->slug]) }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                            "Accept": "application/json",
                        },
                        body: new FormData(form),
                    });

                    let data = await response.json();
                    console.log("Server response:", data);
                    
                    if (loader) loader.style.display = "none";

                    if (data.code === "PAYMENT_INITIATED") {
                        $("#success").modal("hide");
                        $("#payment-initiation").modal("show");

                        // extract transactionId
                        const transactionId = data.details.externalId || data.details.transId;
                        console.log("Payment initiated, transaction ID:", transactionId);

                        // start polling every 5s
                        let attempts = 0;
                        const interval = setInterval(async () => {
                            attempts++;

                            try {
                                const res = await fetch(`/enrollment/status/${transactionId}`);
                                const statusData = await res.json();
                                console.log("Polling attempt", attempts, "Status:", statusData);

                                if (statusData.status === "SUCCESSFUL") {
                                    clearInterval(interval);
                                    $("#payment-initiation").modal("hide");
                                    $("#success_exist_acc").modal("show");
                                } else if (statusData.status === "FAILED") {
                                    clearInterval(interval);
                                    $("#payment-initiation").modal("hide");
                                    $("#payment-failed").modal("show");
                                }
                            } catch (err) {
                                console.error("Polling error:", err);
                            }

                            if (attempts >= 24) {
                                clearInterval(interval);
                                $("#payment-initiation").modal("hide");
                                $("#error").modal("show");
                            }
                        }, 5000);
                    }
                    else if (data.code === "MAXIMUM_ENROLLMENT_REACHED") {
                        $("#maximum-slot").modal("show");
                    } 
                    else if (data.code === "PAYMENT_FAILED") {
                        $("#payment-failed").modal("show");
                    } 
                    else if (data.code === "ENROLLED") {
                        $("#success_enrolled").modal("show");
                    } 
                    else {
                        $("#error").modal("show");
                    }
                } catch (err) {
                    if (loader) loader.style.display = "none";
                    console.error("Form submission error:", err);
                    $("#error").modal("show");
                }
            });
        }
        
        // Add debug logging
        console.log("Enrollment form script loaded");
        console.log("Form element:", form);
        console.log("Enrollment button:", enrollmentBtn);
    });
    </script>
    @endpush
</x-guest-layout>
