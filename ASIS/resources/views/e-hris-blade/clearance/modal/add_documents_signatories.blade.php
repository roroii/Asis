<div id="create_sem_clearance_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Add Documents</h2>
            </div>

            <div class="modal-body p-0">
                <div class="p-5 grid grid-cols-12 gap-6">


                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Clearance Name </label>
                        <input id="clearance_name" name="clearance_name" type="text" class="form-control" placeholder="Enter Clearance Name" minlength="2" required autocomplete="on">
                    </div>



                    <div class="input-form col-span-12 lg:col-span-12">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Description <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 10 characters</span> </label>
                        <textarea id="clearance_desc" name="clearance_desc" class="form-control"  placeholder="Type your description" minlength="10" required></textarea>
                    </div>

                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Signatory </label>
                        <select id="sem_clearance_signatory" style="width: 100%">
                            @forelse(get_employee() as $emps)
                                <option value="{{ $emps->agencyid }}">{{ $emps->lastname.' '.$emps->firstname }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <button id="create_sem_clearance" type="submit" class="btn btn-primary w-20">Add</button>
                <button id="update_educ_bg" type="submit" class="btn btn-primary w-20 hidden">Update</button>
            </div>
        </div>
    </div>
</div>

<div id="add_signatory_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Add Signatories</h2>
            </div>

            <div class="modal-body p-0">
                <div class="p-5 grid grid-cols-12 gap-6">

                    <input id="acad_level" class="hidden">


                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Signatory </label>
                        <select id="sem_clearance_signatory" style="width: 100%">
                            @forelse(get_employee() as $emps)
                                <option value="{{ $emps->agencyid }}">{{ $emps->lastname.' '.$emps->firstname }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <button id="add_educ_bg" type="submit" class="btn btn-primary w-20">Add</button>
                <button id="update_educ_bg" type="submit" class="btn btn-primary w-20 hidden">Update</button>
            </div>
        </div>
    </div>
</div>


<!-- BEGIN: Super Large Modal Content -->
<div id="add_clearance_modal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="alert alert-danger" style="display:none"></div>

            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">CREATE CLEARANCE </h2>
            </div>
            <!-- END: Modal Header -->

            <!-- BEGIN: Modal Body -->
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                <div class="col-span-12 sm:col-span-12">
                    <div class="intro-y">

                        <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">

                            <div class="input-form border-b border-slate-200/60 dark:border-darkmode-400 pb-5">

                                <div class="grid grid-cols-12 gap-4 gap-y-3">

                                    <div class="col-span-12 lg:col-span-6">
                                        <label for="clearance_type" class="form-label w-full flex flex-col sm:flex-row"> Clearance Type </label>
                                        <select id="clearance_type" style="width: 100%">
                                            <option></option>
                                            @forelse(get_Clearance_Type() as $clearance)
                                                <option value="{{ $clearance->id }}" data-clearance-title="{{ $clearance->type }}">{{ $clearance->type }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>

                                    <div class="col-span-12 lg:col-span-6">
                                        <label for="clearance_rc" class="form-label w-full flex flex-col sm:flex-row"> Responsibility Center </label>
                                        <select id="clearance_rc" style="width: 100%">
                                            <option></option>
                                            @forelse(load_responsibility_center('') as $rc)
                                                <option value="{{ $rc->responid }}">{{ $rc->centername }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>

                                    <div class="input-form col-span-12 lg:col-span-6">
                                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Clearance Name </label>
                                        <input id="sem_clearance_name" name="sem_clearance_name" type="text" class="form-control" placeholder="Enter Clearance Name" minlength="2" required autocomplete="on">
                                    </div>

                                    <div class="col-span-12 lg:col-span-6">
                                        <label for="clearance_desc" class="form-label w-full flex flex-col sm:flex-row"> Description <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 10 characters</span></label>
                                        <textarea id="clearance_desc" class="form-control clearance_desc" name="clearance_desc" placeholder="Type your descriptions" minlength="10" required></textarea>
                                    </div>


                                </div>
                            </div>

                            <div id="clearance_title" class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 py-5"> </div>

                        </div>
                    </div>
                </div>

                <!-- BEGIN: SEMESTRAL CLEARANCE -->
                <div id="sem_clearance_div" class="col-span-12 sm:col-span-12">

                    <!-- BEGIN: Documents and Signatory -->
                    <div class="col-span-12 sm:col-span-12 mt-5">
                        <div id="sem_clearance" class="intro-y">
                            <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5">
                                    Documents and Signatory
                                </div>
                                <div class="mt-5">
                                    <div class="col-span-12 sm:col-span-12">
                                        <div class="flex">
                                            <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">  </label>
                                            <a href="javascript:;" id="add_sem_clearance_tr" class="ml-auto text-primary truncate flex items-center"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="plus" data-lucide="plus" class="lucide lucide-plus w-4 h-4 mr-1"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Add </a>
                                        </div>
                                        <table class="table sem_clearance_table_tae">
                                            <thead>
                                            <tr>

                                                <th >Documents</th>
                                                <th >Signatory</th>
                                                <th >Office</th>
                                                <th class="text-center">Action</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END:   Documents and Signatory -->

                    <!-- BEGIN: For Approval Signatories -->
                    <div class="col-span-12 sm:col-span-12 mt-5">
                        <div id="sem_clearance_approval_signatories" class="intro-y">
                            <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5">
                                    For Approval Signatories
                                </div>
                                <div class="mt-5">
                                    <div class="col-span-12 sm:col-span-12">
                                        <div class="flex">
                                            <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">  </label>
                                            <a href="javascript:;" id="add_sem_clearance_approval_sign_tr" class="ml-auto text-primary truncate flex items-center"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="plus" data-lucide="plus" class="lucide lucide-plus w-4 h-4 mr-1"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Add </a>
                                        </div>
                                        <table class="table sem_clearance_table_approval_sig">
                                            <thead>
                                            <tr>

                                                <th >User ID</th>
                                                <th >Name</th>
                                                <th >Description</th>
                                                <th class="text-center">Action</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END:   For Approval Signatories -->

                    <!-- BEGIN: OVERLAPPING MODAL ADD TABLE ROW -->
                    <div id="add_sem_clearance_tr_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="font-medium text-base mr-auto">Add Documents and Signatories</h2>
                                </div>

                                <div class="modal-body p-0">
                                    <div class="p-5 grid grid-cols-12 gap-6">

                                        <div class="input-form col-span-12 lg:col-span-12">
                                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Document </label>
                                            <input id="sem_clearance_docs" name="sem_clearance_docs" type="text" class="form-control" placeholder="Enter Document" minlength="2" required autocomplete="on">
                                        </div>

                                        <div class="input-form col-span-12 lg:col-span-6">
                                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Signatory </label>
                                            <select id="sem_clearance_signatory_om" style="width: 100%">
                                                <option></option>
                                                @forelse(get_employee() as $emps)
                                                    <option value="{{ $emps->agencyid }}">{{ $emps->lastname.' '.$emps->firstname }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="input-form col-span-12 lg:col-span-6">
                                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Office </label>
                                            <input id="sem_clearance_office" name="sem_clearance_office" type="text" class="form-control" placeholder="Enter Office" minlength="2" required autocomplete="on">

                                            {{-- <select id="sem_clearance_rc_om" style="width: 100%">--}}
                                                {{--<option></option>--}}
                                                {{-- @forelse(load_responsibility_center('') as $rc)--}}
                                                {{-- <option value="{{ $rc->responid }}">{{ $rc->centername }}</option>--}}
                                                {{-- @empty--}}
                                                {{-- @endforelse--}}
                                                {{-- </select>--}}
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                                    <button id="btn_om_add_tr_sem_clearance" type="button" class="btn btn-primary w-20">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END:   OVERLAPPING MODAL ADD TABLE ROW -->

                    <!-- BEGIN: OVERLAPPING MODAL ADD APPROVAL SIGNATORIES -->
                    <div id="add_sem_clearance_approval_sign_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="font-medium text-base mr-auto">Add For Approval Signatories</h2>
                                </div>

                                <div class="modal-body p-0">
                                    <div class="p-5 grid grid-cols-12 gap-6">

                                        <div class="input-form col-span-12 lg:col-span-6">
                                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Signatory </label>
                                            <select id="sem_clearance__approval_signatory_om" style="width: 100%" class="sem_clearance__approval_signatory_om">
                                                <option></option>
                                                @forelse(get_employee() as $emps)
                                                    <option value="{{ $emps->agencyid }}">{{ $emps->lastname.' '.$emps->firstname }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>

                                        <div class="input-form col-span-12 lg:col-span-6">
                                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Description </label>
                                            <input id="sem_clearance_approval_desc" name="sem_clearance_approval_desc" type="text" class="form-control sem_clearance__approval_signatory_om" placeholder="Enter Description" minlength="2" required autocomplete="on">
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                                    <button id="btn_om_add_tr_sem_clearance_approval_sign" type="button" class="btn btn-primary w-20">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END:   OVERLAPPING MODAL ADD APPROVAL SIGNATORIES -->

                </div>
                <!-- END: SEMESTRAL CLEARANCE -->





                <!-- BEGIN: CIVIL SERVICE CLEARANCE -->
                <div id="csc_clearance_div" class="col-span-12 sm:col-span-12">
                    <div class="intro-y">
                        <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">

                            <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 title_div">

                            </div>

                            <div class="w-full mt-3 xl:mt-0 flex-1">
                                <div class="leading-relaxed mt-3"> <strong>To: <span id="agency_id" class="underline agency_id ml-2"></span> </strong></div>

                                <div style="margin-left: 29px" class="leading-relaxed">
                                    I hereby request clearance from money, property and work-related accountability for:
                                </div>

                                <div class="flex flex-col sm:flex-row mt-5">
                                    <div style="margin-left: 19px" class="form-check mr-4">
                                        <label class="form-check-label" for="shipping-service-standard">Purpose:</label>
                                    </div>

                                    <div class="form-check mr-4">
                                        <input id="modal_Transfer" class="form-check-input" type="radio" name="modal_joint_filing" value="1">
                                        <label class="form-check-label" for="shipping-service-standard">Transfer</label>
                                    </div>

                                    <div class="form-check mr-4 mt-2 sm:mt-0">
                                        <input id="modal_Resignation" class="form-check-input" type="radio" name="modal_joint_filing" value="2">
                                        <label class="form-check-label" for="shipping-service-custom">Resignation</label>
                                    </div>

                                    <div class="form-check mr-4 mt-2 sm:mt-0">
                                        <input id="modal_Retirement" class="form-check-input" type="radio" name="modal_joint_filing" value="3">
                                        <label class="form-check-label" for="shipping-service-custom">Retirement</label>
                                    </div>

                                    <div class="form-check mr-4 mt-2 sm:mt-0">
                                        <input id="modal_Leave" class="form-check-input" type="radio" name="modal_joint_filing" value="3">
                                        <label class="form-check-label" for="shipping-service-custom">Leave</label>
                                    </div>

                                    <div class="form-check mr-4 mt-2 sm:mt-0">
                                        <input id="modal_others" class="form-check-input" type="radio" name="modal_joint_filing" value="3">
                                        <label class="form-check-label" for="shipping-service-custom">Other Mode of Separation</label>
                                    </div>
                                </div>

                                <div id="others_mode_sep_div" style="padding-left: 19px; padding-right: 19px" class="mt-2">
                                    <input id="others_mode_sep" name="others_mode_sep" type="text" class="form-control" placeholder="Please Specify" minlength="2" required autocomplete="on">
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-4 gap-y-3 mt-5 border-t p-2">

                                <div class="col-span-12 lg:col-span-6">
                                    <label for="clearance_type" class="form-label w-full flex flex-col sm:flex-row"> Office of Assignment </label>
                                    <input id="office_assign" name="office_assign" type="date" class="form-control mt-2">
                                </div>

                                <div class="col-span-12 lg:col-span-6">
                                    <label for="clearance_type" class="form-label w-full flex flex-col sm:flex-row"> Position/SG/Step </label>
                                    <input id="pos_sg_step" name="pos_sg_step" placeholder="Position/SG/Step" type="text" class="form-control mt-2">
                                </div>

                                <div class="col-span-12 lg:col-span-6">
                                    <label for="clearance_type" class="form-label w-full flex flex-col sm:flex-row"> Name and Signature of Employee </label>
                                    <input id="name_signature" name="name_signature" type="text" class="form-control mt-2">
                                </div>
                            </div>

                            <div class="intro-y mt-5">
                                <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                    <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="chevron-down" data-lucide="chevron-down" class="lucide lucide-chevron-down w-4 h-4 mr-2"><polyline points="6 9 12 15 18 9"></polyline></svg> Product Variant </div>
                                    <div class="mt-5">
                                        <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                                            <div class="form-label sm:!mr-10">
                                                <div class="text-left">
                                                    <div class="flex items-center">
                                                        <div class="font-medium">Product Variant</div>
                                                    </div>
                                                    <div class="leading-relaxed text-slate-500 text-xs mt-2"> Add variants such as color, size, or more. Choose a maximum of 2 variant types. </div>
                                                </div>
                                            </div>
                                            <div class="w-full mt-3 xl:mt-0 flex-1 xl:text-right">
                                                <button class="btn btn-primary w-44"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="plus" data-lucide="plus" class="lucide lucide-plus w-4 h-4 mr-2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Add Variant </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- BEGIN: CIVIL SERVICE CLEARANCE -->

            </div>
            <!-- END: Modal Body -->




            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button id="cancel_documents_btn" type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <a href="javascript:;" id="btn_create_clearance" class="btn btn-primary w-20 btn_create_clearance"> Save </a>

            </div>
            <!-- END: Modal Footer -->
        </div>
    </div>
</div>
<!-- END: Super Large Modal Content -->
