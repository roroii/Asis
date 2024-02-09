@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('My Profile') }}
@endsection

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            INDIVIDUAL DEVELOPMENT PLAN 
        </h2>
    </div>

    <form id="idp_all_form" enctype="multipart/form-data">

        @csrf

        <input value="{{ $idpID }}" type="hidden" name="idp_ids" id="idp_ids">

    <div class="tab-content mt-5">

        <div id="personal_info_tab" class="tab-pane active" role="tabpanel" aria-labelledby="profile-tab">
            <div class="grid grid-cols-12 gap-6">

                <!-- BEGIN: Personal Information -->
                <div class="intro-y box col-span-12 lg:col-span-12">
                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto">
                            Exclusive Year <span id="from_year_label"></span><span id="to_year_label"></span>
                        </h2>
                        {{-- <a id="btn_print_PDS" target="_blank" href="/my/print/pds/{{Crypt::encrypt(Auth::user()->employee)}}" class="btn btn-primary w-32 mr-2 mb-2"> <i data-lucide="printer" class="w-4 h-4 mr-2"></i> Print IDP </a> --}}
                    </div>

                    <!--Begin Exclusive Year-->
                    <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5 mb-5">

                        <div class="input-form">
                                <div class="grid grid-cols-12 gap-4 gap-y-3">
                                    

                                    <div class="input-form col-span-12 lg:col-span-3">
                                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> From Year </label>
                                        <select id="from_year" name="from_year" style="width: 100%" required>
                                            <option></option>
                                            @forelse(loadYears() as $year)
                                                <option value="{{ $year }}" {{ ( $year == $idp_data->year_from) ? 'selected' : '' }}> {{  $year }} </option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="input-form col-span-12 lg:col-span-3">
                                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> To Year </label>
                                        <select id="to_year" name="to_year" style="width: 100%">
                                            <option></option>
                                            <option value="0">Blank</option>
                                            @forelse(loadYears() as $year)
                                                <option value="{{ $year }}" {{ ( $year == $idp_data->year_to) ? 'selected' : '' }}> {{  $year }} </option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>

                                </div>
                            
                        </div>

                    </div>
                    <!--Begin Exclusive Year-->

                    <!--Begin personal Information-->

                            


                            <div class="accordion-item">
                                <div id="faq-accordion-collapse-8" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-8" data-tw-parent="#faq-accordion-2">
                                    <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">

                                        <div class="input-form">
                                           
                                                <div class="grid grid-cols-12 gap-4 gap-y-3">
            
                                                    <input id="idp_id" name="idp_id" class="hidden">           
                                                                
                                                
                                                    <div class="col-span-12 lg:col-span-6">
                                                        <label for="my_position" class="form-label w-full flex flex-col sm:flex-row"> Current Position </label>
                                                        <select id="my_position" name="my_position" style="width: 100%">
                                                            <option></option>
                                                            @forelse(get_position() as $my_position)
                                                                <option value="{{ $my_position->id }}" {{ ( $my_position->id == $idp_data->position_id) ? 'selected' : '' }}> {{  $my_position->emp_position }} </option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                    </div>                                    
            
                                                    <div class="input-form col-span-12 lg:col-span-6">
                                                        <label for="year_n_postision" class="form-label w-full flex flex-col sm:flex-row"> Years in the Position </label>
                                                        <input id="year_n_postision" value="{{ $idp_data->year_n_position }}" name="year_n_postision" type="text" class="form-control" required>
                                                    </div>
            
                                                    <div class="input-form col-span-12 lg:col-span-6">
                                                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Salary Grade </label>
                                                        <select id="my_sg" name="my_sg" style="width: 100%">
                                                            <option></option>
                                                            @forelse(load_salary_grade() as $my_sg)
                                                                <option value="{{ $my_sg->id }}" {{ ( $my_sg->id == $idp_data->sg_id) ? 'selected' : '' }}> {{ $my_sg->name.'  ('.$my_sg->code.')' }} </option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                    </div>
            
                                                    <div class="input-form col-span-12 lg:col-span-6">
                                                        <label for="year_n_agency" class="form-label w-full flex flex-col sm:flex-row">Years in Agency </label>
                                                        <input id="year_n_agency" value="{{ $idp_data->year_n_agency }}" name="year_n_agency" type="text" class="form-control" required>
                                                    </div>
            
                                                    <div class="input-form col-span-12 lg:col-span-6">
                                                        <label for="period" class="form-label w-full flex flex-col sm:flex-row">Three-Year Period </label>
                                                        <input id="period" value="{{ $idp_data->three_y_period }}" name="period" type="text" class="form-control" required>
                                                    </div>
            
                                                    <div class="input-form col-span-12 lg:col-span-6">
                                                        <label for="division" class="form-label w-full flex flex-col sm:flex-row">Division </label>
                                                        <input id="division" value="{{ $idp_data->division }}" name="division" type="text" class="form-control" required>
                                                    </div>
            
                                                    <div class="input-form col-span-12 lg:col-span-6">
                                                        <label for="office" class="form-label w-full flex flex-col sm:flex-row">Office </label>
                                                        <input id="office" value="{{ $idp_data->office }}" name="office" type="text" class="form-control" required>
                                                    </div>
            
                                                    <div class="input-form col-span-12 lg:col-span-6 border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                                        <label for="check_year" class="form-label w-full flex flex-col sm:flex-row"> No further development is desired or required for this year/s (Please check box here)  </label>
                                                        <input id="check_year" name="check_year" value="1" type="radio" class="ml-5 form-check-input" {{ ( $idp_data->develop_year == 1) ? 'checked' : '' }}>
                                                        <label for="check1">Year 1</label> 
                                                        <input id="check_year" name="check_year" value="2" type="radio" class="ml-5 form-check-input" {{ ( $idp_data->develop_year == 2) ? 'checked' : '' }}>
                                                        <label for="check2">Year 2</label>
                                                        <input id="check_year" name="check_year" value="3" type="radio" class="ml-5 form-check-input" {{ ( $idp_data->develop_year == 3) ? 'checked' : '' }}>
                                                        <label for="check3">Year 3</label>
                                                    </div>
            
                                                    <div class="input-form col-span-12 lg:col-span-6">
                                                        <label for="my_supervisor" class="form-label w-full flex flex-col sm:flex-row">  Name of Superior (Last, First, MI)  </label>
                                                        <select id="my_supervisor" name="my_supervisor" style="width: 100%">
                                                            <option></option>
                                                            @forelse(load_employee() as $my_supervisor)
                                                                <option value="{{ $my_supervisor->agencyid }}" {{ ( $my_supervisor->agencyid == $idp_data->emp_id) ? 'selected' : '' }}>{{ $my_supervisor->lastname.', '.$my_supervisor->firstname.' '.$my_supervisor->mi.' '.$my_supervisor->extension}}</option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                    </div>
            
                                                </div>
                                            
                                        </div>
            
                                    </div>
                                </div>
                            </div>
                        
                    
                    <!--End personal Information-->
                </div>


                <!-- BEGIN: COMPETENCY ASSESSMENT AND DEVELOPMENT PRIORITIES -->
                <div class="intro-y box col-span-12 lg:col-span-12">
                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto">
                            PART A: COMPETENCY ASSESSMENT AND DEVELOPMENT PRIORITIES 
                        </h2>
                        <a href="javascript:;" id="add__targetRow_btn" class="ml-auto text-primary truncate flex items-center"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="plus" data-lucide="plus" class="lucide lucide-plus w-4 h-4 mr-1"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Add </a>

                    </div>
                    <div class="intro-y box p-5 targetTable_div">
                        <div class="overflow-x-auto scrollbar-hidden">
                            <table id="idpTaget_table" class="table table-bordered pb-10">
                                    <thead>
                                        <th>#</th>
                                        <th>Development Target</th>
                                        <th>Performance Goal this Supports</th>
                                        <th>Objective</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>

                                        @if($IDP_targetData != '')
                                            @foreach($IDP_targetData as $key => $targetData)
                                                <tr>
                                                    <td style="text-align: justify">
                                                        <input type="hidden" value="{{ $targetData->id }}" class="form-control" name="targetID[]" id="targetID">
                                                        {{ $key+1 }}
                                                    </td>
                                                    <td style="text-align: justify">
                                                        <textarea  id="dev_target" class="form-control hidden" rows="4" name="dev_target[]">{{ $targetData->dev_target }}</textarea>
                                                        <label id="dev_target_label">{{ $targetData->dev_target }}</label>
                                                    </td>
                                                    <td style="text-align: justify">
                                                        <textarea  id="pg_support" class="form-control hidden" rows="4" name="pg_support[]">{{ $targetData->pg_support }}</textarea>
                                                        <label id="pg_support_label">{{ $targetData->pg_support }}</label>
                                                    </td>

                                                    <td style="text-align: justify">
                                                        <textarea  id="objective" class="form-control hidden" rows="4" name="objective[]">{{ $targetData->objective }}</textarea>
                                                        <label id="objective_label">{{ $targetData->objective }}</label>
                                                    </td>
                                                    <td>

                                                        <a id="" href="javascript:;" class="done-edit-idp-target hidden"> <i class="fa fa-check-square  w-4 h-4 text-success" aria-hidden="true"></i> </a>
                                                        <a id="" href="javascript:;" class="edit-idp-target"> <i class="far fa-edit w-4 h-4 text-success"></i> </a>
                                                        <a id="" href="javascript:;" class="remove-row-idp-target"> <i class="fa fa-trash-alt w-4 h-4 text-danger"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                       
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>
                <!-- END: COMPETENCY ASSESSMENT AND DEVELOPMENT PRIORITIES -->


                <!-- BEGIN: DEVELOPMENT PLAN -->
                <div class="intro-y box col-span-12 lg:col-span-12">
                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto">
                            PART B: DEVELOPMENT PLAN 
                        </h2>
                        <a href="javascript:;" id="add__activityRow_btn" class="ml-auto text-primary truncate flex items-center"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="plus" data-lucide="plus" class="lucide lucide-plus w-4 h-4 mr-1"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Add </a>
                    </div>
                    <div class="intro-y box p-5">
                        <div class="overflow-x-auto scrollbar-hidden">
                            <table id="idpActivity_table"  class="table table-bordered pb-10" style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="width: 5%">#</th>
                                        <th rowspan="2" style="width: 20%">Development Activity</th>
                                        <th rowspan="2" style="width: 20%">Tracking Method/Completion Date</th>                                        
                                        <th colspan="3" style="width: 45%" class="text-center">Tracking Method/Completion Date</th>
                                        <th rowspan="2" style="width: 10%">Action</th>
                                    </tr>
                                     <tr>
                                            <th style="width: 15%" class="text-center">Planned</th>
                                            <th style="width: 15%" class="text-center">Accomplish Mid-Year</th>
                                            <th style="width: 15%"class="text-center">Accomplish Year-End</th>
                                        </tr>
                                    
                                </thead>

                                <tbody>
                                   @if($IDP_activityData != '')
                                        @foreach($IDP_activityData as $key => $activityData)
                                            <tr>
                                                <td>
                                                    <input type="hidden" value="{{ $activityData->id }}" class="form-control" name="activityID[]" id="activityID">
                                                    {{ $key+1 }}
                                                </td>
                                                <td>
                                                    <textarea type="text" id="dev_activity" class="form-control hidden" rows="4" name="dev_activity[]"> {{ $activityData->dev_activity }}</textarea>
                                                    <label id="activity_label">{{ $activityData->dev_activity }}</label>
                                                </td>
                                                <td style="text-align: justify">
                                                    <textarea type="text" id="support_needed" class="form-control hidden" rows="4" name="support_needed[]"> {{ $activityData->support_needed }} </textarea>
                                                    <label id="activity_label_support">{{ $activityData->support_needed }}</label>
                                                </td>                                               

                                                <td colspan="3">
                                                    <div style="margin: -20px;">
                                                        <table class="detail-activity-plan-table cursor-pointer table-hover" style="border-collapse: collapse; width: 100%">
                  
                                                            @foreach($getActivity_plan->where('activity_id', $activityData->id) as $key => $plan)
                                                                <tr>
                                                                    <td width="15%" style="border: 0px solid; text-align:justify;">{{ $plan->planned }}</td>
                                                                    <td width="15%" style="border: 0px solid; text-align:justify;">{{ $plan->accom_mid_year }}</td>
                                                                    <td width="15%" style="border: 0px solid; text-align:justify;">{{ $plan->accom_year_end }}</td>
                                                                </tr>
                                                                                                                              
                                                            @endforeach 
                                                        </table>
                                                    </div>
                                                    
                                                </td>
                                                <td style="text-align: justify">
                                                    
                                                    <div class="flex justify-center items-center">
                                                            <a id="" href="javascript:;" class="done-edit-idp-activity ml-2 hidden"> <i class="fa fa-check-square  w-4 h-4 text-success" aria-hidden="true"></i> </a>
                                                            <a id="" href="javascript:;" class="edit-idp-activity ml-2"> <i class="far fa-edit w-4 h-4 text-success"></i> </a>
                                                            <a id="" href="javascript:;" class="remove-row-idp-activity ml-2"> <i class="fa fa-trash-alt w-4 h-4 text-danger"></i></a>

                                                        {{-- <div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in tooltip dropdown" title="More Action">
                                                            <a class="flex justify-center items-center" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h items-center text-center text-primary"></i> </a>
                                                            <div class="dropdown-menu w-auto">
                                                                <div class="dropdown-content">
                                                                    <a class="dropdown-item" href="/IDP/idp-details/'+created_by_id+'">
                                                                        <i class="fa fa-tasks text-success" aria-hidden="true"></i>
                                                                        <span class="ml-2"> Detail </span>
                                                                    </a>
                                                                </div>
                                                                <div class="dropdown-content">
                                                                    <a class="dropdown-item" href="javascript:;">
                                                                        <i class="fa fa-trash text-danger"></i>
                                                                        <span class="ml-2"> delete </span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                   @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END: DEVELOPMENT PLAN -->


            </div>
        </div>



        <!-- END: BUTTON SAVE PDS-->
    </div>


        <div class="cursor-pointer shadow-md fixed bottom-0 right-0 box flex items-center justify-center z-50 mb-10 mr-10 btn_save_PDS_div">
            <div class="flex items-center px-5 py-8 sm:py-3 border-t border-slate-200/60 dark:border-darkmode-400">
                <button type="submit" class="ml-auto btn btn-primary truncate flex items-center"> <i class="w-4 h-4 mr-2" data-lucide="save"></i> Save </button>
            </div>
        </div>
    </form>
    {{-- @include('my_Profile.modal.profile_picture')
    @include('my_Profile.modal.educational_bg_modal')
    @include('my_Profile.modal.add_civil_service_modal')
    @include('my_Profile.modal.add_work_exp_modal')
    @include('my_Profile.modal.add_voluntary_work_modal')
    @include('my_Profile.modal.add_LD_modal')
    @include('my_Profile.modal.add_other_info_modal')
    @include('my_Profile.modal.add_references_modal') --}}
@endsection

@section('scripts')
    <script src="{{ asset('/js/IDP/idp_page.js') }}"></script>
@endsection
