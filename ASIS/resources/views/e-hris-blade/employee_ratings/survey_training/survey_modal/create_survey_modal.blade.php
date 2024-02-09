 <!-- BEGIN: Modal Content -->
 <div id="create_survey_modal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Create Survey on Training Satisfaction</h2>
                <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>
                    <div class="dropdown-menu w-40">
                        <ul class="dropdown-content">
                            <li> <a href="javascript:;" class="dropdown-item"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Download Docs </a> </li>
                        </ul>
                    </div>
                </div>
            </div> <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <form id="survey_modal">
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-12"> <label for="modal-form-1" class="form-label font-semibold">Create indicators</label>
                            <div class="w-full mt-3 xl:mt-0 flex-1">
                                <div id="editor">
                                    <div class="preview">
                                        <textarea name="content" id="editor_textarea_survey" class="editor_textarea_survey" placeholder="Enter your content here">
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-12 overflow-x-auto scrollbar-hidden">
                                <table id="survey_question_table" class="table mt-2 spms_table">
                                    <thead>
                                        <th class="whitespace-nowrap" hidden> ID </th>
                                        <th class="whitespace-nowrap" hidden> textarea </th>
                                        <th class="whitespace-nowrap"> Survey Questionaire </th>
                                        <th class="whitespace-nowrap"> Action </th>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </form>
            <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer"> <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <button id="btn_save_survey_training" type="button" class="btn btn-primary w-20">Send</button> </div> <!-- END: Modal Footer -->
        </div>
    </div>
</div> <!-- END: Modal Content -->
