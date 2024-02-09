<!-- Add Documents Modal -->
<div id="update_content_term_condition" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="form_createDocs"  method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="alert alert-danger" style="display:none"></div>
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Update Content</h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->


                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-12" id="classic-editor">
                        <input hidden id="tc_id" name="tc_id" type="text" value=" {!! get_term_condition()->id !!}">
                        <div class="preview">
                            <textarea name="content" id="editor_textarea" class="editor_textarea">
                                {!! get_term_condition()->desc_content !!}
                            </textarea>
                        </div>

                        {{-- <div class="preview">
                            <div class="editor">
                                <p>Content of the editor.</p>
                            </div>
                        </div> --}}

                    </div>
                </div>

                <!-- END: Modal Body -->

                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button id="cancel_documents_btn" type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                    <a  href="javascript:;" id="update_terms_condition" class="btn btn-primary w-20 add_travel_order"> Update </a>
                    {{-- <button id="add_travel_order" class="btn btn-primary w-20 add_travel_order">Save</button> --}}
                </div>
                <!-- END: Modal Footer -->
            </div>
        </form>
    </div>
</div>
<!-- END: Modal Content -->
