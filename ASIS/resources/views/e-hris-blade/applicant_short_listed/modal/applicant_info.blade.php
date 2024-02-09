<!-- BEGIN: Super Large Modal Content -->
<div id="" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="absolute top-0 right-0"><button id="btn_cancel_applicant_modal"data-tw-dismiss=modal><i class="fa-sharp fa fa-circle-xmark w-5 h-5 text-danger mr-2 mt-1"></i></button></div>
            <div class="modal-body p-10 text-center">
                <div class="intro-y col-span-12 md:col-span-6 lg:col-span-4">
                    <div class="box">
                        <div class="flex items-start px-5 pt-5">
                            <div class="w-full flex flex-col lg:flex-row items-center">
                                <div class="w-16 h-16 image-fit">
                                    <img id="imagez" alt="Midone - HTML Admin Template" class="rounded-full" src="">
                                </div>
                                <div class="lg:ml-4 text-center lg:text-left mt-3 lg:mt-0">
                                    <strong><label id="applicant_namez" class="font-medium"></label></strong>
                                    <div class="text-slate-500 text-xs mt-0.5"><label id="applied_positionz"></label></div>
                                    <div class="text-slate-500 text-xs mt-0.5"><label id="assign_aggencyz"></label></div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center lg:text-left p-5">
                            <div><strong>Comment</strong></div>
                            <div class="mt-2"><labe id="comentsz"></labe></div>
                            <div class="flex items-center justify-center lg:justify-start text-slate-500 mt-5">
                                <i class="fa fa-calendar-days"></i> <span class="ml-2 font-small">Applied Date:</span> <span class="ml-2"><label id="date-appliedz" class="font-medium"></label></span>
                            </div>
                            <div class="flex items-center justify-center lg:justify-start text-slate-500 mt-1">
                                <i class="fa fa-calendar-days"></i> <span class="ml-2">Approval Date:</span><span class="ml-2"><label id="approval-datez" class="font-medium"></label></span>
                            </div>
                            <div class="flex items-center justify-center lg:justify-start text-slate-500 mt-1">
                                <i class="fa fa-user"></i> <span class="ml-2">Approved By:</span> <label id="approve_byz"class="ml-2 font-medium"></label>
                            </div>
                            <div class="flex items-center justify-center lg:justify-start text-slate-500 mt-1">
                                <i class="fa fa-thumbs-up "></i></i> <span class="ml-2">Status:</span> <span class="ml-2"> <label id="statusz" class="text-success font-medium"></label></span></label>
                            </div>
                            <div id="faq-accordion-2" class="accordion accordion-boxed mt-3">
                                <div class="accordion-item">
                                    <div id="faq-accordion-content-5" class="accordion-header"> <button class="accordion-button" type="button" data-tw-toggle="collapse" data-tw-target="#faq-accordion-collapse-5" aria-expanded="true" aria-controls="faq-accordion-collapse-5"> <i class="fa fa-pen text-success mr-2"></i> Edit Applicant</button> </div>
                                    <div id="faq-accordion-collapse-5" class="accordion-collapse collapse show" aria-labelledby="faq-accordion-content-5" data-tw-parent="#faq-accordion-2">
                                        <div class="mt-2">
                                            <textarea id="notesz" onchange="" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border" placeholder="Enter notes" ></textarea>
                                        </div>
                                        <div class="mt-2">
                                            <div> <label for="modal-form-1" class="form-label font-medium">Examination result</label>
                                                <div >
                                                    <select id="exam_resultz" class="w-full h-9">
                                                        @forelse(get_pass_or_failed('') as $codes)
                                                        <option></option>
                                                        <option value="{{ $codes->id}}">{{ $codes->name }}</option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" relative w-70 mx-auto mt-2">
                                            <label class="font-medium ">Schedule Date</label>
                                            <div class="absolute rounded-l w-10 h-10 flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400 mt-2"> <i data-lucide="calendar" class="w-4 h-4"></i> </div> <input id="appointment_shcedulez" type="text" class="datepicker form-control pl-12 h-10 mt-2" data-single-mode="true">
                                        </div>
                                        <div class="mt-2">
                                            <div> <label for="modal-form-1" class="form-label font-medium">Update Status</label>
                                                <div >
                                                    <select id="status_detailsz" class="w-full h-9">
                                                        @forelse(get_status_codes() as $codes)
                                                        <option></option>
                                                        <option value="{{ $codes->id}}">{{ $codes->name }}</option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center lg:text-right p-7 border-t border-slate-200/60 dark:border-darkmode-400">
                            <button id="btn_save_applicant_infoz" class="btn btn-primary py-1 px-3 mt-2">Save</button>
                            {{-- <button class="btn btn-outline-secondary" data-tw-dismiss="modal">Cancel</button> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- END: Super Large Modal Content -->

