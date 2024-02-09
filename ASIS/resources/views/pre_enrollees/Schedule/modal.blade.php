<div id="add_schedule_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto modal_title">Add Schedule</h2>
            </div>

            <div class="modal-body p-0">

                <div class="p-5 grid grid-cols-12 gap-6">

                    <input id="schedule_id" class="hidden schedule_id">
                    <input id="schedule_date" class="hidden schedule_date">


                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Slots Type</label>
                        <select class="form-select sm:mr-2 slot_type" aria-label="Default select example">
                            <option value="AM">Morning</option>
                            <option value="PM">Afternoon</option>
                        </select>
                    </div>

                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Available Slots</label>
                        <div class="input-group">
                            <div class="input-group-text"><i data-lucide="calendar" class="w-4 h-4 text-slate-500"></i></div>
                            <input type="number" class="form-control min-w-[6rem] input_slots" min="1" placeholder="Slots">
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button id="btn_cancel_add_ld" type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <button id="save_schedule" type="submit" class="btn btn-primary w-20">Add</button>
{{--                <button id="edit_ld" type="submit" class="btn btn-primary w-20">Update</button>--}}
            </div>
        </div>
    </div>
</div>




<div id="delete_update_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x" class="w-8 h-8 text-slate-500"></i> </a>
            <div class="modal-body p-0">

                <input  class="hidden schedule_up_id">
                <input  class="hidden schedule_up_date">
                <input  class="hidden input_up_slots">
                <input  class="hidden slot_up_type">

                <div class="p-5 text-center"> <i data-lucide="alert-circle" class="w-16 h-16 text-primary mx-auto mt-3 fa-beat"></i>
                    <div class="text-3xl mt-5">What do you want?</div>
                    <div class="text-slate-500 mt-2">Update or Delete <br>This process cannot be undone.</div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <button id="mdl_btn_update_schedule" type="button" class="btn btn-primary w-24 mr-1">Update</button>
                    <button id="mdl_btn_delete_schedule" type="button" class="btn btn-danger w-24">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="delete_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">

                <input  class="hidden delete_schedule_id">

                <div class="p-5 text-center"> <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3 fa-beat"></i>
                    <div class="text-3xl mt-5">Are you sure?</div>
                    <div class="text-slate-500 mt-2">Do you really want to delete these records? <br>This process cannot be undone.</div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                    <button id="btn_final_delete" type="button" class="btn btn-danger w-24">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="appointment_confirmation_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">

                <input  class="hidden appointment_schedule_id">

                <div class="p-5 text-center"> <i data-lucide="alert-circle" class="w-16 h-16 text-primary mx-auto mt-3 fa-beat"></i>
                    <div class="text-3xl mt-5">Are you sure?</div>
                    <div class="text-slate-500 mt-2">Do you really want to appoint this date? <br>This process cannot be undone.</div>
                </div>

                <div class="px-5 pb-8 text-center">
                    <div class="flex items-center "> <i data-lucide="calendar" class="w-4 h-4 text-slate-500 mr-2"></i> Date: <input class="hidden confirm_scheduled_date_id"> <span class="confirm_scheduled_date text-slate-600 text-xs ml-2"></span> </div>
                    <div class="flex items-center mt-3"> <i data-lucide="home" class="w-4 h-4 text-slate-500 mr-2"></i> Campus: <span class="confirm_scheduled_campus text-slate-600 text-xs ml-2"></span> </div>
                    <div class="flex items-center mt-3"> <i data-lucide="globe" class="w-4 h-4 text-slate-500 mr-2"></i>Address:<span class="confirm_campus_address text-slate-600 text-xs ml-2"></span> </div>
                    <div class="flex items-center border-t border-slate-200/60 dark:border-darkmode-400 pt-5 mt-5 font-medium"></div>
                </div>

                <div class="px-5 pb-5 text-center">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                    <button id="btn_confirm_appointment" type="button" class="btn btn-primary w-24">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="appointment_approve_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x" class="w-8 h-8 text-slate-400"></i> </a>
            <div class="modal-body p-0">

                <input  class="hidden appointment_schedule_id">
                <input  class="hidden schedule_id">

                <div class="p-5 text-center"> <i data-lucide="help-circle" class="w-16 h-16 text-primary mx-auto mt-3 fa-beat"></i>
                    <div class="text-3xl mt-5">Are you sure?</div>
                    <div class="text-slate-500 mt-2">Do you really want to approve this appointment? <br>This process cannot be undone.</div>


                </div>

                <div class="px-5 pb-5 text-center">

                    <button id="btn_disapprove_appointment" type="button" class="btn btn-outline-secondary w-auto mr-1">Dis-Approve</button>
                    <button id="btn_approve_appointment" type="button" class="btn btn-primary w-24">Approve</button>

                </div>
            </div>
        </div>
    </div>
</div>



<div id="info_modal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center"> <i data-lucide="check-circle" class="w-16 h-16 text-success mx-auto mt-3"></i>
                    <div class="text-3xl mt-5">Good job!</div>
                    <div class="text-slate-500 mt-2">You clicked the button!</div>
                </div>
                <div class="px-5 pb-8 text-center"> <button type="button" data-tw-dismiss="modal" class="btn btn-primary w-24">Ok</button> </div>
            </div>
        </div>
    </div>
</div>


<div id="approve_all_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center"> <i data-lucide="check-circle" class="w-16 h-16 text-success mx-auto mt-3"></i>
                    <div class="text-3xl mt-5">Approve All Appointments!</div>
                    <div class="text-slate-500 mt-2">You clicked the button!</div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-primary w-24">Ok</button>
                </div>
            </div>
        </div>
    </div>
</div>
