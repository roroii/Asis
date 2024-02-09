@extends('layouts.app')
@section('breadcrumb')
    {{ Breadcrumbs::render('Dashboard') }}
@endsection
@section('content')

<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Applicant Information
    </h2>
</div>

<input type="hidden" id="applicant_id" value="{{ $applicant_id }}">
<input type="hidden" id="job_ref" value="{{ $job_ref }}">
<input type="hidden" id="short_listID" value="{{ $short_listID }}">
<div class="intro-y box px-5 pt-5 mt-5">
    <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">

        <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
            <div class="w-15 h-15 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                <img alt="Midone - HTML Admin Template"  data-action="zoom" class="rounded-full" src="{{ get_profile_image($applicant_id) }}">
                
            </div>
            <div class="ml-5">
                <div id="applicant_name" class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-medium">{{ $applicant_name }}</div>
                <div class="text-slate-500">{{ $applicant_position }}</div>
            </div>
        </div>
        <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
            <div class="font-medium text-center lg:text-left lg:mt-3">Contact Details</div>
            <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                <div class="truncate sm:whitespace-normal flex items-center"> <i data-lucide="mail" class="w-4 h-4 mr-2"></i> {{ $applicant_email }} </div>
                <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-lucide="smartphone" class="w-4 h-4 mr-2"></i> {{ $applicant_mobile }} </div>
                <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-lucide="phone" class="w-4 h-4 mr-2"></i> {{ $applicant_telephone }} </div>
            </div>
        </div>
        <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
            <div class="font-medium text-center lg:text-left lg:mt-3">Details</div>
            <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                <div class="truncate sm:whitespace-normal flex items-center"> <i data-lucide="user" class="w-4 h-4 mr-2"></i> Approve By &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;:&nbsp;{{ $approve_by }} </div>
                <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-lucide="user" class="w-4 h-4 mr-2"></i> Proceeded By &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;:&nbsp;{{ $proceeded_by }} </div>
                <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-lucide="user" class="w-4 h-4 mr-2"></i> Final Interviewed By &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;:&nbsp;{{ $selected_by }}</div>

            </div>
        </div>
    </div>
    <ul class="nav nav-link-tabs flex-col sm:flex-row justify-center lg:justify-start text-center" role="tablist" >
        
    </ul>
</div>

