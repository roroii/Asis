<div id="add_other_info_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Other Information</h2>
            </div>

            <div class="modal-body p-0">

                <div class="p-5 grid grid-cols-12 gap-6">

                    <input id="special_skills_id" class="hidden">

                    <div class="input-form col-span-12 lg:col-span-12">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Special Skills and Hobbies </label>
                        <input id="others_skills" type="text" style="text-transform:uppercase" name="others_skills" class="form-control" placeholder="Special Skills and Hobbies / N/A if not applicable" minlength="2" required autocomplete="off">
                    </div>

                    <div class="input-form col-span-12 lg:col-span-12">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Non-Academic Distinctions/Recognition <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">(Write in full)</span> </label>
                        <input id="others_distinction" type="text" style="text-transform:uppercase" name="others_distinction" class="form-control" placeholder="Non-Academic Distinctions/Recognition" minlength="2" required autocomplete="off">
                    </div>

                    <div class="input-form col-span-12 lg:col-span-12">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Membership in Association/Organization  </label>
                        <input id="others_membership" type="text" style="text-transform:uppercase" name="others_membership" class="form-control" placeholder="Membership in Association/Organization" minlength="2" required autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <button id="save_other_info" type="submit" class="btn btn-primary w-20">Add</button>
                <button id="update_other_info" type="submit" class="btn btn-primary w-20">Update</button>

            </div>
        </div>
    </div>
</div>


<div id="delete_other_info_mdl" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">

                <input id="mdl_other_info_input_id" class="hidden">

                <div class="p-5 text-center"> <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                    <div class="text-3xl mt-5">Are you sure?</div>
                    <div class="text-slate-500 mt-2">Do you really want to delete this data? <br>This process cannot be undone.</div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                    <button id="btn_delete_my_special_skills" type="button" class="btn btn-danger w-24">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

