<!-- BEGIN: Super Large Modal Content -->
<div id="add_clearance_modal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x" class="w-8 h-8 text-danger fa-beat"></i> </a>
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

                            <div class="input-form">

                                <div class="grid grid-cols-12 gap-4 gap-y-3">

                                    <input id="clearance_id" name="clearance_id" class="hidden">

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

{{--                                    <div class="col-span-12 lg:col-span-6">--}}
{{--                                        <label for="clearance_rc" class="form-label w-full flex flex-col sm:flex-row"> Responsibility Center </label>--}}
{{--                                        <select id="clearance_rc" style="width: 100%">--}}
{{--                                            <option></option>--}}
{{--                                            @forelse(load_responsibility_center('') as $rc)--}}
{{--                                                <option value="{{ $rc->responid }}">{{ $rc->centername }}</option>--}}
{{--                                            @empty--}}
{{--                                            @endforelse--}}
{{--                                        </select>--}}
{{--                                    </div>--}}

                                    <div class="input-form col-span-12 lg:col-span-6">
                                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Clearance Name </label>
                                        <input id="clearance_name" name="sem_clearance_name" type="text" class="form-control" placeholder="Enter Clearance Name" minlength="2" required autocomplete="on">
                                    </div>

                                    <div class="col-span-12 lg:col-span-12">
                                        <label for="clearance_desc" class="form-label w-full flex flex-col sm:flex-row"> Description </label>
                                        <input id="clearance_desc" name="clearance_desc" type="text" class="form-control" placeholder="Description..." minlength="2" required autocomplete="on">
                                    </div>

                                    <div class="col-span-12 lg:col-span-12">
                                        <button id="mdl_btn_create_new_clearance" class="btn btn-outline-primary border-dashed w-full"> <i class="w-4 h-4 mr-2" data-lucide="plus"></i> Create Clearance </button>
                                    </div>

                                </div>
                            </div>

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
                <div id="csc_clearance_div" class="col-span-12 sm:col-span-12 csc_clearance_div">
                    <div class="intro-y">
                        <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">

                            <div class="font-medium text-base text-center flex items-center pb-5 title_div">

                            </div>

                            <!-- BEGIN: III CLEARANCE FROM MONEY AND PROPERTY ACCOUNTABILITIES -->
                            <div class="intro-y mt-5">
                                <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                    <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-2">
                                        <i class="w-4 h-4 mr-2" data-lucide="chevron-down"></i> III. CLEARANCE FROM MONEY AND PROPERTY ACCOUNTABILITIES
                                    </div>

                                    <div class="mt-5">
                                        <div class="col-span-12 sm:col-span-12">
                                            <div class="flex">
                                                <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">  </label>
                                                <a href="javascript:;" id="add_csc_clearance_III_tr" class="ml-auto text-primary truncate flex items-center">  <i class="w-4 h-4 mr-2" data-lucide="plus"></i> Add </a>
                                            </div>
                                            <div class="overflow-x-auto scrollbar-hidden pb-10 mt-2">
                                                <table class="table table table-bordered dt__csc_clearance_III">
                                                    <thead>
                                                    <tr>

                                                        <th class="text-center text-xs">Type</th>
                                                        <th class="text-center text-xs">Name of Unit/Office/Department</th>
                                                        <th class="text-center text-xs">Name of Clearing Officer/Official</th>
                                                        <th class="text-center text-xs">Signature</th>
                                                        <th class="text-center text-xs">Action</th>

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
                            <!-- END:   III CLEARANCE FROM MONEY AND PROPERTY ACCOUNTABILITIES -->


                            <!-- BEGIN: IV CERTIFICATION OF NO PENDING ADMINISTRATIVE CASE -->
                            <div class="intro-y mt-5">
                                <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                    <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-2">
                                        <i class="w-4 h-4 mr-2" data-lucide="chevron-down"></i> IV. CERTIFICATION OF NO PENDING ADMINISTRATIVE CASE
                                    </div>

                                    <div class="mt-5">
                                        <div class="col-span-12 sm:col-span-12">
                                            <div class="flex">
                                                <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">  </label>
                                                <a href="javascript:;" id="add_csc_clearance_IV_tr" class="ml-auto text-primary truncate flex items-center">  <i class="w-4 h-4 mr-2" data-lucide="plus"></i> Add </a>
                                            </div>

                                            <div class="overflow-x-auto scrollbar-hidden pb-10 mt-2">
                                                <table class="table table table-bordered dt__csc_clearance_IV">
                                                    <thead>
                                                    <tr>

                                                        <th class="text-center text-xs">Type</th>
                                                        <th class="text-center text-xs">Name of Unit/Office/Department</th>
                                                        <th class="text-center text-xs">Name of Clearing Officer/Official</th>
                                                        <th class="text-center text-xs">Signature</th>
                                                        <th class="text-center text-xs">Action</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>

