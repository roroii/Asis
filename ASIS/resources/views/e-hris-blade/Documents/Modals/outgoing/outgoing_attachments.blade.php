{{--   Modal for viewing received document attachments    --}}
<div id="outgoing_modal_add_attachments" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <!-- BEGIN: Modal Content -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Document Attachment(s)</h2>
            </div>
            <div class="modal-body ">

                <div id="outgoing_if_no_files_attached" class="col-span-12 sm:col-span-6 "></div>

                {{--        For Original Attachments        --}}
                <div id="div_dt_outgoing_original_attachments" >
                    <div style="border-radius: 0.375rem;" class="alert-primary text-center show p-3">Original Attachment(s)</div>
                    <div class="overflow-x-auto scrollbar-hidden pb-5">
                        <table id="dt_outgoing_original_attachments" class="table table-report -mt-2 table-hover">
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
                <div id="div_dt_outgoing_added_attachments" >
                    <div style="border-radius: 0.375rem;" class="alert-dark text-center show p-3">Added Attachment(s)</div>
                    <div class="overflow-x-auto scrollbar-hidden pb-5">
                        <table id="dt_outgoing_added_attachments" class="table table-report -mt-2 table-hover">
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

                <div id="outgoing_add_attachments_div" class="grid grid-cols-2"></div>
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
