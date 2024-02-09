<!-- Add Documents Modal -->
<div id="create_document" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="form_createDocs" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="alert alert-danger" style="display:none"></div>
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Create Documents</h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->

                <div class="modal-body grid grid-cols-1 gap-4 gap-y-3">

                    <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-1" class="form-label">Document Copy Type <span class="ml-5 document_type_submitted"></span></label>
                        <div class="col-span-12 sm:col-span-12">
                            <div style="position: relative">
                                <select class="select2 w-full document_type_submitted" id="document_type_submitted" name="document_type_submitted">
                                    @forelse (getTypeOfSubmittedDocs('') as $type)
                                        <option  value="{{ $type->id }}">{{ $type->type }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
{{--                            <div class="mt-2"><span class="text-danger error-text document_type_submitted"></span></div>--}}
                        </div>
                    </div>

                    <div class="col-span-12 sm:col-span-6"> <label for="modal-form-1" class="form-label">Title</label>
                        <input id="document_title" name="document_title" type="text" class="form-control " required placeholder="Document tittle here....">
                        <div class="mt-2"><span class="text-danger error-text document_title_error"></span></div>
                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Description</label>
                        <textarea style="height: 100px" id="message" class="form-control" name="message" placeholder="Type your description...." ></textarea>
                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-1" class="form-label">Document Type <span class="ml-5 document_type"></span></label>
                        <div class="col-span-12 sm:col-span-12">
                            <div style="position: relative">
                                <select class="select2 w-full document_type" id="document_type" name="document_type">
                                    <option></option>
                                    @forelse (getDocumentType('') as $docType)
                                        <option  value="{{ $docType->id }}">{{ $docType->doc_type }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
{{--                            <div class="mt-2"><span class="text-danger error-text document_type"></span></div>--}}
                        </div>
                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-1" class="form-label">Document Level <span class="ml-5 document_level"></span></label>
                        <div class="col-span-12 sm:col-span-12">
                            <div style="position: relative">
                                <select class="select2 w-full document_level" id="document_level" name="document_level">
                                    <option></option>
                                    @forelse (getDocumentLevel('') as $docLevel)
                                        <option  value="{{ $docLevel->id }}">{{ $docLevel->doc_level }} - <span>{{ $docLevel->desc }}</span> </option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
{{--                            <div class="mt-2"><span class="text-danger error-text document_level"></span></div>--}}
                        </div>
                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-1" class="form-label">Document Display Type <span class="ml-5 document_pub_pri_file"></span></label>
                        <div class="col-span-12 sm:col-span-12">
                            <div style="position: relative">
                                <select class="select2 w-full document_pub_pri_file" id="document_pub_pri_file" name="document_pub_pri_file">
                                    <option></option>
                                    <option  value="1">Private File</option>
                                    <option  value="0">Public File</option>
                                </select>
                            </div>
{{--                            <div class="mt-2"><span class="text-danger error-text document_pub_pri_file"></span></div>--}}
                        </div>
                    </div>

                    <div id="div_document_Attachment" class="col-span-12 sm:col-span-6">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Attach Document <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">25 mb maximum file size</span> </label>
                        <input id="document_uploaded"
                               type="file"
                               class="filepond mt-1"
                               name="document[]"
                               multiple
                        >
                    </div>

                </div>

                <!-- END: Modal Body -->

                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button id="cancel_documents_btn" type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                    <button id="add_documents_btn"  type="submit" class="btn btn-primary w-20 add_documents_btn">Save</button>

                </div>
                <!-- END: Modal Footer -->
            </div>
        </form>
    </div>
</div>
<!-- END: Modal Content -->


{{--   Modal for viewing received document attachments    --}}
<div id="my_Docs_modal_add_attachments" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <!-- BEGIN: Modal Content -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Document Attachment(s)</h2>
            </div>
            <div class="modal-body ">

                <div id="my_docs_no_attached" class="col-span-12 sm:col-span-6 "></div>

                {{--        For Original Attachments        --}}
                <div id="div_dt__my_docs_original_attachments" >
                    <div style="border-radius: 0.375rem;" class="alert-primary text-center show p-3">Original Attachment(s)</div>
                    <div class="overflow-x-auto scrollbar-hidden pb-5">
                        <table id="dt__my_docs_original_attachments" class="table table-report -mt-2 table-hover">
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
                <div id="div_dt__my_docs_added_attachments" >
                    <div style="border-radius: 0.375rem;" class="alert-dark text-center show p-3">Added Attachment(s)</div>
                    <div class="overflow-x-auto scrollbar-hidden pb-5">
                        <table id="dt__my_docs_added_attachments" class="table table-report -mt-2 table-hover">
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

                <div id="my_docs_add_attachments_div" class="add_attachments_div grid grid-cols-2"></div>
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



<!-- BEGIN: Status Details Modal -->
<div id="my_docs_status_modal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header flex items-center justify-center">
                <h2 class="font-medium text-base mr-auto">Returned Document Details</h2>
            </div>
            <!-- END: Modal Header -->

            <!-- BEGIN: Modal Body -->
            <div class="modal-body">
                <!-- BEGIN: Recent Activities -->
                <div id="load_returned_docs_details" class="col-span-12 md:col-span-6 xl:col-span-4 2xl:col-span-12 mt-3"></div>
                <!-- END: Recent Activities -->
                <!-- BEGIN: Nested Select -->
            </div>
            <!-- END: Modal Body -->

            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-primary w-20 mr-">OK </button>
            </div>
        </div>
        <!-- END: Modal Footer -->
    </div>
</div>
<!-- END: Status Details Modal -->

<!-- BEGIN: Status COMPLETED Details Modal -->
<div id="my_docs_completed_modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center"> <i data-lucide="check-circle" class="w-16 h-16 text-success mx-auto mt-3"></i>
                    <div class="text-3xl mt-5">Completed</div>
                    <div class="text-slate-500 mt-2">Document sent successfully!</div>
                </div>
                <div class="px-5 pb-8 text-center"> <button type="button" data-tw-dismiss="modal" class="btn btn-primary w-24">Ok</button> </div>
            </div>
        </div>
    </div>
</div>

<!-- BEGIN: Status ONGOING Details Modal -->
<div id="my_docs_outgoing_modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center"> <i data-lucide="check-circle" class="w-16 h-16 text-primary mx-auto mt-3"></i>
                    <div class="text-3xl mt-5">Outgoing</div>
                    <div class="text-slate-500 mt-2">Document is now outgoing!</div>
                </div>
                <div class="px-5 pb-8 text-center"> <button type="button" data-tw-dismiss="modal" class="btn btn-primary w-24">Ok</button> </div>
            </div>
        </div>
    </div>
</div>

<!-- BEGIN: Status PENDING Details Modal -->
<div id="my_docs_pending_modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center"> <i data-lucide="check-circle" class="w-16 h-16 text-warning mx-auto mt-3"></i>
                    <div class="text-3xl mt-5">Pending</div>
                    <div class="text-slate-500 mt-2">Document is on pending!</div>
                </div>
                <div class="px-5 pb-8 text-center"> <button type="button" data-tw-dismiss="modal" class="btn btn-primary w-24">Ok</button> </div>
            </div>
        </div>
    </div>
</div>