{{--                                    <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md form-check mt-5 p-5">--}}

{{--                                        <input id="radio_switch_pending_case" class="form-check-input ml-2" type="checkbox"> <label class="form-check-label" for="checkbox-switch-1">With pending administrative case</label>--}}
{{--                                        <input id="radio_switch_ongoing_case" class="form-check-input ml-5" type="checkbox"> <label class="form-check-label" for="checkbox-switch-1">With ongoing investigation (no formal charge yet) </label>--}}


{{--                                        <input id="radio_switch_pending_case" class="form-check-input"      type="radio" name="iv_radio_buttons" value="vertical-radio-chris-evans"> <label class="form-check-label" for="radio-switch-1">With pending administrative case</label>--}}
{{--                                        <input id="radio_switch_ongoing_case" class="form-check-input ml-5" type="radio" name="iv_radio_buttons" value="vertical-radio-chris-evans"> <label class="form-check-label" for="radio-switch-1"></label>--}}

{{--                                    </div>--}}

                                </div>
                            </div>
                            <!-- END:   IV CERTIFICATION OF NO PENDING ADMINISTRATIVE CASE -->


                            <!-- BEGIN: V CERTIFICATION -->
{{--                            <div class="intro-y mt-5">--}}
{{--                                <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">--}}
{{--                                    <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-2">--}}
{{--                                        <i class="w-4 h-4 mr-2" data-lucide="chevron-down"></i> V. CERTIFICATION--}}
{{--                                    </div>--}}

{{--                                    <div class="mt-5">--}}
{{--                                        <div class="col-span-12 sm:col-span-12">--}}
{{--                                            <div class="mt-2">--}}
{{--                                                <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">--}}

{{--                                                    <div class="form-label sm:!mr-10">--}}
{{--                                                        <div class="text-left">--}}
{{--                                                            <div class="flex items-center">--}}
{{--                                                                <div class="leading-relaxed mt-2 ml-2 text-slate-800 text-xs"> I hereby certify that this employee is cleared of work-related, money and property accountabilities from agency. This certification includes no pending administrative case from the agency.</div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

{{--                                            <div class="grid grid-cols-12 gap-4 gap-y-3 mt-4 px-2">--}}

{{--                                                <div class="col-span-12 lg:col-span-12">--}}
{{--                                                    <label for="clearance_type" class="form-label w-full flex flex-col sm:flex-row"> Head of Office </label   >--}}
{{--                                                    <select id="csc_clearance_agency_head_V" style="width: 100%">--}}
{{--                                                        @forelse(get_agency_head() as $head)--}}
{{--                                                            <option value="{{ $head->get_user_profile->agencyid }}">{{ $head->get_user_profile->firstname.' '.$head->get_user_profile->lastname }}</option>--}}
{{--                                                        @empty--}}
{{--                                                        @endforelse--}}
{{--                                                    </select>--}}
{{--                                                </div>--}}

{{--                                                <div class="col-span-12 lg:col-span-6">--}}
{{--                                                    <label for="clearance_type" class="form-label w-full flex flex-col sm:flex-row"> Date of filing </label>--}}
{{--                                                    <input id="date_filing" class="form-control" type="date">--}}
{{--                                                </div>--}}

{{--                                                <div class="col-span-12 lg:col-span-6">--}}
{{--                                                    <label for="clearance_type" class="form-label w-full flex flex-col sm:flex-row"> Date of effectivity </label>--}}
{{--                                                    <input id="date_effective" class="form-control" type="date">--}}
{{--                                                </div>--}}

{{--                                            </div>--}}



{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                </div>--}}
{{--                            </div>--}}
                            <!-- END:   IV CERTIFICATION -->

                        </div>
                    </div>
                </div>
                <!-- BEGIN: CIVIL SERVICE CLEARANCE -->

            </div>
            <!-- END: Modal Body -->




            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer clearance_mdl_footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1 btn_cancel_edit_modal">Cancel</button>
                <a href="javascript:;" id="btn_create_csc_clearance" class="btn btn-primary w-20 btn_create_clearance"> Save </a>

            </div>
            <!-- END: Modal Footer -->
        </div>
    </div>
</div>
<!-- END: Super Large Modal Content -->


<div id="add_csc_clearance_III_modal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto add_csc_clearance_signatories"> </h2>

                <div class="ml-auto form-check form-switch justify-center recent_setup_btn_div">
                    <input class="form-check-input btn_use_recent_setup_csc" type="checkbox">
                    <input class="form-check-input btn_use_recent_setup_csc_iv" type="checkbox">
                    <label class="form-check-label leading-relaxed text-slate-500 text-xs" for="preorder-active"> Use recent setup</label>
                </div>

            </div>

            <input id="csc_iii_input_id" class="hidden">
            <input id="csc_clearance_type" class="hidden">


            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3 csc_iii_inputs_div">

                <div class="col-span-12 lg:col-span-6">
                    <label for="clearance_type" class="form-label w-full flex flex-col sm:flex-row"> Office Type </label>
                    <input id="csc_clearance_office_type" name="csc_clearance_office_type" type="text" class="form-control" placeholder="Enter Office Type" minlength="2" required autocomplete="on">
                </div>

                <div class="col-span-12 lg:col-span-6">
                    <label for="clearance_type" class="form-label w-full flex flex-col sm:flex-row"> Name of Unit/Office/Department </label>
                    <input id="csc_clearance_unit_office_name" name="csc_clearance_unit_office_name" type="text" class="form-control" placeholder="Enter Name of Unit/Office/Department" minlength="2" required autocomplete="on">
                </div>

                <div class="col-span-12 lg:col-span-6">
                    <label for="clearance_type" class="form-label w-full flex flex-col sm:flex-row"> Name of Clearing Officer/Official </label>
                    <select id="csc_clearance_employees" style="width: 100%">
                        <option></option>
                        @forelse(load_employees() as $emps)
                            <option value="{{ $emps->agencyid }}">{{ $emps->firstname.' '.$emps->lastname }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>

            </div>

            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3 csc_name_recent_setup_div">

                <div class="col-span-12 lg:col-span-12">
                    <label for="clearance_type" class="form-label w-full flex flex-col sm:flex-row"> Clearance Name </label>
                    <select id="recent_clearance_name" style="width: 100%">
                        <option></option>
                        @forelse(get_Clearance_Name() as $clearance)
                            <option value="{{ $clearance->id }}">{{ $clearance->name }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>

                <div class="col-span-12 lg:col-span-12 csc_iii_recent_setup_div">
                    <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                        <div class="overflow-x-auto scrollbar-hidden pb-10">
                            <table id="dt_csc_iii_recent_setup" class="table table-report -mt-2 table-hover">
                                <thead>
                                <tr>
                                    <th class="whitespace-nowrap">Type</th>
                                    <th class="whitespace-nowrap">Name of Unit/Office/Department</th>
                                    <th class="whitespace-nowrap">Name of Clearing Officer/Official</th>
                                    <th class="whitespace-nowrap">Actions</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="col-span-12 lg:col-span-12 csc_iv_recent_setup_div">
                    <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                        <div class="overflow-x-auto scrollbar-hidden pb-10">
                            <table id="dt_csc_iv_recent_setup" class="table table-report -mt-2 table-hover">
                                <thead>
                                <tr>
                                    <th class="whitespace-nowrap">Type</th>
                                    <th class="whitespace-nowrap">Name of Unit/Office/Department</th>
                                    <th class="whitespace-nowrap">Name of Clearing Officer/Official</th>
                                    <th class="whitespace-nowrap">Actions</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

            <!-- BEGIN: Modal Footer CSC CLEARANCE III  -->
            <div id="csc_clearance_iii_div" class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1 btn_cancel_csc_recent_setup">Cancel</button>
                <button id="mdl_btn_save_csc_clearance_III_tr" type="button" class="btn btn-primary w-20"> Save</button>
                <button id="mdl_btn_update_csc_clearance_III_tr" type="button" class="btn btn-primary w-20"> Update</button>
            </div>
            <!-- END: Modal Footer CSC CLEARANCE III    -->


            <!-- BEGIN: Modal Footer CSC CLEARANCE IV  -->
            <div id="csc_clearance_iv_div" class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1 btn_cancel_csc_recent_setup">Cancel</button>
                <button id="mdl_btn_save_csc_clearance_IV_tr" type="button" class="btn btn-primary w-20"> Save</button>
                <button id="mdl_btn_update_csc_clearance_IV_tr" type="button" class="btn btn-primary w-20"> Update</button>
            </div>
            <!-- END: Modal Footer CSC CLEARANCE IV -->


        </div>
    </div>
</div>



<div id="delete_csc_iii_mdl" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">

                <input id="mdl_csc_iii_input_id" class="hidden">

                <div class="p-5 text-center"> <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                    <div class="text-3xl mt-5">Are you sure?</div>
                    <div class="text-slate-500 mt-2">Do you really want to delete this data? <br>This process cannot be undone.</div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                    <button id="btn_delete_my_csc_iii" type="button" class="btn btn-danger w-24">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>




<div id="delete_csc_iv_modal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center"> <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                    <div class="text-3xl mt-5">Are you sure?</div>
                    <div class="text-slate-500 mt-2">Do you really want to delete these records? <br>This process cannot be undone.</div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                    <button id="mdl_btn_dlete_csc_iv" type="button" class="btn btn-danger w-24">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>




<div id="request_csc_clearance_modal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x" class="w-8 h-8 text-danger fa-beat"></i> </a>
            <div class="modal-body p-0">

                <input id="mdl_request_csc_clearance_id" class="hidden">

                <div class="p-5 text-center"> <i class="fa-solid fa-paper-plane w-16 h-16 fa-beat mt-3 mx-auto text-primary"></i>
                    <div class="text-3xl mt-5">Request Clearance?</div>

                    <div class="col-span-12 sm:col-span-6 mb-2 mt-2">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Note</label>
                        <textarea style="height: 100px" id="csc_note_request" class="form-control" name="csc_note_request" placeholder="Type your note...."></textarea>
                    </div>

                </div>
                <div class="px-5 pb-8 text-center">
                    <button id="mdl_btn_send_request_csc_clearance" type="button" class="btn btn-primary w-24">Send</button>
                </div>
            </div>
        </div>
    </div>
</div>





<!-- BEGIN: My CSC CLEARANCE -->
<div id="my_csc_clearance_modal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="alert alert-danger" style="display:none"></div>

            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">My Clearance </h2>
            </div>
            <!-- END: Modal Header -->

            <!-- BEGIN: Modal Body -->
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                <!-- BEGIN: CIVIL SERVICE CLEARANCE -->
                <div id="csc_clearance_div" class="col-span-12 sm:col-span-12">
                    <div class="intro-y">
                        <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">

                            <div class="font-medium text-base text-center flex items-center pb-5 title_div">

                            </div>

                            <input class="hidden" id="mdl_my_csc_clearance_id">
                            <!-- BEGIN: I PURPOSE -->
                            <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md w-full p-5 mt-3 xl:mt-0 flex-1">

                                <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-2">
                                    <i class="w-4 h-4 mr-2" data-lucide="chevron-down"></i> I.     PURPOSE
                                </div>

                                <div class="leading-relaxed mt-3"> <strong>To: <span id="agency_id" class="underline agency_id ml-2"></span> </strong></div>

                                <div style="margin-left: 29px" class="leading-relaxed text-slate-800 text-xs">
                                    I hereby request clearance from money, property and work-related accountability for:
                                </div>

                                <div class="flex flex-col sm:flex-row mt-5">
                                    <div style="margin-left: 19px" class="form-check mr-4">
                                        <label class="form-check-label" for="shipping-service-standard">Purpose:</label>
                                    </div>

                                    <div class="form-check mr-4">
                                        <input id="modal_Transfer" class="form-check-input" type="radio" name="purpose_radio_button" value="Transfer">
                                        <label class="form-check-label" for="shipping-service-standard">Transfer</label>
                                    </div>

                                    <div class="form-check mr-4 mt-2 sm:mt-0">
                                        <input id="modal_Resignation" class="form-check-input" type="radio" name="purpose_radio_button" value="Resignation">
                                        <label class="form-check-label" for="shipping-service-custom">Resignation</label>
                                    </div>

                                    <div class="form-check mr-4 mt-2 sm:mt-0">
                                        <input id="modal_Retirement" class="form-check-input" type="radio" name="purpose_radio_button" value="Retirement">
                                        <label class="form-check-label" for="shipping-service-custom">Retirement</label>
                                    </div>

                                    <div class="form-check mr-4 mt-2 sm:mt-0">
                                        <input id="modal_Leave" class="form-check-input" type="radio" name="purpose_radio_button" value="Leave">
                                        <label class="form-check-label" for="shipping-service-custom">Leave</label>
                                    </div>

                                    <div class="form-check mr-4 mt-2 sm:mt-0">
                                        <input id="modal_others" class="form-check-input" type="radio" name="purpose_radio_button" value="Others">
                                        <label class="form-check-label" for="shipping-service-custom">Other Mode of Separation</label>
                                    </div>
                                </div>

                                <div id="others_mode_sep_div" style="padding-left: 19px; padding-right: 19px" class="mt-2">
                                    <input id="others_mode_sep" name="others_mode_sep" type="text" class="form-control" placeholder="Please Specify" minlength="2" required autocomplete="on">
                                </div>

                            </div>

                            <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md grid grid-cols-12 gap-4 gap-y-3 mt-5 border-t p-5">

                                <div class="col-span-12 lg:col-span-6">
                                    <label for="clearance_type" class="form-label w-full flex flex-col sm:flex-row"> Office of Assignment </label>
                                    <select id="csc_clearance_rc" style="width: 100%">
                                        <option></option>
                                        @forelse(load_responsibility_center('') as $rc)
                                            <option value="{{ $rc->responid }}">{{ $rc->centername }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-span-12 lg:col-span-6">
                                    <label for="clearance_type" class="form-label w-full flex flex-col sm:flex-row"> Position </label>
                                    <select class="csc_clearance_pos" style="width: 100%">
                                        <option></option>
                                        @forelse(get_employee_position() as $pos)
                                            <option value="{{ $pos->id }}">{{ $pos->emp_position }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-span-12 lg:col-span-6">
                                    <label for="clearance_type" class="form-label w-full flex flex-col sm:flex-row"> Salary Grade </label>
                                    <select id="csc_clearance_sg" style="width: 100%">
                                        <option></option>
                                        @forelse(get_salary_grade() as $sg)
                                            <option value="{{ $sg->id }}">{{ $sg->code }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-span-12 lg:col-span-6">
                                    <label for="clearance_type" class="form-label w-full flex flex-col sm:flex-row"> Step </label   >
                                    <select id="csc_clearance_step" style="width: 100%">
                                        <option></option>
                                        @forelse(get_sg_step() as $step)
                                            <option value="{{ $step->id }}">{{ $step->stepname }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <!-- END:   I PURPOSE -->


                            <!-- BEGIN: II CLEARANCE FROM WORK-RELATED ACCOUNTABILITIES -->
                            <div class="intro-y mt-5">
                                <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                    <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-2"> <i class="w-4 h-4 mr-2" data-lucide="chevron-down"></i> II. CLEARANCE FROM WORK-RELATED ACCOUNTABILITIES</div>

                                    <div class="mt-2">
                                        <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">

                                            <div class="form-label sm:!mr-10">
                                                <div class="text-left">
                                                    <div class="flex items-center">
                                                        <div class="leading-relaxed mt-2 ml-2 text-slate-800 text-xs"> We hereby certify that this employee is cleared

                                                            <input id="radio_switch_cleared" class="form-check-input ml-2" type="checkbox"> <label class="form-check-label" for="checkbox-switch-1">/ not cleared</label>
                                                            <input id="radio_switch_un_cleared" class="form-check-input ml-2" type="checkbox"> <label class="form-check-label" for="checkbox-switch-1">of work-related accountabilities from this Unit/Office/Dept.</label>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-12 gap-4 gap-y-3 mt-4 px-2">

                                        <div class="col-span-12 lg:col-span-6">
                                            <label for="clearance_type" class="form-label w-full flex flex-col sm:flex-row"> Immediate Supervisor </label>
                                            <select id="csc_immediate_supervisor" style="width: 100%">
                                                <option></option>
                                            </select>
                                        </div>
                                        <div class="col-span-12 lg:col-span-6">
                                            <label for="clearance_type" class="form-label w-full flex flex-col sm:flex-row"> Head of Office </label   >
                                            <select id="csc_clearance_agency_head" style="width: 100%">
                                                @forelse(get_agency_head() as $head)
                                                    <option value="{{ $head->get_user_profile->agencyid }}">{{ $head->get_user_profile->firstname.' '.$head->get_user_profile->lastname }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- END:   II CLEARANCE FROM WORK-RELATED ACCOUNTABILITIES -->


                            <!-- BEGIN: III CLEARANCE FROM MONEY AND PROPERTY ACCOUNTABILITIES -->
                            <div class="intro-y mt-5">
                                <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                    <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-2">
                                        <i class="w-4 h-4 mr-2" data-lucide="chevron-down"></i> III. CLEARANCE FROM MONEY AND PROPERTY ACCOUNTABILITIES
                                    </div>

                                    <div class="mt-5">
                                        <div class="col-span-12 sm:col-span-12">
                                            <div class="overflow-x-auto scrollbar-hidden pb-10 mt-2">
                                                <table class="table table dt_my_csc_clearance_III">
                                                    <thead>
                                                    <tr>

                                                        <th class="text-center border-l border-t text-xs"></th>
                                                        <th class="text-center border-r border-t text-xs">Name of Unit/Office/Department</th>
                                                        <th class="text-center border-r border-t text-xs">Cleared</th>
                                                        <th class="text-center border-r border-t text-xs">Not Cleared</th>
                                                        <th class="text-center border-r border-t text-xs">Name of Clearing Officer/Official</th>
                                                        <th class="text-center border-r border-t text-xs">Signature</th>

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
                            <!-- END:   III CLEARANCE FROM MONEY AND PROPERTY ACCOUNTABILITIES -->


                            <!-- BEGIN: IV CERTIFICATION OF NO PENDING ADMINISTRATIVE CASE -->
                            <div class="intro-y mt-5">
                                <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                    <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-2">
                                        <i class="w-4 h-4 mr-2" data-lucide="chevron-down"></i> IV. CERTIFICATION OF NO PENDING ADMINISTRATIVE CASE
                                    </div>

                                    <div class="mt-5">
                                        <div class="col-span-12 sm:col-span-12">
                                            <div class="overflow-x-auto scrollbar-hidden mt-2">
                                                <table class="table table dt_my_csc_clearance_IV">
                                                    <thead>
                                                    <tr>

                                                        <th class="text-center border-l border-t text-xs"></th>
                                                        <th class="text-center border-r border-t text-xs">Name of Unit/Office/Department</th>
                                                        <th class="text-center border-r border-t text-xs">Cleared</th>
                                                        <th class="text-center border-r border-t text-xs">Not Cleared</th>
                                                        <th class="text-center border-r border-t text-xs">Name of Clearing Officer/Official</th>
                                                        <th class="text-center border-r border-t text-xs">Signature</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md form-check mt-5 p-5">

                                        <input id="radio_switch_pending_case" class="form-check-input ml-2" type="checkbox"> <label class="form-check-label" for="checkbox-switch-1">With pending administrative case</label>
                                        <input id="radio_switch_ongoing_case" class="form-check-input ml-5" type="checkbox"> <label class="form-check-label" for="checkbox-switch-1">With ongoing investigation (no formal charge yet) </label>

                                    </div>

                                </div>
                            </div>
                            <!-- END:   IV CERTIFICATION OF NO PENDING ADMINISTRATIVE CASE -->


                            <!-- BEGIN: V CERTIFICATION -->
                                <div class="intro-y mt-5">
                                    <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                        <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-2">
                                            <i class="w-4 h-4 mr-2" data-lucide="chevron-down"></i> V. CERTIFICATION
                                        </div>

                                        <div class="mt-5">
                                            <div class="col-span-12 sm:col-span-12">
                                                <div class="mt-2">
                                                    <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">

                                                        <div class="form-label sm:!mr-10">
                                                            <div class="text-left">
                                                                <div class="flex items-center">
                                                                    <div class="leading-relaxed mt-2 ml-2 text-slate-800 text-xs"> I hereby certify that this employee is cleared of work-related, money and property accountabilities from agency. This certification includes no pending administrative case from the agency.</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="grid grid-cols-12 gap-4 gap-y-3 mt-4 px-2">

                                                    <div class="col-span-12 lg:col-span-12">
                                                        <label for="clearance_type" class="form-label w-full flex flex-col sm:flex-row"> Head of Office </label   >
                                                        <select id="csc_clearance_agency_head_V" style="width: 100%">
                                                            @forelse(get_agency_head() as $head)
                                                                <option value="{{ $head->get_user_profile->agencyid }}">{{ $head->get_user_profile->firstname.' '.$head->get_user_profile->lastname }}</option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                    </div>

                                                    <div class="col-span-12 lg:col-span-6">
                                                        <label for="clearance_type" class="form-label w-full flex flex-col sm:flex-row"> Date of filing </label>
                                                        <input id="date_filing" class="form-control" type="date">
                                                    </div>

                                                    <div class="col-span-12 lg:col-span-6">
                                                        <label for="clearance_type" class="form-label w-full flex flex-col sm:flex-row"> Date of effectivity </label>
                                                        <input id="date_effective" class="form-control" type="date">
                                                    </div>

                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                        <!-- END:   IV CERTIFICATION -->

                        </div>
                    </div>
                </div>
                <!-- BEGIN: CIVIL SERVICE CLEARANCE -->

            </div>
            <!-- END: Modal Body -->




            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer clearance_mdl_footer">
                <button id="cancel_documents_btn" type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <a href="javascript:;" id="btn_create_my_csc_clearance" class="btn btn-primary w-20 btn_create_clearance"> Save </a>

            </div>
            <!-- END: Modal Footer -->
        </div>
    </div>
</div>
<!-- END: My CSC CLEARANCE -->





<!-- BEGIN: CLEARANCE REQUEST INFO -->
<div id="modal_request_info" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center"> <i class="fa-solid fa-paper-plane w-16 h-16 text-warning mx-auto mt-3 fa-beat"></i>
                    <div class="text-3xl mt-5">Pending Request...</div>
                    <div class="text-slate-500 mt-2">Please contact your Human Resource Officer!</div>
                </div>
                <div class="px-5 pb-8 text-center"> <button type="button" data-tw-dismiss="modal" class="btn w-24 btn-primary">Ok</button> </div>
            </div>
        </div>
    </div>
</div>
<!-- END: CLEARANCE REQUEST INFO -->


<!-- BEGIN: CLEARANCE APPROVE DISAPPROVED REQUEST -->
<div id="approve_disapprove_csc_clearance_modal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x" class="w-8 h-8 text-danger fa-beat"></i> </a>
            <div class="modal-body p-0">

                <input id="mdl_approve_disapprove_csc_clearance_id" class="hidden">
                <input id="mdl_csc_clearance__request_id" class="hidden">

                <div class="p-5 text-center"> <i class="fa-solid fa-thumbs-up w-16 h-16 mt-3 mx-auto text-primary"></i>
                    <div class="text-3xl mt-5">Clearance Approval</div>

                    <div class="col-span-12 sm:col-span-6 mb-2 mt-5">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Clearance Name</label>
                        <textarea disabled style="height: 80px" id="mdl_approve_disapprove_clearance_name" class="form-control" name="mdl_approve_disapprove_clearance_name" placeholder="Clearance Name"></textarea>
                    </div>

                    <div class="col-span-12 sm:col-span-6 mb-2 mt-2">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Note</label>
                        <textarea style="height: 100px" id="mdl_approve_disapprove_response_note" class="form-control" name="mdl_approve_disapprove_response_note" placeholder="Type your note...."></textarea>
                    </div>

                </div>
                <div class="px-5 pb-8 text-center">
                    <button id="mdl_btn_disapprove_request" type="button" class="btn btn-outline-secondary mr-3">Dis-approve</button>
                    <button id="mdl_btn_approve_request"    type="button" class="btn btn-primary w-24">Approve</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END:   CLEARANCE APPROVE DISAPPROVED REQUEST -->




<!-- BEGIN: CLEARANCE REQUEST INFO -->
<div id="modal_request_disapproved_info" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center"> <i class="fa-solid fa-triangle-exclamation w-16 h-16 text-danger mx-auto mt-3 fa-beat"></i>
                    <div class="text-3xl mt-5">Disapproved Request!!!</div>
                    <div class="text-slate-500 mt-2">Something went wrong to your request!</div>
                </div>
                <div class="px-5 pb-8 text-center"> <button type="button" data-tw-dismiss="modal" class="btn w-24 btn-primary">Ok</button> </div>
                <div class="p-5 text-center border-t border-slate-200/60 dark:border-darkmode-400"> <a href="javascript:;" class="text-primary">PLease contact your Human Resource Officer!</a> </div>
            </div>
        </div>
    </div>
</div>
<!-- END: CLEARANCE REQUEST INFO -->




<!-- BEGIN: CLEARANCE SIGNATORIES SIGN -->
<div id="modal_signatory_sign" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x" class="w-8 h-8 text-danger fa-beat"></i> </a>
            <div class="modal-body p-5">
                <div class="p-5 text-center"> <i class="fa-solid fa-layer-group w-16 h-16 text-success mx-auto mt-3 fa-beat"></i>
                    <div class="text-3xl mt-5">Validate Employees Accountabilities</div>
                    <div class="text-slate-500 mt-2"></div>
                </div>

                <div class="mt-5">

                    <input class="hidden mdl_input_signatory_id">
                    <input class="hidden mdl_input_employee_id">
                    <input class="hidden mdl_input_clearance_request_id">

                    <label>Signature Approval for <span class="unit_office_name"></span></label>

                    <div class="mt-4">
                        <div class="form-check form-switch">
                            <input id="checkbox_cleared_not_cleared" class="form-check-input" type="checkbox">
                            <label class="form-check-label" for="checkbox-switch-7">Check if cleared</label>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="form-check form-switch">
                            <input id="checkbox_signature" class="form-check-input" type="checkbox">
                            <label class="form-check-label" for="checkbox-switch-7">Check to enable signature</label>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 sm:col-span-6 mb-2 mt-5">
                    <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Note</label>
                    <textarea style="height: 100px" id="mdl_signatory_note" class="form-control" name="mdl_signatory_note" placeholder="Type your note...."></textarea>
                </div>

                <div class="px-5 mt-5 text-center">
                    <button id="mdl_btn_submit_signatory" type="button" class="btn w-24 btn-primary">Submit</button>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- END:   CLEARANCE SIGNATORIES SIGN -->




<!-- BEGIN: ADMIN CLEARANCE UPDATE STATUS -->
<div id="modal_clearance_status" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x" class="w-8 h-8 text-danger fa-beat"></i> </a>
                <div class="modal-body p-5">
                    <div class="p-5 text-center mdl_status_title">

                    </div>

                    <div class="mt-5">

                        <input class="hidden mdl_input_clearance_status_id">

                        <div class="mt-4">
                            <div class="form-check form-switch justify-center">
                                <input id="checkbox_switch_clearance_status" class="form-check-input" type="checkbox">
                                <label class="form-check-label ml-3 switch_label" for="checkbox-switch-7">Activate</label>
                            </div>
                        </div>


                        <div class="px-5 mt-7 text-center">
                            <button id="mdl_btn_update_clearance_status" type="button" class="btn w-24 btn-primary">Update</button>
                        </div>

                    </div>
            </div>
        </div>
    </div>
</div>
<!-- END:   ADMIN CLEARANCE UPDATE STATUS -->



<!-- BEGIN: CLEARANCE VIEW ACTIVITY INFO -->
<div id="activity_info_modal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x" class="w-8 h-8 text-danger fa-beat"></i> </a>
            <div class="modal-body p-0">

                <input id="mdl_csc_clearance_signatory_id" class="hidden">

                <div class="p-5 text-center"><i class="fa-solid fa-circle-info w-16 h-16 mt-3 mx-auto text-primary"></i>
                    <div class="text-3xl mt-5">Clearing Officer/Officials Response</div>


                    <div class="text-left mt-8 clearing_official_response_div">

                        <!-- HTML DATA ARE LOADED FROM JAVASCRIPT NG INA MO! -->

                    </div>

                    <div class="px-5 py-5 text-center">
                        <button id="mdl_btn_resubmit_clearance"    type="button" class="btn btn-primary w-24">Resubmit</button>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<!-- END:   CLEARANCE VIEW ACTIVITY INFO -->





<!-- BEGIN: CLEARANCE ADD IMPORTANT NOTES -->
<div id="important_notes_modal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x" class="w-8 h-8 text-danger fa-beat"></i> </a>
            <div class="modal-body p-0">

                <div class="p-5 text-center"> <i class="fa-solid fa-clipboard w-16 h-16 mt-3 mx-auto text-primary"></i>
                    <div class="text-3xl mt-5">Add Important Notes</div>

                    <div class="col-span-12 sm:col-span-6 mb-2 mt-8">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row mt-5"> Select Target</label>
                    </div>

                    <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-2 col-span-12 sm:col-span-6 mb-2 mt-2 clearance_target_div">

                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Responsibility Center</label>
                        <select id="clearance_note_rc" style="width: 100%">
                            <option></option>
                            @forelse (loadrc('') as $rc)
                                <option value="{{ $rc->responid }}">{{ $rc->centername }}</option>
                            @empty
                            @endforelse
                        </select>



                        <div>
                            <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row mt-2"> Employee</label>
                            <select id="clearance_note_employees" style="width: 100%" multiple>
                                @forelse (load_profile('') as $emps)
                                    <option value="{{ $emps->agencyid }}">{{ $emps->firstname.' '.$emps->lastname }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>

                    <div class="col-span-12 sm:col-span-6 mb-2 mt-5">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Title</label>
                        <input id="mdl_note_title" type="text" class="form-control" placeholder="Title...">
                    </div>

                    <div class="col-span-12 sm:col-span-6 mb-2 mt-2">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Note</label>
                        <textarea style="height: 100px" id="mdl_important_notes" class="form-control" name="mdl_important_notes" placeholder="Type your note...."></textarea>
                    </div>

                </div>
                <div class="px-5 pb-8 text-center">
                    <button id="mdl_btn_submit_notes"   type="button" class="btn btn-primary w-24">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END:   CLEARANCE ADD IMPORTANT NOTES -->



<!-- BEGIN: CLEARANCE OPEN IMPORTANT NOTES -->
<div id="view_important_notes_modal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x" class="w-8 h-8 text-danger fa-beat"></i> </a>
            <div class="modal-body p-0">

                <div class="p-5 text-center"> <i class="fa-solid fa-clipboard w-16 h-16 mt-3 mx-auto text-primary"></i>
                    <div class="text-3xl mt-5">Important Notes</div>

                    <div class="col-span-12 sm:col-span-6 mb-2 mt-8">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row mt-5"> Author Information</label>
                    </div>

                    <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-2 col-span-12 sm:col-span-6 mb-2 mt-2">

                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Name of Author</label>
                        <input id="mdl_clearing_official_name" disabled type="text" class="form-control">

                        <div class="mt-2">
                            <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Name of Unit/Office/Department</label>
                            <input id="mdl_unit_office_dept" disabled type="text" class="form-control">
                        </div>
                    </div>

                    <div class="col-span-12 sm:col-span-6 mb-2 mt-2">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Message</label>
                        <textarea style="height: 100px" class="form-control clearance_content" placeholder="Type your note...." disabled></textarea>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- END:   CLEARANCE OPEN IMPORTANT NOTES -->



<!-- BEGIN: COMPLETED CLEARANCE MODAL -->
<div id="completed_clearance_modal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto"> List of Employee's Completed on Clearance </h2>
            </div>

            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                <div class="col-span-12 lg:col-span-6">
                    <select id="created_clearance_select" style="width: 100%">
                        <option></option>
                        @forelse(get_Clearance_Name() as $clearance)
                            <option value="{{ $clearance->id }}">{{ $clearance->name }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>

                <div class="col-span-12 lg:col-span-6">
{{--                    <a href="/clearanceSignatories/print/cleared/reports" target="_blank" class="btn btn-primary flex items-center btn_print_cleared_clearance_report"> <i data-lucide="printer" class="w-4 h-4 mr-2"></i>  Print Report </a>--}}
                    <button class="btn btn-primary flex items-center btn_print_cleared_clearance_report"> <i data-lucide="printer" class="w-4 h-4 mr-2"></i>  Print Report </button>
                </div>

            </div>

            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 lg:col-span-12">
                    <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                        <div class="overflow-x-auto scrollbar-hidden pb-10">
                            <table id="dt_employee_list_completed_clearance" class="table table-report -mt-2 table-hover">
                                <thead>
                                <tr>
                                    <th class="whitespace-nowrap">Employee Name</th>
                                    <th class="whitespace-nowrap">Position/Designation</th>
                                    <th class="whitespace-nowrap">Responsibility Center</th>
                                    <th class="whitespace-nowrap">Date Completed</th>
                                    <th class="whitespace-nowrap">Status</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

            <!-- BEGIN: Modal Footer CSC CLEARANCE III  -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
            </div>
            <!-- END: Modal Footer CSC CLEARANCE III    -->


        </div>
    </div>
</div>
<!-- END:   COMPLETED CLEARANCE MODAL -->



<!-- BEGIN: CLEARANCE UNABLE TO EDIT INFO -->
<div id="modal_unable_edit_info" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center"> <i class="fa-solid fa-triangle-exclamation w-16 h-16 text-warning mx-auto mt-3 fa-beat"></i>
                    <div class="text-3xl mt-5">Unable to Edit!!!</div>
                    <div class="text-slate-500 mt-2">Closed Clearance, cannot edit this one!</div>
                </div>
                <div class="px-5 pb-8 text-center"> <button type="button" data-tw-dismiss="modal" class="btn w-24 btn-primary">Ok</button> </div>
                <div class="p-5 text-center border-t border-slate-200/60 dark:border-darkmode-400"> <a href="javascript:;" class="text-primary">PLease contact your Human Resource Officer!</a> </div>
            </div>
        </div>
    </div>
</div>
<!-- END: CLEARANCE UNABLE TO EDIT INFO -->
