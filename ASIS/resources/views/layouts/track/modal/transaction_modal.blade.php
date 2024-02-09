<!-- BEGIN: Overlapping Groups Modal Content -->
<div id="open_transaction_details" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form_sendCreatedDocs" class="modal-content" method="post">
        @csrf
            <!-- BEGIN: Modal Header -->
            <div class="modal-header flex items-center justify-center">
                <h2 class="font-medium text-base mr-auto">Transaction Details</h2>
            </div>
            <!-- END: Modal Header -->

            <!-- BEGIN: Modal Body -->
            <div class="modal-body">
                <!-- BEGIN: Recent Activities -->
                <div id="load_transaction_details" class="col-span-12 md:col-span-6 xl:col-span-4 2xl:col-span-12 mt-3">

                </div>
                <!-- END: Recent Activities -->
                <!-- BEGIN: Nested Select -->
            </div>
            <!-- END: Modal Body -->

            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-primary w-20 mr-">OK </button>
            </div>
            <!-- END: Modal Footer -->
        </form>
    </div>
</div>
<!-- END: Overlapping Groups Modal Content -->

<!-- BEGIN: Open New Transaction Details -->
<div id="confirmation_modal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center"> <i data-lucide="help-circle" class="w-20 h-20 text-success mx-auto mt-3"></i>
                    <div class="text-3xl mt-5">Track another Document(s)?</div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <button id="btn_cancel__" type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24">Cancel</button>
                    <button id="btn_ok_open_new_tab" type="button" class="btn btn-primary w-24">Ok</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Open New Transaction Details -->