<div class="intro-y tab-content mt-5">
    <div id="dashboard" class="tab-pane active" role="tabpanel" aria-labelledby="dashboard-tab">
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: position -->

            <div class="col-span-12 sm:col-span-6 2xl:col-span-4 intro-y">
                <div class="box p-5">
                    <div class="flex items-center">
                        
                        <div class="w-full flex-none">
                            <div class="text-slate-500 mt-1">Position Aplied</div>
                            <div class="ml-5 text-lg font-medium">{{ $applied_position }}</div>
                            
                        </div>
                        <div class="flex-none ml-auto relative">
                            <div class="w-[90px] h-[90px]">
                                
                            </div>
                            <div class="font-medium absolute w-full h-full flex items-center justify-center top-0 left-0"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 sm:col-span-6 2xl:col-span-4 intro-y">
                <div class="box p-5">
                    <div class="flex items-center">
                        <div class="w-2/4 flex-none">
                            <div class="text-lg font-medium truncate">Total Points</div>
                        </div>
                        <div class="flex-none ml-auto relative">
                            <div class="w-[90px] h-[90px]">
                                <canvas id="report-donut-chart-1" width="72" height="72" style="display: block; box-sizing: border-box; height: 90px; width: 90px;"></canvas>
                            </div>
                            <div class="font-medium text-lg absolute w-full h-full flex items-center justify-center top-0 left-0">{{ $pointsss }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 sm:col-span-6 2xl:col-span-4 intro-y">
                <div class="box p-5">
                    <div class="flex items-center">
                        <div class="w-full flex-none">
                            <div class="text-lg font-medium truncate">Status</div>
                            <div class="text-center text-lg text-slate-500 mt-1 text-{{ $status_class }}"> {{ $applicant_status }}</div>
                        </div>
                        <div class="flex-none ml-auto relative">
                            <div class="w-[90px] h-[90px]">
                                
                            </div>
                            <div class="font-medium absolute w-full h-full flex items-center justify-center top-0 left-0"></div>
                        </div>
                    </div>
                </div>
            </div>
  
            <!-- END: Position -->
            <!-- BEGIN: Rater-->
            <div class="intro-y box col-span-12 lg:col-span-6">
                <div class="flex items-center px-5 py-5 sm:py-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Rater's
                    </h2>
                   
                </div>
                <div class="p-5">
                    <div class="relative flex items-center">
                       
                        <div class="ml-4 mr-auto">
                            <h2 href="" class="font-medium">Rater/s Name</h2> 
                        </div>
                       
                        <div class="font-medium text-slate-600 dark:text-slate-500">Points</div>
                    </div>
                    @foreach ($raters as $rater)

                        @php
                            $rater_name = '';
                            $rater_position = '';
                            $points = '';
                            $rater_id = '';
                            if($rater){


                                $rater_profile = $rater->get_rater_prof;
                                $agency_position = $rater->get_rater_position;

                                if($rated_check_in_value !=0){
                                    $points = $rater->rate.'%';
                                }else{
                                    $points = $rater->average;
                                }
                                
                                $rater_id = $rater->rated_by;
                                    if ( $rater_profile) {
                                        $rater_name =  $rater_profile->firstname.' '. $rater_profile->mi.' '. $rater_profile->lastname.' '. $rater_profile->extension;
                                    }

                                    if($agency_position){
                                        $position = $agency_position->get_position;
                                        if( $position){
                                            $rater_position = $position->emp_position;
                                        }
                                    }

                            }
                                
                        @endphp
                        
                                    <div class="relative flex items-center mt-5">
                                        <div class="w-12 h-12 flex-none image-fit">
                                            <img alt="Midone - HTML Admin Template" data-action="zoom" class="rounded-full" src="{{ get_profile_image($rater_id) }}">
                                        </div>
                                        <div class="ml-4 mr-auto">
                                            <a id="{{ $rater->rater_agency_id }}" data-rater-name="{{ $rater_name }}" data-points="{{ $points }}" data-check-value="{{ $rated_check_in_value }}" href="javascript:;" class="font-medium rater_click">{{ $rater_name }}</a> 
                                            <div class="text-slate-500 mr-5 sm:mr-5">{{  $rater_position }}</div>
                                        </div>
                                        <div class="font-medium text-slate-600 dark:text-slate-500">{{ $points }}</div>
                                    </div>

                        
                    @endforeach
                   
                    
                </div>
            </div>
            <!-- END: Rater -->
           
            <!-- BEGIN: Criteria Points -->
            <div class="intro-y box col-span-12 lg:col-span-6">
                <div class="flex items-center px-5 py-5 sm:py-0 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 id="rater_name" class="font-medium text-base mr-auto">
                        Rated By
                    </h2>
                   
                    <ul class="nav nav-link-tabs w-auto ml-auto hidden sm:flex" role="tablist" >
                        <li id="latest-tasks-new-tab" class="nav-item" role="presentation"> <a href="javascript:;" class="nav-link py-5 active" >Average Points:  </a> </li>
                        <li id="latest-tasks-last-week-tab" class="nav-item" role="presentation"> <a id="rater_point" href="javascript:;" class="nav-link py-5" data-tw-target="#latest-tasks-last-week" aria-selected="false" role="tab" > 0</a> </li>
                    </ul>
                </div>
                
                <div id="crit_points" class="p-2">
                    
                </div>
                <div id="ramarks_div" class="flex items-center px-5 py-5 sm:py-0 border-b border-slate-200/60 dark:border-darkmode-400">

                    <h2 class="font-medium text-base mr-5">
                        Rater Remark: 
                    </h2>

                    <h5 id="rater_remark" class="font-medium">
                        xcvfdgfdgfdg
                    </h5>

                </div>
            </div>
            <!-- END: Criteria Points -->
           
        </div>

        
    </div>

    <div class="intro-y box col-span-12 lg:col-span-12 mt-5">
                 
        <div id="faq-accordion-2" class="accordion accordion-boxed">
            <div class="accordion-item">
                <div id="faq-accordion-content-5" class="accordion-header"> <button class="accordion-button" type="button" data-tw-toggle="collapse" data-tw-target="#faq-accordion-collapse-5" aria-expanded="true" aria-controls="faq-accordion-collapse-5"> General First Interview Note </button> </div>
                <div id="faq-accordion-collapse-5" class="accordion-collapse collapse show" aria-labelledby="faq-accordion-content-5" data-tw-parent="#faq-accordion-2">
                    <div class="accordion-body text-slate-600 dark:text-slate-500 leading-relaxed">{{ $firstNote }}</div>
                </div>
            </div>
            <div class="accordion-item">
                <div id="faq-accordion-content-6" class="accordion-header"> <button class="accordion-button collapsed" type="button" data-tw-toggle="collapse" data-tw-target="#faq-accordion-collapse-6" aria-expanded="false" aria-controls="faq-accordion-collapse-6"> Second Interview Note </button> </div>
                <div id="faq-accordion-collapse-6" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-6" data-tw-parent="#faq-accordion-2">
                    <div class="accordion-body text-slate-600 dark:text-slate-500 leading-relaxed">{{ $secondNote }}</div>
                </div>
            </div>
            
        </div>
    </div>
</div>

@include('ratingCriteria.rating_modal.rater_area_info_modal')

@endsection
@section('scripts')

<script  src="{{ asset('/js/rating/ratedApplicant.js') }}"></script>

@endsection