{{--<!-- Add Documents Modal -->--}}
{{--<div id="attach_document_modal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">--}}
{{--    <div class="modal-dialog modal-lg">--}}
{{--        <form id="attach_document_form" method="post" enctype="multipart/form-data">--}}
{{--            @csrf--}}
{{--            <input class="hidden" id="attach_document_form_value">--}}
{{--            <input class="hidden" id="document_identifier">--}}
{{--            <div class="modal-content">--}}
{{--                <!-- BEGIN: Modal Header -->--}}
{{--                <div class="alert alert-danger" style="display:none"></div>--}}
{{--                <div class="modal-header">--}}
{{--                    <h2 class="font-medium text-base mr-auto">Attach New Documents</h2>--}}
{{--                </div>--}}
{{--                <!-- END: Modal Header -->--}}
{{--                <!-- BEGIN: Modal Body -->--}}

{{--                <div class="modal-body grid grid-cols-1 gap-4 gap-y-3">--}}
{{--                    <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Note</label>--}}
{{--                    <textarea style="height: 100px" id="added_attachment_note" class="form-control" name="added_attachment_note" placeholder="Type your description...." ></textarea>--}}
{{--                </div>--}}

{{--                <div class="modal-body grid grid-cols-1 gap-4 gap-y-3">--}}
{{--                    <div id="documentAttachment" class="col-span-12 sm:col-span-6">--}}
{{--                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Attach Document</label>--}}
{{--                        <input id="attach_new_document"--}}
{{--                               type="file"--}}
{{--                               class="filepond mt-1"--}}
{{--                               name="attach_new_document[]"--}}
{{--                               multiple--}}
{{--                        >--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <!-- END: Modal Body -->--}}

{{--                <!-- BEGIN: Modal Footer -->--}}
{{--                <div class="modal-footer">--}}
{{--                    <button id="cancel_attachments_btn" type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>--}}
{{--                    <button id="add_attachments_btn"  type="submit" class="btn btn-primary w-20 add_attachments_btn">Add</button>--}}

{{--                </div>--}}
{{--                <!-- END: Modal Footer -->--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </div>--}}
{{--</div>--}}
{{--<!-- END: Modal Content -->--}}


{{--   Modal for viewing received document attachments    --}}
<div id="returned_modal_add_attachments" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <!-- BEGIN: Modal Content -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Document Attachment(s)</h2>
            </div>
            <div class="modal-body ">

                <div id="returned_if_no_files_attached" class="col-span-12 sm:col-span-6 "></div>

                {{--        For Original Attachments        --}}
                <div id="div_dt_returned_original_attachments" >
                    <div style="border-radius: 0.375rem;" class="alert-primary text-center show p-3">Original Attachment(s)</div>
                    <div class="overflow-x-auto scrollbar-hidden pb-5">
                        <table id="dt_returned_original_attachments" class="table table-report -mt-2 table-hover">
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
                <div id="div_dt_returned_added_attachments" >
                    <div style="border-radius: 0.375rem;" class="alert-dark text-center show p-3">Added Attachment(s)</div>
                    <div class="overflow-x-auto scrollbar-hidden pb-5">
                        <table id="dt_returned_added_attachments" class="table table-report -mt-2 table-hover">
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

                <div id="returned_add_attachments_div" class="add_attachments_div grid grid-cols-2"></div>
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
