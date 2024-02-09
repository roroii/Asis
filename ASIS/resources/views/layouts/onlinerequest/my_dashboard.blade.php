@extends('layouts.app')

@section('content')

<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 2xl:col-span-10">
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: General Report -->
            <div class="col-span-12 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                   My Dashboard
                    </h2>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                   <i data-lucide="user" class="report-box__icon text-primary"></i>
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-primary tooltip cursor-pointer" title="View ">View<i data-lucide="chevron-up" class="w-4 h-4 ml-0.5"></i> </div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">{{$count_my_request}}</div>
                                <div class="text-base text-slate-500 mt-1">Requested List(Count)</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                     <i data-lucide="gauge" class="report-box__icon text-warning"></i>
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-warning tooltip cursor-pointer" title="View">View<i data-lucide="chevron-down" class="w-4 h-4 ml-0.5"></i> </div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">0</div>
                                <div class="text-base text-slate-500 mt-1">Pending</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                   <i data-lucide="user-check" class="report-box__icon text-success"></i>
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-success tooltip cursor-pointer" title="View">View<i data-lucide="chevron-up" class="w-4 h-4 ml-0.5"></i> </div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">0</div>
                                <div class="text-base text-slate-500 mt-1">Approved</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-lucide="slash" class="report-box__icon text-danger">0</i>
                                    <div class="ml-auto">
                                        <div class="report-box__indicator bg-danger tooltip cursor-pointer" title="View">View<i data-lucide="chevron-up" class="w-4 h-4 ml-0.5"></i> </div>
                                    </div>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">0</div>
                                <div class="text-base text-slate-500 mt-1">Disapproved</div>
                            </div>
                        </div>
                    </div>
                </div>
 
            <!-- END: General Report -->

                
            <!-- BEGIN: Boxed Tab -->
            <div class="intro-y box mt-5">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                    
                        <button class="hidden" href="javascript:;"><i class="fa fa-eye"></i></button>
                    
                    </h2>
              <label style="text-align: left; font-weight: bold; color: white;" class="form-control" hidden>{{ $student_fullname}}</label><BR>
              <label style="text-align: left; font-weight: bold; color: white;" class="form-control" hidden>{{ $student_course}} - {{$student_level}}</label> 
                   

         
                   <button href="javascript:;" data-tw-toggle="modal" data-tw-target="#online_request_modal" class="btn btn-sm btn-primary w-30 mr-1 mb-2"> <span class="mr-1"><i class="fa-solid fa-location-arrow"></i></span>New Request</button>
               

                </div>
              
            <div id="boxed-tab" class="p-5">

    
                  
   <i class="fa fa-list"></i>&nbsp Requested List<p style="text-align:right;">

{{--StartList of Online Requesttable --}}                        
                <div class="tab-content mt-5">
                    <div id="listofemployee-3-tab" class="tab-pane leading-relaxed active" role="tabpanel" aria-labelledby="listofemployee-3-tab">        
                     
                         <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                               <table class="table table-bordered table-striped "  id="my_dashboard_table"style="font-size: 12px;">
                            <thead>
                                <tr>
                                <th>Office</th>
                                <th>Type</td>
                                <th>Purpose</th>
                                <th>Copies</th>
                                <th>Requested Date</th>
                                <th>Approved Date</th>
                                <th>Recieved Date</th>
                                <th>Status</th>
                                <th>Download</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            </table>
                </div>
            </div>


@include('layouts.onlinerequest.modal.online_request')
@include('layouts.onlinerequest.modal.recieve_action_modal')

@endsection

@section('scripts')
      <script src={{ asset('js/ASIS_js/OnlineRequest.js') }}></script>
      
@endsection()