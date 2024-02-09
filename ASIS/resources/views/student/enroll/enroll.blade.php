@extends('layouts.app')

@section('content')
<!-- BEGIN: Enrollment Success Message -->
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes colorChange {
        0% {
            color: black;
        }
        100% {
            color: #4CAF50; /* Light green color code, keep the same color as 0% for a steady state */
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.5s;
    }

    .animate-color-change {
        animation: colorChange 1s; /* Set animation to run only once */
    }
</style>
{{-- @powerGridStyles --}}

<link rel="stylesheet" href="{{url('')}}/css/tailwind_min.min.css{{GET_RES_TIMESTAMP()}}" />
    @if ($enrollmentSettings['notificationHeader'])
        <div class="intro-y col-span-11 alert alert-primary alert-dismissible show flex items-center mb-6" role="alert">
            <span><i data-lucide="info" class="w-4 h-4 mr-2"></i></span>
            <span>{{ $enrollmentSettings['notificationHeader'] }} </span>
            <button type="button" class="btn-close text-white" data-tw-dismiss="alert" aria-label="Close"> <i data-lucide="x" class="w-4 h-4"></i> </button>
        </div>
    @endif

    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Submission of Intent to Enroll
        </h2>
            @if( auth()->user()->role === 'Admin')
                <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                    <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#enrollment_settings" class="btn btn-primary shadow-md mr-2">Settings</a>
                    {{-- <div class="pos-dropdown dropdown ml-auto sm:ml-0">
                        <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                            <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="chevron-down"></i> </span>
                        </button>
                        <div class="dropdown-menu w-40">
                            <ul class="dropdown-content">
                                <li>
                                    <a href="javascript:;" class="dropdown-item" data-tw-toggle="modal" data-tw-target="#report_list_modal"> <i data-lucide="printer" class="w-4 h-4 mr-2"></i> Report </a>
                                </li>
                            </ul>
                        </div>
                    </div> --}}
                </div>
            @endif
    </div>

@if ($enrollmentSettings['enrollmentStatus'] == 0)

<!-- BEGIN: Enrollment Closed Message -->

<div class="intro-y box py-10 sm:py-20 mt-5">
    <div class="text-center">
        <i class="fas fa-times-circle text-red-500 text-4xl mx-auto"></i>
        <h2 class="text-2xl font-semibold mt-2">Enrollment is Closed</h2>
    </div>
    <div class="text-center text-gray-600 mt-4">
        <p class="mb-2">We apologize for any inconvenience.</p>
        <p>Enrollment for the current session is now closed.</p>
    </div>
</div>
<!-- END: Enrollment Closed Message -->
@else

<!-- BEGIN: Enrollment Form -->
<div class="intro-y box py-10 sm:py-20 mt-5">

    <div class="px-5 sm:px-20">


        <div class="font-medium text-left text-lg pb-5">Enrollment Information</div>
        <div class="flex flex-col sm:flex-row items-center">
            <div class="grid-span-12 sm:grid-span-12">
                <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Semester</label>
                <div class="font-medium text-base ml-3">
                    {{-- <div class=" relative w-4 h-4 mr-2 -mt-0.5 before:content-[''] before:absolute before:w-4 before:h-4 before:bg-primary/20 before:rounded-full lg:before:animate-ping after:content-[''] after:absolute after:w-4 after:h-4 after:bg-primary after:rounded-full after:border-4 after:border-white/60 after:dark:border-darkmode-300 ">
                    </div> --}}
                    <select style="width: 150px" name="semester" id="semester" class="btn shadow-md mr-2">
                        <option value="{{ $enrollmentSettings['semester'] }}">{{ $enrollmentSettings['semester'] }}</option>
                    </select>
                </div>
            </div>

            <div class="grid-span-12 sm:grid-span-12">
                <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Year</label>
                <div class="font-medium text-base ml-3">
                    <select style="width: 150px" name="academicYear" id="academicYear" class="btn shadow-md mr-2">
                        <option value="{{ $enrollmentSettings['academicYear'] }}">{{ $enrollmentSettings['academicYear'] }}</option>
                    </select>
                </div>
            </div>
            <div class="grid-span-12 sm:grid-span-12">
                <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Enrollment Status</label>
                <div class="font-medium text-base ml-3">
                    <select style="width: 150px" name="enrollmentStatus" id="enrollmentStatus" class="btn shadow-md mr-2">
                        @if ($enrollmentSettings['enrollmentStatus'])
                            <option value="1">Ongoing</option>
                        @else
                            <option value="0">Closed</option>
                        @endif
                    </select>
                </div>
            </div>
        </div>
        @if ($enrollmentSettings['enrollmentWarningMessage'])
            <div class="alert alert-outline-warning alert-dismissible show flex items-center bg-warning/20 dark:bg-darkmode-400 dark:border-darkmode-400 mt-5" role="alert">
                <span><i data-lucide="alert-triangle" class="w-6 h-6 mr-3"></i></span>
                <span class="text-slate-800 dark:text-slate-500">{{ $enrollmentSettings['enrollmentWarningMessage'] }}</span>
                <button type="button" class="btn-close dark:text-white" data-tw-dismiss="alert" aria-label="Close"> <i data-lucide="x" class="w-4 h-4"></i> </button>
            </div>
        @endif
    </div>

    <div class="px-5 sm:px-20 mt-10 pt-10 border-t border-slate-200/60 dark:border-darkmode-400">
        <div class="px-5">
            <div class="font-medium text-center text-lg">Personal Information</div>
            <div class="text-slate-500 text-center mt-2">Thank you for your interest in enrolling in our program. We appreciate your enthusiasm and dedication to pursuing higher education with us. Below are your current details:</div>
        </div>
        <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
            <div class="intro-y col-span-12 sm:col-span-6">
                <label class="form-label">Full Name</label>
                <div class="bg-gray-100 px-4 py-2 rounded-md shadow-sm" id="full-name">
                    {{ GLOBAL_PostGressSQL_HEX_CONVERTER($student->studfullname) }}
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6">
                <label class="form-label">Email Address</label>
                <div class="bg-gray-100 px-4 py-2 rounded-md shadow-sm" id="email-address">
                    {{ $student->studemail }}
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6">
                <label class="form-label">Phone Number <span class="ml-1 text-danger">*</span></label>

                <div class="input-group">

                    @if($contact_number == '')
                        <input id="phone-number" type="text" disabled class="form-control" value="N/A" aria-label="Price" aria-describedby="input-group-price">
                        <a href="javascript:;" data-contact="{{ $contact_number }}" class="input-group-text btn_edit_phoneNumber"><i data-lucide="edit-3" class="w-4 h-4 text-secondary mx-auto"></i></a>
                    @else
                        <input id="phone-number" type="text" disabled class="form-control" value="{{ $contact_number }}" placeholder="Phone Number" aria-label="Price" aria-describedby="input-group-price">
                        <a href="javascript:;" data-contact="{{ $contact_number }}" class="input-group-text btn_edit_phoneNumber"><i data-lucide="edit-3" class="w-4 h-4 text-secondary mx-auto "></i></a>
                    @endif

                </div>

            </div>

            <div class="intro-y col-span-12 sm:col-span-6">
                <label class="form-label">Course/Program</label>
                <div class="bg-gray-100 px-4 py-2 rounded-md shadow-sm" id="course-program">
                    @if($latestSemStudent)
                        {{ $latestSemStudent->studmajor }}
                    @else
                        N/A
                    @endif

                </div>
            </div>



            <div class="intro-y col-span-12 sm:col-span-6">
                <label class="form-label">Address</label>
                <div class="bg-gray-100 px-4 py-2 rounded-md shadow-sm" id="address">
                    {{ $student->studpermaddr }}
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6">
                <label class="form-label">Student Level</label>
                <div class="bg-gray-100 px-4 py-2 rounded-md shadow-sm" id="student-level">
                    @if($latestSemStudent)
                        {{ $latestSemStudent->studlevel }}
                    @else
                        N/A
                    @endif
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6">
                <label class="form-label">Semester (allow sem)</label>
                <div class="bg-gray-100 px-4 py-2 rounded-md shadow-sm" id="semester-allow-sem">
                    @if($latestSemStudent)
                        Semester  {{ $student->allow_sem }}
                    @else
                        N/A
                    @endif
                </div>
            </div>
            <div class="intro-y col-span-12 sm:col-span-6">
                <label class="form-label">Academic Year (allow sy)</label>
                <div class="bg-gray-100 px-4 py-2 rounded-md shadow-sm" id="academic-year-allow-sy">
                    @if($latestSemStudent)
                        {{ $student->allow_sy }}
                    @else
                        N/A
                    @endif
                </div>
            </div>

            <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5">
                <button id="enrollButton" class="btn btn-primary w-48 ml-2" onclick="confirmEnrollment()">Submit Intent to Enroll</button>
            </div>
        </div>
    </div>

    @include('student.enroll.modals.yawa_na_modal')

</div>
<!-- END: Enrollment Form -->
@endif
<!-- BEGIN: Enrollment Success Message -->
<div id="enrollmentSuccess" class="hidden">

<div class="intro-y box py-10 sm:py-20 mt-5 bg-green-100 border-green-200 dark:bg-green-900 dark:border-green-800 animate-fade-in">
    <div class="text-center mb-4">
        <i class="fas fa-check-circle text-success text-4xl mx-auto animate-color-change fa-beat"></i>
        <h2 class="text-2xl font-semibold mt-2">Intent to Enroll Submitted</h2>
    </div>
    <div class="text-center text-green-700 mt-4">
        <p class="mb-2">Congratulations!</p>
        <p>Your intent to enroll for Semester {{ $enrollmentSettings['semester'] }} and School Year {{ $enrollmentSettings['academicYear'] }} has been submitted.</p>
        <p>Please note that you are not yet officially enrolled with this step. You may check 'My Grades' in the Student Portal to see if the subjects for Semester 2 has been encoded by January 12, 2024.</p>
    </div>
    <div class="flex items-center justify-center mt-6">
        <a href="/home" class="btn btn-primary w-24">Home</a>
    </div>
</div>
</div>
<!-- END: Enrollment Success Message -->

<!-- BEGIN: Enrollment Failed Message -->
<div id="enrollmentFailed" class="hidden">

    <div class="intro-y box py-10 sm:py-20 mt-5 bg-red-100 border-red-200 dark:bg-red-900 dark:border-red-800 animate-fade-in">
        <div class="text-center mb-4">
            <i class="fas fa-times-circle text-danger text-4xl mx-auto fa-beat"></i>
            <h2 class="text-2xl font-semibold mt-2">Enrollment Unsuccessful</h2>
        </div>
        <div class="text-center text-red-700 mt-4">
            <p class="mb-2">We apologize, but your enrollment could not be processed.</p>
            <p>Please try again later or contact our support team for assistance.</p>
        </div>
        <div class="flex items-center justify-center mt-6">
            <button class="btn btn-primary w-24" onclick="retryEnrollment()">Retry</button>
        </div>
    </div>
</div>
<!-- END: Enrollment Failed Message -->

<!-- BEGIN: Enrollment Closed Message -->
<div id="enrollmentClosed" class="hidden">
    <div class="intro-y box py-10 sm:py-20 mt-5">
        <div class="text-center">
            <i class="fas fa-times-circle text-red-500 text-4xl mx-auto fa-beat"></i>
            <h2 class="text-2xl font-semibold mt-2">Enrollment is Closed</h2>
        </div>
        <div class="text-center text-gray-600 mt-4">
            <p class="mb-2">We apologize for any inconvenience.</p>
            <p>Enrollment for the current session is now closed.</p>
        </div>
    </div>
</div>
<!-- END: Enrollment Closed Message -->
    @if( auth()->user()->role === 'Admin')
        @include('student.enroll.modals.enrollment_settings')
        @include('student.enroll.modals.report_list')
    @endif

@endsection

@section('scripts')
     @livewireScripts
    @powerGridScripts
<script>
    var _token = $('meta[name="csrf-token"]').attr('content');
    var bpath = '';
    const enrollmentClosedSection = document.getElementById('enrollmentClosed');

$(document).ready(function() {

    bpath = __basepath + "/";
    // Get the user ID, semester, and academic year from the Blade template
    const studid = "{{ $enrollmentSettings['studid'] }}";
    //  console.log('studid:', studid);
    const semesterValue = "{{ $enrollmentSettings['semester'] }}";
    const academicYearValue = "{{ $enrollmentSettings['academicYear'] }}";
    const enrollmentStatusValue = "{{ $enrollmentSettings['enrollmentStatus'] }}";

    // Call the enrollment check function
    checkEnrollment(studid, semesterValue, academicYearValue, enrollmentStatusValue);

    editPhoneNumber();

});

// Function to check enrollment status
function checkEnrollment(studid, semester, academicYear, enrollmentStatus) {
    // Perform the AJAX request to check the enrollment status
    $.ajax({
        url: bpath + 'student-enroll/check-enrollment',
        type: 'POST',
        dataType: 'json',
        data: {
            studid: studid,
            semester: semester,
            academicYear: academicYear,
            _token: _token,
        },
        success: function(data) {
            console.log('Data returned:', data);
            if (data.enrolled) {
                // If the user is enrolled, show the enrollment success message
                showEnrollmentSuccess();
            } else if (enrollmentStatus === '0') {
                // If enrollment status is closed, show the enrollment closed message
                showEnrollmentClosed();
            } else {
                // If the user is not enrolled and enrollment is open, show the enrollment form
                enrollmentForm.classList.remove('hidden');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            // If there's an error, show the enrollment form as a fallback
            enrollmentForm.classList.remove('hidden');
        },
    });
}

function showEnrollmentClosed() {
    // Hide the enrollment form
    enrollmentForm.classList.add('hidden');
    // Show the enrollment closed message
    enrollmentClosedSection.classList.remove('hidden');
}


    function confirmEnrollment() {

        // Using SweetAlert2 for animated confirmation
        let phone_number = $('#phone-number').val();
        if(phone_number == '')
            {
                Swal.fire({
                    title: 'Missing Required Fields!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#1E40AF',
                    confirmButtonText: 'Okay!',
                });

            }else {
            Swal.fire({
                title: 'Submission Confirmation',
                text: 'Are you sure you want to submit intent to enroll?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1E40AF',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!',
                cancelButtonText: 'Nope!'
            }).then((result) => {
                if (result.isConfirmed) {
                    enrollButton.disabled = true; // Disable the enroll button to prevent multiple clicks
                    enrollStudent();
                }
            });
        }
    }

    function enrollStudent() {

        const semesterValue = document.getElementById('semester').value;
        const academicYearValue = document.getElementById('academicYear').value;
        const enrollmentStatusValue = document.getElementById('enrollmentStatus').value;
        const studid = {{ auth()->user()->studid }};



        // Perform any enrollment-related tasks here (e.g., submit form data to the server)
        const enrollmentData = {

            semester: semesterValue,
            academicYear: academicYearValue,
            enrollmentStatus: enrollmentStatusValue,
            fullName: $('#full-name').text().trim(),
            emailAddress: $('#email-address').text().trim(),
            phoneNumber: $('#phone-number').val(),
            courseProgram: $('#course-program').text().trim(),
            address: $('#address').text().trim(),
            studentLevel: $('#student-level').text().trim(),
            semesterAllowSem: $('#semester-allow-sem').text().trim(),
            academicYearAllowSy: $('#academic-year-allow-sy').text().trim(),

            _token: _token,
        };

        // Perform the enrollment request using AJAX
        $.ajax({
            url: bpath + 'student-enroll/enroll',
            type: 'POST',
            dataType: 'json',
            data: enrollmentData,
            success: function(data) {

                // console.log('Data returned:', data);

                if (data.success) {
                    showEnrollmentSuccess();
                } else {
                    showEnrollmentFailed();
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                showEnrollmentFailed();
            },
            complete: function() {
                if (enrollButton.disabled) {
                    // showEnrollmentSuccess();
                }
            },
        });
    }

    function retryEnrollment() {
        // Hide the failed message
        enrollmentFailedSection.classList.add('hidden');
        // Show the enrollment form
        // enrollmentFormTitle.style.display = 'block';
        enrollmentForm.classList.remove('hidden');

        // Enable the "Enroll" button again
        enrollButton.disabled = false;
    }

    function showEnrollmentSuccess() {
        // enrollmentFormTitle.style.display = 'none';
        enrollmentForm.classList.add('hidden');
        enrollmentSuccessSection.classList.remove('hidden');
    }

    function showEnrollmentFailed() {
        // enrollmentFormTitle.style.display = 'none';
        enrollmentForm.classList.add('hidden');
        enrollmentFailedSection.classList.remove('hidden');
    }

    const enrollButton = document.getElementById('enrollButton');
    // const enrollmentFormTitle = document.querySelector('.intro-y.text-lg.font-medium.mr-auto');
    const enrollmentForm = document.querySelector('.intro-y.box');
    const enrollmentSuccessSection = document.getElementById('enrollmentSuccess');
    const enrollmentFailedSection = document.getElementById('enrollmentFailed');



 // Function to handle the AJAX request
    function loadEnrollmentList() {
        // Get selected filter criteria
        var filterYear = $('#filter_year').val();
        var filterSem = $('#filter_sem').val();
        var filterYearLevel = $('#filter_year_level').val();
        var filterProgram = $('#filter_program').val();

        // AJAX request to fetch the data
        $.ajax({
            url: bpath + 'student-enroll/enrollment-print-list', // Replace this with the URL to your server endpoint
            type: 'GET',
            data: {
                filter_year: filterYear,
                filter_sem: filterSem,
                filter_year_level: filterYearLevel,
                filter_program: filterProgram,
            },
            success: function (data) {
                // Open a new page with the retrieved data for printing

                var newWindow = window.open('', '_blank');
                newWindow.document.write(data);
                newWindow.document.close();
            },
            error: function (xhr, status, error) {
                alert('An error occurred while fetching data. Please try again later.');
            }
        });
    }

    // Bind the click event to the "Print" button
    $(document).on('click', '#load_enrollment_list', function () {
        loadEnrollmentList();
    });


    function editPhoneNumber(){

        $('body').on('click', '.btn_edit_phoneNumber', function(){


            let phone_number = $(this).data('contact');

            $('#contact_Number').val(phone_number);

            const myModal = tailwind.Modal.getInstance(document.querySelector("#update_phoneNumber_mdl"));
            myModal.toggle();

        });


        $('body').on('click', '.btn_update_phoneNumber', function(){

            let phoneNumber = $('#contact_Number').val();

            console.log(phoneNumber);

            if(phoneNumber == '')
            {
                __notif_show(-1, 'Warning', 'Please provide your phone number');

            }else {
                let data = {

                    _token,
                    student_id : $('#student_id').val(),
                    student_phoneNumber : phoneNumber,

                };

                // Perform the enrollment request using AJAX
                $.ajax({
                    url: bpath + 'student-enroll/update/phone/number',
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    success: function(data) {

                        location.reload();

                    },
                    complete: function() {

                    },
                });
            }


        });
    }

</script>
@endsection
