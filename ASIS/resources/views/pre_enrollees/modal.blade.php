<div id="examination_status_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto modal_title">Update Status</h2>
            </div>

            <div class="modal-body p-0">

                <div class="p-5 grid grid-cols-12 gap-6">

                    <input id="transaction_id" class="hidden transaction_id">
                    <input id="pre_enrollees_id" class="hidden pre_enrollees_id">
                    <input id="exam_id" class="hidden exam_id">


                    <div class="input-form col-span-12 lg:col-span-12">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Select Status </label>
                        <select class="form-select sm:mr-2 select2_exam_status" aria-label="Default select example">
                            <option value="1">Pending</option>
                            <option value="15">Ongoing</option>
                            <option value="7">Completed</option>
                            <option value="9">Cancelled</option>
                        </select>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <button type="submit" class="btn btn-primary w-20 btn_update_exam_status">Update</button>
                {{--                <button id="edit_ld" type="submit" class="btn btn-primary w-20">Update</button>--}}
            </div>
        </div>
    </div>
</div>










<!--  BEGIN:: EXAMINATION LIST MODAL  -->
<div id="examination_details_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto modal_title">Examinees Information</h2>
            </div>

            <div class="modal-body p-0">

                <div class="p-5 grid grid-cols-12 gap-6">

                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Transaction ID </label>
                        <div class="input-group">
                            <div class="input-group-text"><i data-lucide="hash" class="w-4 h-4 text-slate-500"></i></div>
                            <input id="pre_enrollees_trans_id" disabled type="text" class="form-control min-w-[6rem] input_slots pre_enrollees_trans_id" placeholder="Transaction ID....">
                        </div>
                    </div>


                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Pre-Enrollees ID </label>
                        <div class="input-group">
                            <div class="input-group-text"><i data-lucide="hash" class="w-4 h-4 text-slate-500"></i></div>
                            <input id="pre_input_enrollees_id" disabled type="text" class="form-control min-w-[6rem] input_slots pre_enrollees_trans_id" placeholder="Transaction ID....">
                        </div>
                    </div>

                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Full Name </label>
                        <input id="pre_enrollees_fullname" disabled type="text" class="form-control pre_enrollees_fullname" placeholder="Full Name....">
                    </div>

                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Address </label>
                        <input id="pre_enrollees_address" disabled type="text" class="form-control pre_enrollees_address" placeholder="Address....">
                    </div>

                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Appointment Address </label>
                        <input id="pre_enrollees_appointment_address" disabled type="text" class="form-control pre_enrollees_fullname" placeholder="Full Name....">
                    </div>

                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Date / Time </label>
                        <input id="pre_enrollees_appointment_date_time" disabled type="text" class="form-control pre_enrollees_address" placeholder="Address....">
                    </div>

<!--                    <div class="input-form col-span-12 lg:col-span-12">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Address </label>
                        <input id="pre_enrollees_address" disabled type="text" class="form-control pre_enrollees_address" placeholder="Address....">
                    </div>-->

                </div>
            </div>



            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Close</button>
{{--                <button type="submit" class="btn btn-primary w-20 btn_update_exam_status">Save</button>--}}
                {{--                <button id="edit_ld" type="submit" class="btn btn-primary w-20">Update</button>--}}
            </div>
        </div>
    </div>
</div>
<div id="examination_add_result_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto modal_title">Add Examination Result</h2>
            </div>

            <div class="modal-body p-0">

                <input class="hidden input_examinee_id">
                <div class="p-5 grid grid-cols-12 gap-6">

                    <div class="input-form col-span-12 lg:col-span-12">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Exam Result </label>
                        <div class="input-group">
                            <div class="input-group-text"><i data-lucide="award" class="w-4 h-4 text-slate-500"></i></div>
                            <input type="number" class="form-control min-w-[6rem] input_slots exam_result" placeholder="Exam Result....">
                        </div>
                    </div>

                    <div class="input-form col-span-12 lg:col-span-12">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Stanine </label>
                        <div class="input-group">
                            <div class="input-group-text"><i data-lucide="award" class="w-4 h-4 text-slate-500"></i></div>
                            <input type="number" class="form-control min-w-[6rem] input_slots stanine_score" placeholder="Stanine....">
                        </div>
                    </div>

                </div>
            </div>



            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Close</button>
                <button type="submit" class="btn btn-primary mr-1 mb-2 btn_save_stanine_score">Save</button>
                {{--                <button id="edit_ld" type="submit" class="btn btn-primary w-20">Update</button>--}}
            </div>
        </div>
    </div>
