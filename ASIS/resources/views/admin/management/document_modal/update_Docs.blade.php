<div id="update_CreatedDocs" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="form_updateCreatedDocs" class="modal-content" method="post">
            @csrf
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Update your Document</h2>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
                <div class="modal-body grid grid-cols-1 gap-4 gap-y-3">
                    <input id="up_document_ID" name="up_document_ID" class="hidden">
                    <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-1" class="form-label">Document Copy Type <span class="ml-5 _update_document_type_submitted"></span></label>
                        <div class="col-span-12 sm:col-span-12">
                            <input id="_update_document_type_submitted" name="_update_document_type_submitted" type="text" class="form-control " disabled>
{{--                            <div style="position: relative">--}}
{{--                                <select class="select2 w-full _update_document_type_submitted" id="_update_document_type_submitted" name="_update_document_type_submitted">--}}
{{--                                    --}}{{--                                    <option></option>--}}
{{--                                    @forelse (getTypeOfSubmittedDocs('') as $type)--}}
{{--                                        <option  value="{{ $type->id }}">{{ $type->type }}</option>--}}
{{--                                    @empty--}}
{{--                                    @endforelse--}}
{{--                                </select>--}}
{{--                            </div>--}}
                            {{--                            <div class="mt-2"><span class="text-danger error-text document_type_submitted"></span></div>--}}
                        </div>
                    </div>

                    <div class="col-span-12 sm:col-span-6"> <label for="modal-form-1" class="form-label">Title</label>
                        <input id="up_document_title" name="up_document_title" type="text" class="form-control " required placeholder="Document tittle here....">
                        <div class="mt-2"><span class="text-danger error-text up_document_title"></span></div>
                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Description</label>
                        <textarea style="height: 100px" id="up_message" class="form-control" name="up_message" placeholder="Type your description...." ></textarea>
                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-1" class="form-label">Document Type <span class="ml-5 _update_document_type"></span></label>
                        <div class="col-span-12 sm:col-span-12">
                            <div style="position: relative">
                                <select class="select2 w-full _update_document_type" id="_update_document_type" name="_update_document_type">
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
                        <label for="modal-form-1" class="form-label">Document Level <span class="ml-5 _update_document_level"></span></label>
                        <div class="col-span-12 sm:col-span-12">
                            <div style="position: relative">
                                <select class="select2 w-full document_level" id="_update_document_level" name="_update_document_level">
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
                        <label for="modal-form-1" class="form-label">Document Display Type <span class="ml-5 _update_document_pub_pri_file"></span></label>
                        <div class="col-span-12 sm:col-span-12">
                            <div style="position: relative">
                                <select class="select2 w-full _update_document_pub_pri_file" id="_update_document_pub_pri_file" name="_update_document_pub_pri_file">
                                    <option></option>
                                    <option  value="0">Public File</option>
                                    <option  value="1">Private File</option>
                                </select>
                            </div>
                            {{--                            <div class="mt-2"><span class="text-danger error-text document_pub_pri_file"></span></div>--}}
                        </div>
                    </div>
                </div>
                <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <button type="submit" class="btn btn-primary w-20">Update</button>
            </div>
            <!-- END: Modal Footer -->
        </form>
    </div>
</div>
