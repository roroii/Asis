<!-- BEGIN: Super Large Modal Content -->
<div id="addDevelopment_activity_modal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <a id="cancel_develop_activity" data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x" class="w-8 h-8 text-slate-500"></i> </a>
            <!-- BEGIN: Modal Header -->
            <div class="alert alert-danger" style="display:none"></div>

            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">
                    
                    DEVELOPMENT PLAN 
                    
                    {{-- <span class="ml-3 text-success text-small underline">
                        <a id="viewActivity_btn" href="javascript:;"> <i class="fa fa-minus-circle" aria-hidden="true"></i> </a>
                    </span>  --}}
                    
                </h2> 
            </div>
            <!-- END: Modal Header -->

            <!-- BEGIN: Modal Body -->
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                <div class="col-span-12 sm:col-span-12">
                    <div class="intro-y">

                        

                        <form id="addDev_plan_form" enctype="multipart/form-data">
                            @csrf
                            <!--1-->
                            <input type="hidden" id="idp_id_plan" name="idp_id_plan">
                            <input type="hidden" value="0" id="activityID" name="activityID">
                            <div class="input-form mb-2">
                                <div class="grid grid-cols-12 gap-4 gap-y-3">
                                    <div class="flex input-form col-span-12 lg:col-span-12">
                                        <a id="addActivity_btn" href="javascript:;" class="btn btn-primary ml-auto"> <i class="fa fa-plus-circle" aria-hidden="true"></i> </a>
                                        <a id="viewActivity_btn" href="javascript:;" class="btn btn-danger ml-auto"> <i class="fa fa-minus-circle" aria-hidden="true"></i> </a>
                                    </div>

                                  
                                </div>
                                
                            </div>
                            <div id="div_development_plan_textboxes" class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5 mb-5">

                                
                                <div class="input-form">
                                    <div class="grid grid-cols-12 gap-4 gap-y-3">
                                        <div class="input-form col-span-12 lg:col-span-12">
                                            <h2 id="exclusive_year" class="block font-medium text-base mb-5">
                                                Development Activity <span id="from_year_label"></span><span id="to_year_label"></span>
                                            </h2> 
                                        </div>

                                        <div class="input-form col-span-12 lg:col-span-12">
                                            <textarea name="development_activity" id="development_activity" rows="3" class="form-control" placeholder="....."></textarea>
                                        </div>

                                        
                                    </div>
                                    
                                </div>

                                <div class="input-form">
                                   
                                        <div class="grid grid-cols-12 gap-4 gap-y-3">                                            
                                           
                                            <div class="input-form col-span-12 lg:col-span-12">
                                                <h2 id="exclusive_year" class="block font-medium text-base mb-5">
                                                    Support Needed/Involvement of Others <span id="from_year_label"></span><span id="to_year_label"></span>
                                                </h2> 
                                            </div>

                                            <div class="input-form col-span-12 lg:col-span-12">
                                                <textarea name="development_support" id="development_support" rows="3" class="form-control" placeholder="....."></textarea>
                                            </div>
                                            
                                        </div>
                                    
                                </div>
                               

                            </div>

                             <!--Footer-->
                             <div id="div_footer_plan" class="modal-footer"> 
                               
                                <button type="submit" class="btn btn-primary w-20">Save</button> 
                            </div> 
                            <!-- END: Modal Footer -->

                            <!--Table-->
                            <div id="div_development_plan_table" class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5 mb-5">

                                <table id="activity_table" class="table table-bordered -mt-2 table-hover form-control" style="border:1px solid rgb(9, 8, 8)">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Development Activity</th>
                                            <th>Tracking Method/Completion Date</th>
                                            {{-- <th colspan="3" class="text-center">Support Needed/Involvement of Others</th> --}}
                                            <th>Action</th>
                                        </tr>
                                        {{-- <tr>
                                            
                                            <th class="text-center">Planned</th>
                                            <th class="text-center">Accomplish Mid-Year</th>
                                            <th class="text-center">Accomplish Year-End</th>
                                        </tr> --}}
                                        
                                    </thead>

                                    <tbody>
                                    
                                    </tbody>
                                </table>

                            </div>

                           
                           
                        </form>
                    </div>
                </div>

            </div>
            <!-- END: Modal Body -->

        </div>
    </div>
</div>
<!-- END: Super Large Modal Content -->

