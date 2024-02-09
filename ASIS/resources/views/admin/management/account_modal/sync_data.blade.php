<!-- Add Documents Modal -->
<div id="sync_data_modal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form   method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">

                <!-- BEGIN: Modal Header -->
                <div class="modal-header flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Sync Data
                    </h2>
                </div>
                <!-- END: Modal Header -->

                <!-- BEGIN: Modal Body -->
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                    <div class="col-span-12 sm:col-span-12">
                        <div class=" mb-5"> <label>Includ Account?</label>
                            <div >
                                <select id="includ_account" data-placeholder="Select..." class="tom-select w-full" >
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 sm:col-span-12">
                        <div class=" mb-5"> <label>Includ Profile?</label>
                            <div >
                                <select id="includ_profile" data-placeholder="Select..." class="tom-select w-full" >
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 sm:col-span-12">
                        <div class=" mb-5"> <label>Includ Employee?</label>
                            <div >
                                <select id="includ_employee" data-placeholder="Select..." class="tom-select w-full" >
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- END: Modal Body -->

                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button id="cancel_documents_btn" type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                    <a id="sync_data_account_profile_employee" type="submit" class="btn btn-primary w-20"> Save </a>
                </div>
                <!-- END: Modal Footer -->
            </div>
        </form>
    </div>
</div>
<!-- END: Modal Content -->

