<!-- Add Documents Modal -->
<div id="attach_document_modal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="attach_document_form" method="post" enctype="multipart/form-data">
            @csrf
            <input class="hidden" id="attach_document_form_value">
            <input class="hidden" id="document_identifier">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="alert alert-danger" style="display:none"></div>
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Attach New Documents</h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->

                <div class="modal-body grid grid-cols-1 gap-4 gap-y-3">
                    <label class="form-label w-full flex flex-col sm:flex-row"> Note</label>
                    <textarea style="height: 100px" id="added_attachment_note" class="form-control" name="added_attachment_note" placeholder="Type your description...." ></textarea>
                </div>

                <div class="modal-body grid grid-cols-1 gap-4 gap-y-3">
                    <div id="documentAttachment" class="col-span-12 sm:col-span-6">
                        <label class="form-label w-full flex flex-col sm:flex-row"> Attach Document</label>
                        <input id="attach_new_document"
                               type="file"
                               class="filepond mt-1"
                               name="attach_new_document[]"
                               multiple
                        >
                    </div>
                </div>
                <!-- END: Modal Body -->

                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button id="cancel_attachments_btn" type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                    <button id="add_attachments_btn"  type="submit" class="btn btn-primary w-20 add_attachments_btn">Add</button>

                </div>
                <!-- END: Modal Footer -->
            </div>
        </form>
    </div>
</div>
<!-- END: Modal Content -->

<!-- BEGIN: Overlapping Groups Modal Content -->
<div id="added_documents_creator" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form_added_documents_creator" class="modal-content" method="post">
        @csrf
        <!-- BEGIN: Modal Header -->
            <div class="modal-header flex items-center justify-center">
                <h2 class="font-medium text-base mr-auto">Attachment Details</h2>
            </div>
            <!-- END: Modal Header -->

            <!-- BEGIN: Modal Body -->
            <div class="modal-body">
                <!-- BEGIN: Recent Activities -->
                <div id="added_documents_creator_details" class="col-span-12 md:col-span-6 xl:col-span-4 2xl:col-span-12 mt-3">

                </div>
                <!-- END: Recent Activities -->
                <!-- BEGIN: Nested Select -->
            </div>
            <!-- END: Modal Body -->

            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-primary w-20 mr-">OK </button>
            </div>
            <!-- END: Modal Footer -->
        </form>
    </div>
</div>
<!-- END: Overlapping Groups Modal Content -->

<div id="hold_docs_info" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center"> <i data-lucide="x-circle" class="w-16 h-16 text-warning mx-auto mt-3"></i>
                    <div class="text-3xl mt-5">Oops...</div>
                    <div class="text-slate-500 mt-2">Held documents cannot be release!</div>
                </div>
                <div class="px-5 pb-8 text-center"> <button type="button" data-tw-dismiss="modal" class="btn w-24 btn-primary">Ok</button> </div>
                <div class="p-5 text-center border-t border-slate-200/60 dark:border-darkmode-400"> <a href="https://www.facebook.com/DSSCICTCOfficial" target="_blank" class="text-primary">Contact ICTC Team for more info.</a> </div>
            </div>
        </div>
    </div>
</div>


{{--   Modal for viewing received document attachments    --}}
<div id="received_modal_add_attachments" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <!-- BEGIN: Modal Content -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Document Attachment(s)</h2>
            </div>
            <div class="modal-body ">

                <div id="received_if_no_files_attached" class="col-span-12 sm:col-span-6 "></div>

                {{--        For Original Attachments        --}}
                <div id="div_dt_received_original_attachments" >
                    <div style="border-radius: 0.375rem;" class="alert-primary text-center show p-3">Original Attachment(s)</div>
                    <div class="overflow-x-auto scrollbar-hidden pb-5">
                        <table id="dt_received_original_attachments" class="table table-report -mt-2 table-hover">
                            <thead class="alert-primary-soft">
                            <tr>
                                <th class="text-center whitespace-nowrap ">Created by</th>
                                <th class="text-center whitespace-nowrap ">File Name</th>
                                <th class="text-center whitespace-nowrap ">Action</th>
{{--                                <th class="text-center whitespace-nowrap ">Description</th>--}}
                                {{--                            <th class="text-center whitespace-nowrap ">File Views</th>--}}
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

                {{--        For Added Attachments        --}}
                <div id="div_dt_received_added_attachments" >
                    <div style="border-radius: 0.375rem;" class="alert-dark text-center show p-3">Added Attachment(s)</div>
                    <div class="overflow-x-auto scrollbar-hidden pb-5">
                        <table id="dt_received_added_attachments" class="table table-report -mt-2 table-hover">
                            <thead class="alert-dark-soft">
                            <tr>
                                <th class="text-center whitespace-nowrap ">Added by</th>
                                <th class="text-center whitespace-nowrap ">File Name</th>
                                <th class="text-center whitespace-nowrap ">Note</th>
                                <th class="text-center whitespace-nowrap ">Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="received_add_attachments_div" class="add_attachments_div grid grid-cols-2"></div>
            <!-- END: Modal Content -->

            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
{{--                <button id="add_attachments_btn"  type="submit" class="btn btn-primary w-20 add_attachments_btn">Add</button>--}}
            </div>
            <!-- END: Modal Footer -->
            </div>
        </div>
    </div>
</div>



{{--   Hard Copy ni Diri    --}}
{{--<div id="received_modal_hard_copy" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">--}}
{{--    <div class="modal-dialog modal-xl">--}}
{{--        <div class="modal-content">--}}

{{--            <!-- BEGIN: Modal Content -->--}}
{{--            <div class="modal-header">--}}
{{--                <h2 class="font-medium text-base mr-auto">Document Attachment(s)</h2>--}}
{{--            </div>--}}
{{--            <div class="modal-body ">--}}

{{--                <div id="hard_copy_div" class="col-span-12 sm:col-span-6"></div>--}}

{{--                <!-- BEGIN: Modal Footer -->--}}
{{--                <div class="modal-footer">--}}
{{--                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>--}}
{{--                </div>--}}
{{--                <!-- END: Modal Footer -->--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
