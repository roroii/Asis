<div id="update_DocumentLevel" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form_updateDocLevel" class="modal-content" method="post">
            @csrf
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Update Document Level</h2>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body">
                <input id="up_docLevelID" name="up_docID" class="hidden">
                <div class="mb-2">
                    <label for="modal-form-1" class="form-label">Document Level</label>
                    <input id="up_document_Level" name="up_document_Level" type="text" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label for="modal-form-1" class="form-label">Description</label>
                    <input id="up_descLevel" name="up_descLevel" type="text" class="form-control" required>
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
