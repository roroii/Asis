<div id="update_DocumentType" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form_updateDocType" class="modal-content validate-form" method="post">
            @csrf
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Update Document Type</h2>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body">
                <input id="up_docID" name="up_docID" class="hidden">
                <div class="mb-2">
                    <label for="modal-form-1" class="form-label">Document Type</label>
                    <input id="up_document_Type" name="up_document_Type" type="text" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label for="modal-form-1" class="form-label">Description</label>
                    <input id="up_desc" name="up_desc" type="text" class="form-control" required>
                </div>
            </div>
            <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <button id="btn_upDocType" type="submit" class="btn btn-primary w-20">Update</button>
            </div>
            <!-- END: Modal Footer -->
        </form>

        <div id="success-notification-content" class="toastify-content hidden flex"> <i class="text-success" data-lucide="check-circle"></i>
            <div class="ml-4 mr-4">
                <div class="font-medium">Registration success!</div>
                <div class="text-slate-500 mt-1"> Please check your e-mail for further info! </div>
            </div>
        </div> <!-- END: Success Notification Content -->
        <!-- BEGIN: Failed Notification Content -->
        <div id="failed-notification-content" class="toastify-content hidden flex"> <i class="text-danger" data-lucide="x-circle"></i>
            <div class="ml-4 mr-4">
                <div class="font-medium">Registration failed!</div>
                <div class="text-slate-500 mt-1"> Please check the fileld form. </div>
            </div>
        </div>

    </div>
</div>
