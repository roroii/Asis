 <!-- BEGIN: Medium Modal Content -->
 <div id="applicant_details" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-10">
                <div class="intro-y col-span-12 md:col-span-6 lg:col-span-4 xl:col-span-3">
                        <div class="p-5">
                            <div class="h-40 2xl:h-56 image-fit rounded-md overflow-hidden before:block before:absolute before:w-full before:h-full before:top-0 before:left-0 before:z-10 before:bg-gradient-to-t before:from-black before:to-black/10">
                                <img id="image" alt="Midone - HTML Admin Template" class="rounded-full" src="">
                                <div class="absolute bottom-0 text-white px-5 pb-6 z-10">
                                    <label  id="applicant_name" href="" class=" font-medium text-base"></label>
                                    <div>
                                        <span id="applied_position" class="text-white/90 text-xs"></span>
                                        <span id="assign_aggency" class="text-white/90 text-xs"></span>
                                    </div>
                                </div>
                            </div>

                            <div id="Stat_info" class="accordion  mt-4">
                                <div class="accordion-item">
                                    <div id="faq-accordion-content-5" class="accordion-header"> <button class="accordion-button" type="button" data-tw-toggle="collapse" data-tw-target="#faq-accordion-collapse-5" aria-expanded="true" aria-controls="faq-accordion-collapse-5"> <i class="fa fa-circle-info mr-2 text-success"></i> Status Info </button> </div>
                                    <div id="faq-accordion-collapse-5" class="accordion-collapse collapse show" aria-labelledby="faq-accordion-content-5" data-tw-parent="#faq-accordion-2">
                                        <div class="accordion-body text-slate-600 dark:text-slate-500 leading-relaxed">
                                            <div class="text-slate-600 dark:text-slate-500 mt-5">
                                                <div class="flex items-center "> <i class="fa fa-calendar mr-2"></i> Applied Date: <span  class="ml-2 font-medium text-sm" id="date-applied"></span></div>
                                                <div class="flex items-center mt-2 "> <i class="fa fa-thumbs-up mr-2"></i> Approval Date: <span  class="ml-2 font-medium text-sm" id="approval-date"></span></div>
                                                <div class="flex items-center mt-2 "> <i class="fa fa-user-tie mr-2"></i> Approved By: <span  class="ml-2 font-medium text-sm" id="approve_by"></span></div>
                                                <div class="flex items-center mt-2 "> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> Status: <span  class="ml-2 font-medium text-sm" id="status"> </span></div>
                                                <a href="javascript:;" class="flex items-center mt-3 " data-tw-toggle="modal" data-tw-target="#comment_modal"> <i class="fa fa-comment text-success mr-2"></i> Comments <span  class="ml-2 font-medium" id="status"> </span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="Attachments" class="accordion ">
                                <div class="accordion-item">
                                    <div id="faq-accordion-content-5" class="accordion-header"> <button class="accordion-button" type="button" data-tw-toggle="collapse" data-tw-target="#faq-accordion-collapse-5" aria-expanded="true" aria-controls="faq-accordion-collapse-5"> <i class="fa fa-file mr-2 btn-secondary"></i> Attachments  </button> </div>
                                    <div id="faq-accordion-collapse-5" class="accordion-collapse collapse show" aria-labelledby="faq-accordion-content-5" data-tw-parent="#faq-accordion-2">
                                        <div class="accordion-body text-slate-600 dark:text-slate-500 leading-relaxed">
                                            <div id="applicant_attachment" class="intro-y applicant_attachment">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="edit_applicant" class="accordion">
                                <div class="accordion-item">
                                    <div id="faq-accordion-content-5" class="accordion-header"> <button class="accordion-button" type="button" data-tw-toggle="collapse" data-tw-target="#faq-accordion-collapse-5" aria-expanded="true" aria-controls="faq-accordion-collapse-5"> <i class="fa fa-file-pen"></i> Edit applicant  </button> </div>
                                    <div id="faq-accordion-collapse-5" class="accordion-collapse collapse show" aria-labelledby="faq-accordion-content-5" data-tw-parent="#faq-accordion-2">
                                        <div class="accordion-body text-slate-600 dark:text-slate-500 leading-relaxed">
                                            <div class="mt-2">
                                                <label  class="form-label font-medium">Examination result</label>
                                                    <div>
                                                        <select id="exam_result" class="w-full h-9">
                                                            @forelse(get_pass_or_failed('') as $codes)
                                                            <option></option>
                                                            <option value="{{ $codes->id}}">{{ $codes->name }}</option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                    <div class=" relative w-70 mx-auto mt-2">
                                                        <label class="font-medium ">Set Schedule Date for Interview</label>
                                                        <div class="absolute rounded-l w-10 h-10 flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400 mt-2">
                                                            <i data-lucide="calendar" class="w-4 h-4"></i>
                                                        </div>
                                                        <input id="appointment_shcedule" type="text" class="datepicker form-control pl-12 h-10 mt-2" data-single-mode="true">
                                                    </div>
                                                    <div class="mt-2">
                                                        <div> <label for="modal-form-1" class="form-label font-medium">Update Status</label>
                                                            <div >
                                                                <select id="status_details" class="w-full h-9">
                                                                    @forelse(get_status_codes() as $codes)
                                                                    <option></option>
                                                                    <option value="{{ $codes->id}}">{{ $codes->name }}</option>
                                                                    @empty
                                                                    @endforelse
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-4">
                                                        <label for="modal-form-1" class="form-label font-medium">Add Comment</label>
                                                        <textarea id="notes" onchange="" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border" placeholder="Enter notes" ></textarea>
                                                    </div>

                                                    <button id="btn_save_applicant_info" class="btn btn-primary py-1 px-3 mt-2">Save</button>
                                                    <button id="btn_send_email_notification" class="btn btn-primary py-1 px-3 mt-2 ml-2" data-tw-toggle="modal" data-tw-target="#send_email_notification" >Send email</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-center lg:justify-end items-center p-5 border-t border-slate-200/60 dark:border-darkmode-400">
                            <a class="flex items-center mr-3" href="javascript:;" data-tw-dismiss="modal"> <i class="fa fa-xmark text-danger mr-1"></i> Cancel</a>
                        </div>
                </div>

            </div>
        </div>
    </div>
