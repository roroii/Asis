 <!-- BEGIN: Delete Confirmation Modal -->
 <div id="delete_modal" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center">
                    <i id="delete_icon" class=" fa fa-trash w-16 h-16 text-dark mx-auto mt-1" hidden></i>
                    <i id="success_icon" class=" fa fa-check w-16 h-16 text-success mx-auto mt-1" hidden></i>
                    <div class="text-3xl mt-5">Are you sure?</div>
                    <div class="text-slate-500 mt-4">
                        <label id="lbl-warning" class="font-medium"></label>
                        <br>
                        <label id="lbl-info" class="font-medium"></label>
                    </div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                    <button id="delete_button_modal" type="submit" class="btn btn-danger w-24">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Delete Confirmation Modal -->