</div>
<!--  END:: EXAMINATION LIST MODAL  -->



<!--  BEGIN:: ACCOUNTS MANAGEMENT MODAL  -->
<div id="student_account_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto modal_title">Students Account</h2>
            </div>

            <div class="modal-body p-0">

                <div class="p-5 grid grid-cols-12 gap-6">

                    <div class="input-form col-span-12 lg:col-span-12">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Student ID </label>
                        <div class="input-group">
                            <div class="input-group-text"><i data-lucide="hash" class="w-4 h-4 text-slate-500"></i></div>
                            <input id="txt_students_id" disabled type="text" class="form-control min-w-[6rem] input_slots txt_students_id" placeholder="Student ID....">
                        </div>
                    </div>


                    <div class="input-form col-span-12 lg:col-span-12">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Full Name </label>
                        <input id="txt_students_name" disabled type="text" class="form-control txt_students_name" placeholder="Full Name....">
                    </div>

                    <div class="input-form col-span-12 lg:col-span-12">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Email </label>

                        <div class="input-group mt-2">
                            <input id="txt_students_email" type="email" class="form-control txt_students_email" placeholder="Email....">
                            <a href="javascript:;" class="input-group-text btn_search_email">
                                <i data-lucide="search" class="w-4 h-4 fa-beat"></i>
                            </a>
                        </div>

                    </div>



                    <div class="input-form col-span-12 lg:col-span-12">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Password </label>
                        <div class="input-group mt-2">
                            <input id="txt_students_pass" type="password" name="txt_students_pass" class="form-control" placeholder="Password...." minlength="4" required>
                            <div id="input-group-price" class="input-group-text"><input id="mdl_btn_show_pass" class="form-check-input" type="checkbox" value=""></div>
                        </div>
                    </div>


                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Account Status </label>
                        <select class="form-select sm:mr-2 select2_account_status" aria-label="Default select example">
                            <option value="1">Active</option>
                            <option value="0">In-Active</option>
                        </select>
                    </div>

                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Email Status </label>
                        <select class="form-select sm:mr-2 select2_email_status" aria-label="Default select example">
                            <option value="1">Verified</option>
                            <option value="0">Un-Verified</option>
                        </select>
                    </div>
                </div>
            </div>



            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Close</button>
                <button class="btn btn-primary mr-1 mb-2 btn_update_student_info"> Update</button>
            </div>
        </div>
    </div>
</div>
<div id="enrollees_account_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto modal_title">Enrollees Account</h2>
            </div>

            <div class="modal-body p-0">

                <div class="p-5 grid grid-cols-12 gap-6">

                    <div class="input-form col-span-12 lg:col-span-12">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Enrollees ID </label>
                        <div class="input-group">
                            <div class="input-group-text"><i data-lucide="hash" class="w-4 h-4 text-slate-500"></i></div>
                            <input disabled type="text" class="form-control min-w-[6rem] input_slots txt_enrollees_id" placeholder="Enrollees ID....">
                        </div>
                    </div>


                    <div class="input-form col-span-12 lg:col-span-12">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Full Name </label>
                        <input disabled type="text" class="form-control txt_enrollees_name" placeholder="Full Name....">
                    </div>

                    <div class="input-form col-span-12 lg:col-span-12">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Email </label>
                        <input disabled type="text" class="form-control txt_enrollees_email" placeholder="Email....">
                    </div>


                    <div class="input-form col-span-12 lg:col-span-12">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Password </label>
                        <div class="input-group mt-2">
                            <input type="password" name="txt_enrollees_pass" id="txt_enrollees_pass" class="form-control txt_enrollees_pass" placeholder="Password...." minlength="4" required>
                            <div id="input-group-price" class="input-group-text"><input class="form-check-input mdl_btn_show_pass" type="checkbox" value=""></div>
                        </div>
                    </div>


                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Account Status </label>
                        <select class="form-select sm:mr-2 select2_enrollees_account_status" aria-label="Default select example">
                            <option value="1">Active</option>
                            <option value="0">In-Active</option>
                        </select>
                    </div>

                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Email Status </label>
                        <select class="form-select sm:mr-2 select2_enrollees_email_status" aria-label="Default select example">
                            <option value="1">Verified</option>
                            <option value="0">Un-Verified</option>
                        </select>
                    </div>
                </div>
            </div>



            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Close</button>
                <button class="btn btn-primary mr-1 mb-2 btn_update_student_info"> Update</button>
            </div>
        </div>
    </div>