</div> <!-- END: Medium Modal Content -->

<!--modal comment -->
 <div id="comment_modal" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="absolute top-0 right-0"><button id="btn_cancel_applicant_modal"data-tw-dismiss=modal><i class="fa-sharp fa fa-circle-xmark w-5 h-5 text-danger mr-2 mt-1"></i></button></div>
            <div class="modal-body p-10 text-center">
                <label class="flex items-center font-medium">Comments:</label>
                <textarea id="coments" rows="6" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-500 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mt-2" placeholder="" disabled></textarea>
            </div>
        </div>
    </div>
</div>

<!--attachments modal -->
{{-- <div id="shorlisted_attachment" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="absolute top-0 right-0"><button id="btn_cancel_applicant_modal"data-tw-dismiss=modal><i class="fa-sharp fa fa-circle-xmark w-5 h-5 text-danger mr-2 mt-1"></i></button></div>
          <!-- BEGIN: Modal Header -->
          <div class="modal-header">
            <h2 class="font-medium text-base mr-auto"></h2> <button class="btn btn-outline-secondary hidden sm:flex"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Download Docs </button>
            <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>
                <div class="dropdown-menu w-40">
                    <ul class="dropdown-content">
                        <li> <a href="javascript:;" class="dropdown-item"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Download Docs </a> </li>
                    </ul>
                </div>
            </div>
        </div> <!-- END: Modal Header -->
        <!-- BEGIN: Modal Body -->
        <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
            <div class="col-span-12 sm:col-span-6"> <label for="modal-form-1" class="form-label">From</label> <input id="modal-form-1" type="text" class="form-control" placeholder="example@gmail.com"> </div>
            <div class="col-span-12 sm:col-span-6"> <label for="modal-form-2" class="form-label">To</label> <input id="modal-form-2" type="text" class="form-control" placeholder="example@gmail.com"> </div>
            <div class="col-span-12 sm:col-span-6"> <label for="modal-form-3" class="form-label">Subject</label> <input id="modal-form-3" type="text" class="form-control" placeholder="Important Meeting"> </div>
            <div class="col-span-12 sm:col-span-6"> <label for="modal-form-4" class="form-label">Has the Words</label> <input id="modal-form-4" type="text" class="form-control" placeholder="Job, Work, Documentation"> </div>
            <div class="col-span-12 sm:col-span-6"> <label for="modal-form-5" class="form-label">Doesn't Have</label> <input id="modal-form-5" type="text" class="form-control" placeholder="Job, Work, Documentation"> </div>
            <div class="col-span-12 sm:col-span-6"> <label for="modal-form-6" class="form-label">Size</label> <select id="modal-form-6" class="form-select">
                    <option>10</option>
                    <option>25</option>
                    <option>35</option>
                    <option>50</option>
                </select> </div>
        </div> <!-- END: Modal Body -->
        </div>
    </div>
</div> --}}

