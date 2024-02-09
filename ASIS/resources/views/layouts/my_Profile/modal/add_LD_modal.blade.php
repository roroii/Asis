<div id="add_LD_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Learning and Development (L&D) Interventions/Training Programs Attended</h2>
            </div>

            <div class="modal-body p-0">

                <div class="p-5 grid grid-cols-12 gap-6">

                    <input id="ld_id" class="hidden">

                    <div class="input-form col-span-12 lg:col-span-12">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Title of Learning and Development Interventions/Training Programs <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">(Write in full)</span> </label>
                        <input id="ld_title" type="text" name="ld_title" style="text-transform:uppercase" class="form-control" placeholder="Title of Learning and Development Interventions/Training Programs" minlength="2" required autocomplete="off">
                    </div>

                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Inclusive Dates of Attendance (From)</label>
                        <div class="relative w-auto mx-auto">
                            <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                                <i data-lucide="calendar" class="w-4 h-4"></i>
                            </div> <input id="ld_date_from" type="text" class="form-control pl-12 ">
                        </div>
                    </div>

                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Inclusive Dates of Attendance (To)</label>
                        <div class="relative w-auto mx-auto">
                            <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                                <i data-lucide="calendar" class="w-4 h-4"></i>
                            </div> <input id="ld_date_to" type="text" class="form-control pl-12 ">
                        </div>
                    </div>
                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Number of Hours </label>
                        <input id="ld_hr_number" type="number" name="ld_hr_number" class="form-control" placeholder="Number of Hours" minlength="2" required autocomplete="off">
                    </div>

                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Type of LD <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">(Managerial/Supervisory/Technical/etc.)</span> </label>
                        <select class="select2 w-full" id="ld_type">
                            <option value="MANAGERIAL">MANAGERIAL</option>
                            <option value="SUPERVISORY">SUPERVISORY</option>
                            <option value="TECHNICAL">TECHNICAL</option>
                            <option value="OTHERS">OTHERS</option>
                        </select>
                    </div>

                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Conducted/Sponsored By </label>
                        <input id="ld_sponsored_by" type="text" style="text-transform:uppercase" name="ld_sponsored_by" class="form-control" placeholder="Conducted/Sponsored By" minlength="2" required autocomplete="off">
                    </div>

                    <div id="div_if_others" class="input-form col-span-12 lg:col-span-6">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btn_cancel_add_ld" type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <button id="save_LD" type="submit" class="btn btn-primary w-20">Add</button>
                <button id="edit_ld" type="submit" class="btn btn-primary w-20">Update</button>
            </div>
        </div>
    </div>
</div>




<div id="delete_ld_mdl" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">

                <input id="mdl_ld_input_id" class="hidden">

                <div class="p-5 text-center"> <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                    <div class="text-3xl mt-5">Are you sure?</div>
                    <div class="text-slate-500 mt-2">Do you really want to delete this data? <br>This process cannot be undone.</div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                    <button id="btn_delete_my_learning_dev" type="button" class="btn btn-danger w-24">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
