{{--modal for link list--}}
<div id="add_new_parameter_modal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">
                    Add Parameter
                </h2>
            </div>
            <!-- END: Modal Header -->

            <form action="{{ url('admin/add/setting')}}"  method="post" enctype="multipart/form-data">
                @csrf

                <!-- BEGIN: Modal Body -->

                    <!-- BEGIN: Modal Body -->
                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                        <input hidden id="modal_set_update_id" name="modal_set_update_id" type="text" class="form-control" placeholder="key id" >
                        <input hidden id="modal_set_update_create" name="modal_set_update_create" type="text" class="form-control" value="Save" placeholder="key id" >

                        <div class="col-span-12 sm:col-span-12">
                            <label for="number" class="form-label">Key</label>
                            <input id="modal_set_key" name="modal_set_key" type="text" class="form-control" placeholder="Key" >
                        </div>

                        <div class="col-span-12 sm:col-span-12">
                            <label for="number" class="form-label">Value</label>
                            <input id="modal_set_value" name="modal_set_value" type="text" class="form-control" placeholder="Value" >
                        </div>

                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-3" class="form-label">Description</label>
                            <textarea class="form-control" name="modal_set_desc" id="modal_set_desc"rows="3" placeholder="Description" ></textarea>
                        </div>

                        <div class="col-span-12 sm:col-span-12">
                            <label for="number" class="form-label">has Link</label>
                            <input id="modal_set_link" name="modal_set_link" type="text" class="form-control" placeholder="Link" >
                        </div>

                        <div class="col-span-12 sm:col-span-12">
                            <label for="number" class="form-label">has Image</label>
                           <input hidden type='text' name="modal_set_current_logo" id="modal_set_current_logo" class="form-control" placeholder="image" />

                            <input id="modal_set_imageUpload"
                                   type="file"
                                   class="filepond mt-1"
                                   name="modal_set_imageUpload" onchange="load_path(this.value)"
                            >

                        </div>

                    </div>
                    <!-- END: Modal Body -->

                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer">
                        <button id="btn_cancel_system_save" type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                        <button id="save_system_setting" type="submit" name="save_system_setting" class="btn btn-primary w-20">Save <i data-lucide="save" style="color: rgb(255, 255, 255)" class="w-4 h-4 text-slate-500 ml-auto"></i></button>
                    </div>
                <!-- END: Modal Footer -->

            </form>
        </div>
    </div>
</div>
