@extends('layouts.app')

@section('content')


<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 2xl:col-span-9">
            <!-- BEGIN: General Report -->
            <div class="col-span-12 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                 Dashboard
                    </h2>
                  
                </div>
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-lucide="user" class="report-box__icon text-primary"></i>
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-primary tooltip cursor-pointer" title="View Employees">View<i data-lucide="chevron-up" class="w-4 h-4 ml-0.5"></i> </div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6"></div>
                                <div class="text-base text-slate-500 mt-1">Students</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-lucide="gauge" class="report-box__icon text-primary"></i>
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-primary tooltip cursor-pointer" title="View Leave Count">View<i data-lucide="chevron-down" class="w-4 h-4 ml-0.5"></i> </div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6"></div>
                                <div class="text-base text-slate-500 mt-1">Grade locking</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-lucide="user-check" class="report-box__icon text-primary"></i>
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-primary tooltip cursor-pointer" title="View Approved Leave">View<i data-lucide="chevron-up" class="w-4 h-4 ml-0.5"></i> </div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6"></div>
                                <div class="text-base text-slate-500 mt-1">Grade Unlocking</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-lucide="slash" class="report-box__icon text-primary"></i>
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-primary tooltip cursor-pointer" title="View Disapproved Leave">View<i data-lucide="chevron-up" class="w-4 h-4 ml-0.5"></i> </div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6"></div>
                                <div class="text-base text-slate-500 mt-1">Dropped Counts</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <div class="intro-y box mt-5">

                <div id="boxed-tab" class="p-5">
            <div id="boxed-tab" class="p-5">
                <div class="preview">
                    <ul class="nav nav-boxed-tabs" role="tablist">
                       
                        <li id="listofemployee-3-tab" class="nav-item flex-1" role="presentation">
                            <button class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#listofemployee-3-tab" type="button" role="tab" aria-controls="listofemployee-3-tab" aria-selected="true" >LIST OF Students</button>
                        </li>
                   
       
                      <li id="hr_approval-7-tab" class="nav-item flex-1" role="presentation">
                        <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#hr_approval-7-tab" type="button" role="tab" aria-controls="hr_approval-7-tab" aria-selected="false" >Locked Grade</button>
                    </li>

                </ul>


{{--Start Submitted Leave Application table --}}                        
                <div class="tab-content mt-5">
                    <div id="listofemployee-3-tab" class="tab-pane leading-relaxed active" role="tabpanel" aria-labelledby="listofemployee-3-tab">        
                        <i class="fa fa-users"></i>Grading Sheet Module <p style="text-align:right;">
                        <table class="table table-bordered table-striped" id="employee_leave_Details">
                            <thead>
                                <tr>
                                    <th>ID Number</th>
                                    <th>Name</th>
                                    <th>Mid-Term</th>
                                    <th>Final Term</th>
                                    <th>Final Grade</th>
                                    <th>Remarks</th>
                                    <th>Registered</th>
                                    <th>Graduating</th>
                                </tr>
                            </thead>
                            </table>
                </div>
{{--End  Submitted Leave Application table --}}


{{-- Start Employees Submitted Leave Application--}}
                         
                <div id="hr_approval-7-tab" class="tab-pane leading-relaxed" role="tabpanel" aria-labelledby="hr_approval-7-tab">   
                    <table class="table table-bordered table-striped" id="hr_approval_submitted_leave_application"> 
                        <thead>
                            <tr>
                                <th>ID Number</th>
                                <th>Name</th>
                                <th>Mid-Term</th>
                                <th>Final Term</th>
                                <th>Final Grade</th>
                                <th>Remarks</th>
                                <th>Registered</th>
                                <th>Graduating</th>
                            </tr>
                        </thead>
                        </table>
                 </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script src="../js/leave/leave_module.js"></script>
    <script src="../js/leave/submitted_leave.js"></script>
    <script src="../js/leave/attachments_for_leave.js"></script>
    {{-- <script src="../js/leave/emp_leave_set_details.js"></script> --}}
@endsection()

