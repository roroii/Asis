<!-- Add Documents Modal -->
<div id="import_profile_modal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ url('admin/profile-import')}}"  method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">

                <!-- BEGIN: Modal Header -->
                <div class="modal-header flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Import Profile
                    </h2>
                    <div id="account_status_modal_title" class="ml-auto text-primary truncate flex items-center"></div>
                </div>
                <!-- END: Modal Header -->

                <!-- BEGIN: Modal Body -->
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                    <div class="col-span-12 sm:col-span-12">
                        <label for="modal-form-2" class="form-label">Choose File</label>
                        <input id="modal_set_imageUpload"
                        type="file"
                        class="filepond mt-1"
                        name="modal_set_imageUpload" >
                    </div>

                </div>

                <!-- END: Modal Body -->

                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button id="cancel_documents_btn" type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                    <button type="submit" class="btn btn-primary w-20"> Save </button>
                </div>
                <!-- END: Modal Footer -->
            </div>
        </form>
    </div>
</div>
<!-- END: Modal Content -->

