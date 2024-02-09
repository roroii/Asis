<!-- BEGIN: Super Large Modal Content -->
<div id="add_activity_plan_modal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <a id="cancel_activity_plan" data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x" class="w-8 h-8 text-slate-500"></i> </a>
            <!-- BEGIN: Modal Header -->
            <div class="alert alert-danger" style="display:none"></div>

            <div class="modal-header">
                <h2 class="font-medium text-base text-md-center mr-auto">
                    
                    Support Needed/Involvement of Others                    
                   
                </h2> 
            </div>
            <!-- END: Modal Header -->

            <!-- BEGIN: Modal Body -->
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                <div class="col-span-12 sm:col-span-12">
                    <div class="intro-y">

                        

                        <form id="addActivity_plan_form" enctype="multipart/form-data">
                            @csrf
                                                      
                            <input type="hidden" name="idp_idss" id="idp_idss">
                            <input type="hidden" name="activity_ids" id="activity_ids">

                            <!--Table-->
                            <div id="div_activity_plan_table" class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5 mb-5">

                                <table id="activity_plan_tbl" class="table table-bordered -mt-2 table-hover form-control">
                                    <thead>
                                        <tr>
                                            <th colspan="4" class="text-md-left"><div class="flex">Tracking Method/Completion Date <span class="ml-auto"><a href="javascript:;" class="add-plan-row"><i class="fas fa-plus-square w-4 h-4 text-success"></i> Add Plan</a></span> </div></th>
                                            {{-- <th colspan="3" class="text-center">Support Needed/Involvement of Others</th> --}}
                                            {{-- <th>Action</th> --}}
                                        </tr>
                                        <tr>
                                            <th class="text-center" style="width: 30%">Planned</th>
                                            <th class="text-center" style="width: 30%">Accomplish Mid-Year</th>
                                            <th class="text-center" style="width: 30%">Accomplish Year-End</th>
                                            <th class="text-center" style="width: 10%">Action</th>
                                        </tr>
                                        
                                    </thead>

                                    <tbody>
                                    
                                    </tbody>
                                </table>

                            </div>

                            <!--Footer-->
                            <div id="div_footer_activity_plan" class="modal-footer"> 
                                                        
                                <button type="submit" class="btn btn-primary w-20">Save</button> 
                            </div> 
                            <!-- END: Modal Footer -->
                           
                           
                        </form>
                    </div>
                </div>

            </div>
            <!-- END: Modal Body -->

        </div>
    </div>
</div>
<!-- END: Super Large Modal Content -->

