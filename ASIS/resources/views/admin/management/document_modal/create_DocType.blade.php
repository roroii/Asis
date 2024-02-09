<div id="new_DocType" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form_docType" class="modal-content" method="post">
            @csrf
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Create New Document Type</h2>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body">
                <div class="mb-2">
                    <label for="modal-form-1" class="form-label">Document Type</label>
                    <input id="document_Type" name="document_Type" type="text" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label for="modal-form-1" class="form-label">Description</label>
                    <input id="desc" name="desc" type="text" class="form-control">
                </div>
            </div>
            <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <button id="btn_saveDocType" type="submit" class="btn btn-primary w-20">Save</button>
            </div>
            <!-- END: Modal Footer -->
        </form>
    </div>
</div>
