<div id="modal_payroll_info" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">
                    Payroll Information
                </h2>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                <div class="input-form col-span-12 lg:col-span-12">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Employee's </label>
                    <select class="select2 w-full payroll_employee">
                        <option></option>
                        @foreach(payroll_Employee('') as $emp)
                            @if($emp->get_user_profile)
                                <option value="{{ $emp->get_user_profile->employee_id }}">{{ $emp->get_user_profile->firstname." ".$emp->get_user_profile->lastname }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>


                <div class="input-form col-span-12 lg:col-span-6">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Position </label>
                    <select class="select2 w-full payroll_position">
                        <option></option>
                        @forelse (payroll_Position('') as $pos)
                            <option value="{{ $pos->id }}">{{ $pos->emp_position }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>

                <div class="input-form col-span-12 lg:col-span-6">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Designation </label>
                    <select class="select2 w-full payroll_designation">
                        <option></option>
                        @forelse (payroll_Position('') as $pos)
                            <option value="{{ $pos->id }}">{{ $pos->emp_position }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>

                <div class="input-form col-span-12 lg:col-span-6">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Status </label>
                    <select class="select2 w-full payroll_emp_status">
                        <option></option>
                        <option value="1">Permanent</option>
                        <option value="2">Temporary Status</option>
                        <option value="3">Part-Time Lecturer</option>
                        <option value="4">Contractual/COS</option>
                        <option value="5">Job Order</option>
                        <option value="6">Pakyaw</option>
                    </select>
                </div>

                <div class="input-form col-span-12 lg:col-span-6">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Rank </label>
                    <select class="select2 w-full payroll_emp_rank">
                        <option></option>
                        @forelse (payroll_Position('') as $pos)
                            <option value="{{ $pos->id }}">{{ $pos->emp_position }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>

                <div class="input-form col-span-12 lg:col-span-6">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Tranch(Salary Grade/Step) </label>
                    <select class="select2 w-full payroll_tranch">
                        <option></option>
                        @foreach(payroll_Salary_Grade() as $sg)
                            @if($sg->get_salary_grade)
                                <option value="{{ $sg->id }}">{{ $sg->get_salary_grade->name .', '. $sg->stepname }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="input-form col-span-12 lg:col-span-6">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Agency </label>
                    <select class="select2 w-full payroll_agency">
                        <option></option>
                        @forelse (payroll_Agency('') as $agency)
                            <option value="{{ $agency->id }}">{{ $agency->value }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>

                <div class="input-form col-span-12 lg:col-span-6">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Salary Type </label>
                    <select class="select2 w-full payroll_sal_type">
                        <option></option>
                        <option value="1">Monthly</option>
                        <option value="2">Daily</option>
                        <option value="3">Per Hour</option>
                        <option value="4">Pakyaw</option>
                    </select>
                </div>

                <div class="input-form col-span-12 lg:col-span-6">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Salary </label>
                    <select class="select2 w-full payroll_salary">
                        <option></option>
                        @forelse (payroll_Position('') as $pos)
                            <option value="{{ $pos->id }}">{{ $pos->emp_position }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>

                <div class="input-form col-span-12 lg:col-span-6">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Has Tax Exemption? </label>
                    <select class="select2 w-full payroll_has_tax_exempt">
                        <option value="0">NO</option>
                        <option value="1">YES</option>
                    </select>
                </div>

                <div class="input-form col-span-12 lg:col-span-6">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Office/Department </label>
                    <select class="select2 w-full payroll_office_dept">
                        <option></option>
                        @forelse (payroll_Position('') as $pos)
                            <option value="{{ $pos->id }}">{{ $pos->emp_position }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>

                <div class="input-form col-span-12 lg:col-span-6">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Assignment Start Date </label>
                   <input id="payroll_assignment_start_date" type="date" class="form-control payroll_assignment_date">
                </div>

                <div class="input-form col-span-12 lg:col-span-6">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Assignment End Date </label>
                    <input id="payroll_assignment_date" type="date" class="form-control payroll_assignment_end_date">
                </div>

                <div class="input-form col-span-12 lg:col-span-6">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Assignment Status </label>
                    <select class="select2 w-full payroll_assignment_status">
                        <option></option>
                        <option value="1">Active</option>
                        <option value="2">End of Contract</option>
                        <option value="3">Resigned</option>
                        <option value="4">Re-Assigned</option>
                        <option value="4">Transfered</option>
                        <option value="4">On-Hold</option>
                        <option value="4">Terminated</option>
                    </select>
                </div>

            </div>

            <!-- END: Modal Body -->

            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <a href="javascript:;" id="mdl_btn_save_payroll_info" class="btn btn-primary w-20">Save <i data-lucide="save" style="color: rgb(255, 255, 255)" class="w-4 h-4 text-slate-500 ml-auto"></i></a>
            </div>
            <!-- END: Modal Footer -->
        </div>
    </div>
</div>
