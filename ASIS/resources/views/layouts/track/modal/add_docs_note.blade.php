<!-- BEGIN: Overlapping Groups Modal Content -->
<div id="add_docs_note" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-s">
        <div class="modal-content">
        @csrf
        <!-- BEGIN: Modal Header -->
            <div class="modal-header flex items-center justify-center">
                <h2 class="font-medium text-base mr-auto">Add Document Notes</h2>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body">

                <div class="col-span-12 sm:col-span-6 mt-2">
                    <label class="form-label w-full flex flex-col sm:flex-row"> Title <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Description</span> </label>
                    <input id="documents_note_title" name="documents_note_title" type="text" class="form-control" required>
                    <input hidden id="modal_track_id" name="modal_track_id" type="text" class="form-control" value="{{ $trackNumber }}">
                </div>

                <div class="col-span-12 sm:col-span-6 mt-2">
                    <label class="form-label w-full flex flex-col sm:flex-row"> Note <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Description</span> </label>
                    <textarea id="documents_note_message" class="form-control" name="documents_note_message" placeholder="Type your message" minlength="10" required=""></textarea>
                </div>

                <!-- END: Basic Select -->


            </div>
            <!-- END: Modal Body -->

            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">

                <a data-tw-dismiss="modal" class="btn btn-outline-secondary w-auto mb-2" href="javascript:;">
                    Cancel
                </a>
                <button id="btn_add_document_note" type="button" data-note-type="document_notes" class="btn btn-primary w-auto mb-2">
                    Done
                </button>
            </div>
            <!-- END: Modal Footer -->
        </div>
    </div>
</div>
<!-- END: Overlapping Groups Modal Content -->
