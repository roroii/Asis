<div id="add_Pos_type_modal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-s">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 id="title" class="font-medium text-base mr-auto">
                    
                </h2>
                <div class="dropdown sm:hidden">

                </div>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <form id="postionType_form" method="POST"  enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="typeID" name="typeID">
            <!-- BEGIN: Modal Body -->
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12">
                    <label for="number" class="form-label">Position Type</label>
                    <input id="positionType" name="positionType" type="text" class="form-control" placeholder="Type Position type" required>
                </div>

                <div class="col-span-12 sm:col-span-12">
                    <label for="modal-form-3" class="form-label">Description</label>
                    <textarea class="form-control" name="type_desc" id="type_desc"rows="3" placeholder="Description" ></textarea>
                </div>

               

            </div> <!-- END: Modal Body -->
            <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <button id="add_type_modal" type="submit" class="btn btn-primary w-20">Save </button>
            </div>
            </form>
            <!-- END: Modal Footer -->
        </div>
    </div>
</div>