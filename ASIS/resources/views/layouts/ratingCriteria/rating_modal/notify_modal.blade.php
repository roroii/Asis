<!-- BEGIN: Super Large Modal Content -->
<div id="notifyier_modal" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="absolute top-0 right-0 "><button id="btn_cancel_applicant_modal"data-tw-dismiss=modal><i data-lucide="x" class="w-5 h-5 text-slate-500"></i></button></div>
            <div class="modal-body p-10 text-center">
                
                   <form id="2ndInterview_form" action="" enctype="multipart/form-data">
                    @csrf
                        <input type="hidden" name="rated_id" id="rated_id">
                        <input type="hidden" name="position_id" id="position_id">
                        <input type="hidden" name="job_ref" id="job_ref">
                        <input type="hidden" name="applicant_id" id="applicant_id">

                        <div class="text-center lg:text-left p-2">

                            <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5">
                                    <i class="fa fa-user"></i> <span class="ml-2">Applicant Name:</span><label id="applicant_name"class="ml-2 font-medium"></label>
                                </div>
                                <div class="mt-5">
                                    <div class="flex items-center justify-center lg:justify-start text-slate-500 mt-1">
                                        <i class="fa fa-user"></i> <span class="ml-2">Proceeded By:</span> <label id="proceeded_by"class="ml-2 font-medium"></label>
                                    </div>
                                    <div class="flex items-center justify-center lg:justify-start text-slate-500 mt-1">
                                        <i class="fa fa-thumbs-up "></i></i> <span class="ml-2">Status:</span> <span class="ml-2"> <label id="status" class="text-success font-medium"></label></span></label>
                                    </div>
                                    <div class="text-center lg:text-right p-2 border-t border-slate-200/60 dark:border-darkmode-400">
                                        

                                        <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                                            <div class="form-label xl:w-64 xl:!mr-10">
                                                <div class="text-left">
                                                    <div class="flex items-center">
                                                        <div class="font-medium mb-2">Set Interview Schedule</div>
                                                        <div class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md requiredClass">Required</div>
                                                    </div>
                                                    <input class="form-control" id="interview_date" name="date" type="date">
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                            <div class="text-center lg:text-right p-2 border-t border-slate-200/60 dark:border-darkmode-400">
                                {{-- <button type="submit" class="btn btn-primary">Save</button> --}}
                                <button type="submit" class="btn btn-primary w-auto mr-2"><i class="fa fa-paper-plane mr-2" aria-hidden="true"></i>  Send </button>
                            </div>
                          
                        </div>
                    </form>
                 
                
            </div>
        </div>
    </div>
</div> <!-- END: Super Large Modal Content -->

