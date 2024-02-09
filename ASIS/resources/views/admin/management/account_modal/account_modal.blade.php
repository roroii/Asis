<!-- Add Documents Modal -->
<div id="account_modal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">

                <!-- BEGIN: Modal Header -->
                <div class="modal-header flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Account
                    </h2>
                    <div id="account_status_modal_title" class="ml-auto text-primary truncate flex items-center"></div>
                </div>
                <!-- END: Modal Header -->

                <!-- BEGIN: Modal Body -->
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <input hidden id="account_modal_id" type="text" class="form-control" placeholder="id">

                    <div class="col-span-12 sm:col-span-12">
                        <label for="modal-form-2" class="form-label">Agency ID</label>
                        <input id="modal_account_agency_id" name="modal_account_agency_id" type="text" disabled class="form-control" value="N/A">
                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-1" class="form-label">Frist Name</label>
                        <input id="modal_account_first_name" name="modal_account_first_name" type="text"  class="form-control" value="">
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-2" class="form-label">Last Name</label>
                        <input id="modal_account_last_name" name="modal_account_last_name" type="text"  class="form-control" value="">
                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-1" class="form-label">Active Date</label>
                        <input id="modal_account_active_date" name="modal_account_active_date" type="date" class="form-control" placeholder="Active Date">
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-2" class="form-label">Expire Date</label>
                        <input id="modal_account_expire_date" name="modal_account_expire_date" type="date" class="form-control" placeholder="Expire Date">
                    </div>

                    <div class="col-span-12 sm:col-span-12">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Username</label>
                        <input id="modal_account_username" type="text" class="form-control" placeholder="Username">
                    </div>
                    <div class="col-span-12 sm:col-span-12">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Password</label>
                        <input id="modal_account_password" type="text" class="form-control" placeholder="Password">
                    </div>

                    <div class="col-span-12 sm:col-span-12">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Role Name</label>
                        <select id="modal_account_role_name" class="form-select" >
                            <option value="User">User</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>

                    <div class="col-span-12 sm:col-span-12">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Last Seen</label>
                        <input disabled id="modal_account_last_seen" type="text" class="form-control" placeholder="Last Seen">
                    </div>

                </div>

                <!-- END: Modal Body -->

                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button id="cancel_documents_btn" type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                    {{-- <a href="javascript:;" id="load_account_save" class="btn btn-primary w-20 load_account_save"> Save </a> --}}
                    {{-- onClick="this.disabled=true;" --}}
                    <button id="load_account_save" class="btn btn-primary mr-1 mb-2 load_account_save w-20"> Save </button>
                </div>
                <!-- END: Modal Footer -->
            </div>
        </form>
    </div>
</div>
<!-- END: Modal Content -->

