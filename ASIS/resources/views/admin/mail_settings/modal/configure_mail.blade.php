 <!-- BEGIN: Modal Content -->
 <div id="configure_email" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Configure Email</h2>
                <i class="fa fa-envelope w-5 h-5 primary fa-beat text-primary"></i>
            </div> <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <form id="config_form">
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-12"> <label for="modal-form-1" class="form-label font-semibold">Mail Driver</label> <input id="mail_driver" type="text" class="form-control" placeholder="smtp" value="smtp" disabled> </div>
                    <div class="col-span-12 sm:col-span-12"> <label for="modal-form-2" class="form-label font-semibold">Mail Host</label> <input id="mail_host" type="text" class="form-control" placeholder="smtp.gmail.com" value="smtp.gmail.com" disabled> </div>
                    <div class="col-span-12 sm:col-span-12"> <label for="modal-form-2" class="form-label font-semibold">Mail Port</label> <input id="mail_port" type="text" class="form-control" placeholder="587" value="587" disabled> </div>
                    <div class="col-span-12 sm:col-span-12"> <label for="modal-form-2" class="form-label font-semibold">Mail encryption</label> <input id="mail_encryption" type="text" class="form-control" placeholder="tls" value="tls" disabled> </div>
                    <div class="col-span-12 sm:col-span-12"> <label for="modal-form-2" class="form-label font-semibold">Mail Username</label> <input id="mail_username" type="text" class="form-control" placeholder="email"> </div>
                    <div class="col-span-12 sm:col-span-12"> <label for="modal-form-2" class="form-label font-semibold">Mail Password</label> <input id="mail_password" type="text" class="form-control" placeholder="generated email password"> </div>
                    <div class="col-span-12 sm:col-span-12"> <label for="modal-form-2" class="form-label font-semibold">Mail Name</label> <input id="mail_name" type="text" class="form-control" placeholder="Enter mail name"> </div>
                </div>
            </form>
            <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" id="btn_configure_cancel" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <button type="button" id="btn-saved-configure-email" class="btn btn-primary w-20">Saved</button> </div> <!-- END: Modal Footer -->
        </div>
    </div>
</div> <!-- END: Modal Content -->
