<div id="add_family_bg_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Add Family Background</h2>
            </div>

            <div class="modal-body p-0">

                <div class="p-5 grid grid-cols-12 gap-6">

                    <div class="input-form col-span-12 lg:col-span-12">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Person Type  </label>
                        <select class="select2 w-full" id="family_bg_type">
                            <option value="Spouse">Spouse</option>
                            <option value="Father">Father</option>
                            <option value="Mother">Mother</option>
                        </select>
                    </div>

                    <div id="spouse_tab" class="grid col-span-12 lg:col-span-12 gap-4">

                        <div class="input-form col-span-6 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Surname </label>
                            <input id="fam_spouse_surname" type="text" name="fam_spouse_surname" class="form-control" placeholder="Surname" minlength="2" autocomplete="off">
                        </div>
                        <div class="input-form col-span-12 lg:col-span-3">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> First Name </label>
                            <input id="fam_spouse_first_name" type="text" name="fam_spouse_first_name" class="form-control" placeholder="First Name" minlength="2" autocomplete="off">
                        </div>
                        <div class="input-form col-span-6 lg:col-span-3">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Name Extension <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">(JR, SR)</span> </label>
                            <input id="fam_spouse_name_ext" type="text" name="fam_father_name_ext" class="form-control" placeholder="Name Extension" minlength="2" autocomplete="off">
                        </div>
                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Middle Name </label>
                            <input id="fam_spouse_mid_name" type="text" name="fam_spouse_mid_name" class="form-control" placeholder="Middle Name" minlength="2" autocomplete="off">
                        </div>
                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Occupation </label>
                            <input id="fam_occupation" type="text" name="fam_occupation" class="form-control" placeholder="Occupation" minlength="2" autocomplete="off">
                        </div>
                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Employer/Business Name </label>
                            <input id="occupation_employer" type="text" name="occupation_employer" class="form-control" placeholder="Employer/Business Name" minlength="2" autocomplete="off">
                        </div>
                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Business Address </label>
                            <input id="occupation_address" type="text" name="occupation_address" class="form-control" placeholder="Business Address" minlength="2" autocomplete="off">
                        </div>
                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Telephone No. </label>
                            <input id="occupation_tel_no" type="text" name="occupation_tel_no" class="form-control" placeholder="Telephone No." minlength="2" autocomplete="off">
                        </div>
                    </div>

                    <div id="father_tab" class="grid col-span-12 lg:col-span-12 gap-4">
                        <!-- BEGIN: Fathers INFO -->
                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Surname </label>
                            <input id="fam_father_surname" type="text" name="fam_father_surname" class="form-control" placeholder="Surname" minlength="2" autocomplete="off">
                        </div>
                        <div class="input-form col-span-6 lg:col-span-3">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> First Name </label>
                            <input id="fam_father_first_name" type="text" name="fam_father_first_name" class="form-control" placeholder="First Name" minlength="2" autocomplete="off">
                        </div>
                        <div class="input-form col-span-6 lg:col-span-3">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Name Extension <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">(JR, SR)</span> </label>
                            <input id="fam_father_name_ext" type="text" name="fam_father_name_ext" class="form-control" placeholder="Name Extension" minlength="2" autocomplete="off">
                        </div>
                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Middle Name </label>
                            <input id="fam_father_mid_name" type="text" name="fam_father_mid_name" class="form-control" placeholder="Middle Name" minlength="2" autocomplete="off">
                        </div>
                        <!-- END: Fathers INFO -->
                    </div>

                    <div id="mother_tab" class="grid col-span-12 lg:col-span-12 gap-4">
                        <!-- BEGIN: Mothers INFO -->
                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Mother's Maiden Name </label>
                            <input id="fam_mother_maiden_name" type="text" name="fam_mother_maiden_name" class="form-control" placeholder="Father's Surname" minlength="2" autocomplete="off">
                        </div>
                        <div class="input-form col-span-6 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Surname </label>
                            <input id="fam_mother_surname" type="text" name="fam_mother_surname" class="form-control" placeholder="Surname" minlength="2" autocomplete="off">
                        </div>
                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> First Name </label>
                            <input id="fam_mother_first_name" type="text" name="fam_father_first_name" class="form-control" placeholder="First Name" minlength="2" autocomplete="off">
                        </div>
                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Middle Name </label>
                            <input id="fam_mother_mid_name" type="text" name="fam_father_mid_name" class="form-control" placeholder="Middle Name" minlength="2" autocomplete="off">
                        </div>
                        <!-- END: Mothers INFO -->
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-2 mb-2"> Cancel</button>
                <button id="btn_add_family_bg" type="submit" class="btn btn-primary w-20 mr-2 mb-2"> <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Add </button>

            </div>
        </div>
    </div>
</div>
