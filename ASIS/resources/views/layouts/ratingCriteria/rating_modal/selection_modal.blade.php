<!-- BEGIN: Modal Content -->
<div id="selection_modal" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
    <div class="modal-dialog modal-medium">
        <div class="modal-content">

            <!-- BEGIN: Modal Header -->
            {{-- <div class="modal-header">
                <h2 class="font-bold text-base mr-auto"></h2>
                
                <div class="dropdown"> 
                    <a class=" w-5 h-5 block" 
                        id="btn_cancel_listed_modal"
                        href="javascript:;" 
                        data-tw-dismiss="modal"> 
                        <i data-lucide="x" class="w-5 h-5 text-slate-500"></i> 
                    </a>
                    
                </div>
            </div>  --}}
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->


                {{ csrf_field() }}
                <div class="modal-body">

                    <input id="listed_id" name="listed_id" type="hidden">
                    <input id="job_ref" name="job_ref" type="hidden">
                    <input id="applicantName_input" name="applicantName_input" type="hidden">

                    <div class="intro-y col-span-12 md:col-span-6 lg:col-span-4">
                        <div class="box">
                            <div class="flex items-start px-5 pt-5">
                                <div class="w-full flex flex-col lg:flex-row items-center">
                                    
                                    {{-- <div class="w-3/5 h-64 mr-6 float-left image-fit">
                                        <img id="selection_modal_image" alt="Midone - HTML Admin Template" src="" data-action="zoom" class="rounded-full" style="">
                                    </div> --}}                                    

                                    <div class="w-16 h-16 image-fit">
                                        <img id="selection_modal_image" src="" alt="Midone - HTML Admin Template" class="rounded-full" >
                                    </div>
                                    <div class="lg:ml-4 text-center lg:text-left mt-3 lg:mt-0">
                                        <h2 id="select_applicantName" class="font-medium">Applicant Name</h2> 
                                        <div class="text-slate-500 text-xs mt-0.5">Applicant</div>
                                    </div>
                                </div>
                                <div class="absolute right-0 top-0 mr-5 mt-3 dropdown">
                                    <a class=" w-5 h-5 block" 
                                        id="btn_cancel_listed_modal"
                                        href="javascript:;" 
                                        data-tw-dismiss="modal"> 
                                        <i data-lucide="x" class="w-5 h-5 text-slate-500"></i> 
                                    </a>
                                    
                                </div>
                            </div>
                            <div class="text-center lg:text-left p-5">
                                {{-- <h2 class="font-medium">Proceeding Remarks</h2>
                                <div id="remarks"></div> --}}

                                <div id="faq-accordion-2" class="accordion accordion-boxed mb-2">
                                    <div class="accordion-item">
                                        <div id="faq-accordion-content-5" class="accordion-header">
                                            <button class="accordion-button collapsed" 
                                                    type="button" 
                                                    data-tw-toggle="collapse" 
                                                    data-tw-target="#faq-accordion-collapse-5" 
                                                    aria-expanded="false" 
                                                    aria-controls="faq-accordion-collapse-5">Approving Remarks</button>
                                        </div>
                                        <div id="faq-accordion-collapse-5" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-5" data-tw-parent="#faq-accordion-2" style="display: none;">
                                            <div id="remarks"></div>
                                        </div>
                                    </div>
                                   
                                </div>

                                <div id="faq-accordion-2" class="accordion accordion-boxed">
                                    <div class="accordion-item">
                                        <div id="faq-accordion-content-5" class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-tw-toggle="collapse" data-tw-target="#faq-accordion-collapse-5" aria-expanded="false" aria-controls="faq-accordion-collapse-5">Add Notes</button>
                                        </div>
                                        <div id="faq-accordion-collapse-5" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-5" data-tw-parent="#faq-accordion-2" style="display: none;">
                                            <textarea class="form-control" name="pres_notes" id="pres_notes" rows="3" placeholder="Type Notes"></textarea>
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                            <div class="text-center lg:text-right p-5 border-t border-slate-200/60 dark:border-darkmode-400">
                                <button id="btn_cancel_listed_modal"
                                        href="javascript:;" 
                                        data-tw-dismiss="modal" 
                                        class="btn btn-outline-secondary py-1 px-2">
                                        Cancel
                                </button>
                                <button href="javascript:;" id="select_save" class="btn btn-primary py-1 px-2 mr-2 ">Select</button>                                
                            </div>
                        </div>
                    </div>

                </div>
                    <!-- END: Modal Body -->

                <!-- BEGIN: Modal Footer -->
                {{-- <div class="modal-footer">
                    <button type="button" id="btn_cancel_listed_modal" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                </div> --}}
                <!-- END: Modal Footer -->
        </div>
    </div>

</div>  <!-- END: Modal Content -->


