<!-- BEGIN: Overlapping Groups Modal Content -->
<div id="modal_incoming_receive" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-s">
        <form id="form_sendCreatedDocs" class="modal-content" method="post">
            @csrf
            <!-- BEGIN: Modal Header -->
            <div class="modal-header flex items-center justify-center">
                <h2 class="font-medium text-base mr-auto">Receive Document</h2>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body">

                <div>
                    <div class="mr-2">
                        <label class="form-label">Tracking Number</label>
                        <input id="send_DocCode" disabled name="send_DocCode" type="text" class="form-control">
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-6 mt-2">
                    <label class="form-label w-full flex flex-col sm:flex-row"> Note <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Add comment</span> </label>
                    <textarea id="message" class="form-control" name="message" placeholder="Type your message" minlength="10" required=""></textarea>
                </div>
            <!-- BEGIN: Basic Select -->
            <div>
                <label>Action</label>
                <div class="mt-2">
                    <select data-placeholder="Select your action" class="tom-select w-full">
                        <option value="1">Receive</option>
                        <option value="2">Hold</option>
                        <option value="3">Return</option>
                    </select>
                </div>
            </div>
            <!-- END: Basic Select -->
            <!-- BEGIN: Nested Select -->
            </div>
            <!-- END: Modal Body -->

            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <button class="btn btn-primary w-auto mb-2" type="submit">
                    <i class="fa fa-inbox w-4 h-4 mr-2"></i> Done
                </button>
            </div>
            <!-- END: Modal Footer -->
        </form>
    </div>
</div>
<!-- END: Overlapping Groups Modal Content -->