</div>

<div id="students_account_settings_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto modal_title">Students Account Settings</h2>
            </div>

            <div class="modal-body p-0">

                <div class="p-5 grid grid-cols-12 gap-6">

                    <div class="input-form col-span-12 lg:col-span-12">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Student ID </label>
                        <div class="input-group">
                            <div class="input-group-text"><i data-lucide="hash" class="w-4 h-4 text-slate-500"></i></div>
                            <input disabled type="text" class="form-control min-w-[6rem] input_slots txt_students_id" placeholder="Student ID....">
                        </div>
                    </div>

                </div>
            </div>



            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Close</button>
                <button class="btn btn-primary mr-1 mb-2 btn_update_student_info"> Update</button>
            </div>
        </div>
    </div>
</div>
<!--  END:: ACCOUNTS MANAGEMENT MODAL  -->


<!--  BEGIN:: PROGRAM  -->
<div id="program_details_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto modal_title">Program Details</h2>
            </div>

            <div class="modal-body p-0">

                <div class="p-5 grid grid-cols-12 gap-6">

                    <input class="hidden program_id">

                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Program Code </label>
                        <div class="input-group">
                            <div class="input-group-text"><i data-lucide="hash" class="w-4 h-4 text-slate-500"></i></div>
                            <input disabled type="text" class="form-control min-w-[6rem] input_slots program_code" placeholder="Program Code....">
                        </div>
                    </div>


                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Program Description </label>
                        <div class="input-group">
                            <div class="input-group-text"><i data-lucide="tag" class="w-4 h-4 text-slate-500"></i></div>
                            <input disabled type="text" class="form-control min-w-[6rem] input_slots program_desc" placeholder="Program Description....">
                        </div>
                    </div>

                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Program Department </label>
                        <input disabled type="text" class="form-control program_dept" placeholder="Program Department....">
                    </div>

                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Program College </label>
                        <input disabled type="text" class="form-control program_college" placeholder="Program College....">
                    </div>

                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Available Slots </label>
                        <input type="number" class="form-control program_slots" placeholder="Available Slots....">
                    </div>

                </div>
            </div>



            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Close</button>
                <button class="btn btn-primary mr-1 mb-2 btn_update_program_slots"> Save </button>
                {{--                <button id="edit_ld" type="submit" class="btn btn-primary w-20">Update</button>--}}
            </div>
        </div>
    </div>
</div>
<!--  END:: PROGRAM  -->





<!--  BEGIN:: RATED LIST MODAL  -->
<div id="rated_list_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center">

                    <input class="hidden input_exam_list_id">
                    <i data-lucide="alert-circle" class="w-16 h-16 text-primary mx-auto mt-3"></i>

                    <div class="text-3xl mt-5">Are you sure?</div>
                    <div class="text-slate-500 mt-2">Do you really want to add this student? <br>This process cannot be undone.</div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                    <button class="btn btn-primary mr-1 mb-2 w-24 btn_add_to_shortList"> Add </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  END:: RATED LIST MODAL  -->
