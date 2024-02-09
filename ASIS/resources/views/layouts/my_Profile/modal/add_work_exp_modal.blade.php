<div id="add_work_exp_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Work Experience</h2>
            </div>

            <div class="modal-body p-0">

                <div class="p-5 grid grid-cols-12 gap-6">

                    <input id="work_exp_id" class="hidden">

                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Inclusive Dates (From)</label>
                        <div class="relative w-auto mx-auto">
                            <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                                <i data-lucide="calendar" class="w-4 h-4"></i>
                            </div> <input id="work_exp_date_from" type="text" class="form-control pl-12 ">
                        </div>
                    </div>

                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Inclusive Dates (To)</label>
                        <div class="relative w-auto mx-auto">
                            <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                                <i data-lucide="calendar" class="w-4 h-4"></i>
                            </div> <input id="work_exp_date_to" type="text" class="form-control pl-12 ">
                        </div>
                    </div>
                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Position Title </label>
                        <input id="work_exp_pos_title" style="text-transform:uppercase"  type="text" name="work_exp_pos_title" class="form-control" placeholder="Position Title" minlength="2" required autocomplete="off">
                    </div>
                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Department/Agency/Office/Company </label>
                        <input id="work_exp_dept_agency" style="text-transform:uppercase"  type="text" name="work_exp_dept_agency" class="form-control" placeholder="Department/Agency/Office/Company" minlength="2" required autocomplete="off">
                    </div>
                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Monthly Salary </label>
                        <input id="work_exp_sal" type="number" name="work_exp_sal" class="form-control" placeholder="Monthly Salary" minlength="2" required autocomplete="off">
                    </div>
                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Salary/Job/Pay Grade <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">(if Applicable) & STEP (Format "00-0")/INCREMENT</span> </label>
                        <input id="work_exp_sg" type="text" style="text-transform:uppercase"  name="work_exp_sg" class="form-control" placeholder="Salary/Job/Pay Grade" minlength="2" required autocomplete="off">
                    </div>
                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Status of Appointment </label>
                        <input id="work_exp_status" style="text-transform:uppercase"  type="text" name="work_exp_status" class="form-control" placeholder="Status of Appointment" minlength="2" required autocomplete="off">
                    </div>
                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Government Service  </label>
                        <select class="select2 w-full" id="work_exp_govt_service">
                            <option value="YES">YES</option>
                            <option value="NO">NO</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btn_cancel_add_work_exp" type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <button id="save_work_exp" type="submit" class="btn btn-primary w-20">Add</button>
                <button id="edit_work_exp" type="submit" class="btn btn-primary w-20">Update</button>
            </div>
        </div>
    </div>
</div>


<div id="delete_work_exp_mdl" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">

                <input id="mdl_work_exp_input_id" class="hidden">

                <div class="p-5 text-center"> <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                    <div class="text-3xl mt-5">Are you sure?</div>
                    <div class="text-slate-500 mt-2">Do you really want to delete this data? <br>This process cannot be undone.</div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                    <button id="btn_delete_my_work_exp" type="button" class="btn btn-danger w-24">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
