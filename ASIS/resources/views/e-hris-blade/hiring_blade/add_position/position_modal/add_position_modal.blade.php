
<!-- BEGIN: Modal Content -->
<div id="add_position" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Create Position</h2>
            </div> <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12"> <label for="modal-form-1" class="form-label font-semibold">Poisition</label>
                    <input id="create_position" type="text" class="form-control" placeholder="Enter position name ">
                </div>
                <div class="col-span-12 sm:col-span-12"> <label for="modal-form-2" class="form-label font-semibold">Description</label>
                    <textarea id="position_desc" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border" placeholder="Enter Description"></textarea>
                </div>
            </div> <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button id="cancel_position_modal" type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <button id="saved_position_add" type="button" class="btn btn-primary w-20">Save</button> </div> <!-- END: Modal Footer -->
        </div>
    </div>
</div> <!-- END: Modal Content -->


<!-- BEGIN: Modal Toggle -->
<div id="delete_position_modal" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center"> <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                    <div class="text-3xl mt-5">Are you sure?</div>
                    <div class="text-slate-500 mt-2">Do you really want to delete these records? <br>This process cannot be undone.</div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                    <button id="btn_delete_position_data" type="button" class="btn btn-danger w-24">Delete</button> </div>
            </div>
        </div>
    </div>
</div> <!-- END: Modal Content -->
