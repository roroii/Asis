<!-- Add Documents Modal -->
<div id="employee_modal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Employee</h2>
                </div>
                <!-- END: Modal Header -->

                <!-- BEGIN: Modal Body -->

                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <input hidden id="modal_update_emp_id" type="text" class="form-control" placeholder="id">

                    <div hidden class="col-span-12 sm:col-span-6">
                        <label for="modal-form-1" class="form-label">Employee ID</label>
                        <select class="w-full"id="modal_employee_id">
                            <option data-ass-type="user" value="{{ generate_employee_id(\App\Models\ASIS_Models\HRIS_model\employee::get()->count()) }}">{{ generate_employee_id(\App\Models\ASIS_Models\HRIS_model\employee::get()->count()) }}</option>
                        </select>
                    </div>
                    {{-- <div class="col-span-12 sm:col-span-12">
                        <label for="modal-form-2" class="form-label">Employment Type</label>
                        <input id="modal_employment_type" type="text" class="form-control" value="<?php echo ('yyyy-MM-dd')?>">
                    </div> --}}

                    <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-1" class="form-label">Start Date</label>
                        <input id="modal_start_date" type="date" class="form-control" placeholder="Start Date">
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-2" class="form-label">End Date</label>
                        <input id="modal_end_date" type="date" class="form-control" placeholder="End Date">
                    </div>

                    <div class="col-span-12 sm:col-span-12">
                        <label for="modal-form-2" class="form-label">Employment Type</label>
                        <div class="input-group flex-1">
                            <select class="w-full" id="modal_employment_type">
                                @forelse (load_employment_type('') as $employment_type)
                                    <option value="{{ $employment_type->id }}">{{ $employment_type->name }}</option>

                                @empty

                                @endforelse
                            </select>
                            <div class="pl-5"><a href="javascript:;" class="btn btn-outline-secondary" data-tw-toggle="modal" data-tw-target="#modal_second_add_employment_type"><i data-lucide="plus" class="w-4 h-5"></i></a></div>
                        </div>
                    </div>


                    <div class="col-span-12 sm:col-span-12">
                        <label for="modal-form-2" class="form-label">Designation</label>
                        <div class="input-group flex-1">
                            <select class="w-full" id="modal_designation_id">
                                @forelse (load_designation('') as $designation)
                                    <option value="{{ $designation->id }}">{{ $designation->userauthority }}</option>

                                @empty

                                @endforelse
                            </select>
                            <div class="pl-5"><a href="javascript:;" class="btn btn-outline-secondary" data-tw-toggle="modal" data-tw-target="#modal_second_add_designation"><i data-lucide="plus" class="w-4 h-5"></i></a></div>
                        </div>
                    </div>

                    <div class="col-span-12 sm:col-span-12">
                        <label for="modal-form-2" class="form-label">Position</label>
                        <div class="input-group flex-1">
                            <select class="w-full" id="modal_position_id">
                                @forelse (load_position('') as $posistion)
                                    <option value="{{ $posistion->id }}">{{ $posistion->emp_position }}</option>

                                @empty

                                @endforelse
                            </select>
                            <div class="pl-5"><a href="javascript:;" class="btn btn-outline-secondary" data-tw-toggle="modal" data-tw-target="#modal_second_add_position"><i data-lucide="plus" class="w-4 h-5"></i></a></div>
                        </div>
                    </div>

                    <div class="col-span-12 sm:col-span-12">
                        <label for="modal-form-2" class="form-label">Office</label>
                        <div class="input-group flex-1">
                            <select class="w-full"id="modal_rc_id">
                                @forelse (load_responsibility_center('') as $rc)
                                    <option value="{{ $rc->responid }}">{{ $rc->centername }}</option>

                                @empty

                                @endforelse
                            </select>
                            <div class="pl-5"><a href="javascript:;" class="btn btn-outline-secondary" data-tw-toggle="modal" data-tw-target="#modal_second_add_respon"><i data-lucide="plus" class="w-4 h-5"></i></a></div>
                        </div>
                    </div>

                    <div class="col-span-12 sm:col-span-12">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Salary</label>
                        <input id="modal_salary" type="number" class="form-control" placeholder="Salary" value="0">
                        {{-- document.body.innerHTML = number.toLocaleString(); --}}
                    </div>

                    <div class="col-span-12 sm:col-span-12">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Status</label>
                        <select class="w-full"id="modal_employee_status">
                            @forelse (load_status_codes('') as $sc)

                            <option value="{{ $sc->code }}">{{ $sc->name }}</option>

                            @empty

                            @endforelse
                        </select>
                    </div>


                <!-- BEGIN: add_employment_type Modal Content -->
                 <div id="modal_second_add_employment_type" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header flex items-center justify-center">
                                <h2 class="font-medium text-base mr-auto">New Employment Type</h2>
                            </div>

                            <div class="modal-body ">
                                <div class="col-span-12 sm:col-span-6">
                                    <label for="modal-form-2" class="form-label">Name</label>
                                    <input id="modal_employment_type_name" type="text" class="form-control" placeholder="Name">
                                </div>
                                <div class="col-span-12 sm:col-span-12">
                                    <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Description</label>
                                    <textarea style="height: 100px" id="modal_employment_type_description" class="form-control" name="modal_employment_type_description" placeholder="Description" ></textarea>
                                </div>
                            </div>
                            <!-- BEGIN: Modal Footer -->
                            <div class="modal-footer">
                                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                                <button id="save_modal_add_employment_type" type="button" data-tw-dismiss="modal" class="btn btn-primary w-20">Save</button>
                            </div>
                            <!-- END: Modal Footer -->
                        </div>
                    </div>
                </div>
                <!-- END: add_designation Modal Content -->



                 <!-- BEGIN: add_designation Modal Content -->
                 <div id="modal_second_add_designation" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header flex items-center justify-center">
                                <h2 class="font-medium text-base mr-auto">New Designation</h2>
                            </div>

                            <div class="modal-body ">
                                <div class="col-span-12 sm:col-span-6">
                                    <label for="modal-form-2" class="form-label">Name</label>
                                    <input id="modal_desig_name" type="text" class="form-control" placeholder="Designation ">
                                </div>
                                <div class="col-span-12 sm:col-span-12">
                                    <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Description</label>
                                    <textarea style="height: 100px" id="modal_desig_description" class="form-control" name="modal_desig_description" placeholder="Description" ></textarea>
                                </div>
                            </div>
                            <!-- BEGIN: Modal Footer -->
                            <div class="modal-footer">
                                <button id="cancel_documents_btn" type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                                <button id="save_modal_add_designation" type="button" data-tw-dismiss="modal" class="btn btn-primary w-20">Save</button>
                            </div>
                            <!-- END: Modal Footer -->
                        </div>
                    </div>
                </div>
                <!-- END: add_designation Modal Content -->


                <!-- BEGIN: add_position Modal Content -->
                <div id="modal_second_add_position" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header flex items-center justify-center">
                                <h2 class="font-medium text-base mr-auto">New Position</h2>
                            </div>

                            <div class="modal-body ">
                                <div class="col-span-12 sm:col-span-6">
                                    <label for="modal-form-2" class="form-label">Name</label>
                                    <input id="modal_position_name" type="text" class="form-control" placeholder="Position ">
                                </div>
                                <div class="col-span-12 sm:col-span-12">
                                    <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Description</label>
                                    <textarea style="height: 100px" id="modal_position_description" class="form-control" name="modal_position_description" placeholder="Description" ></textarea>
                                </div>
                            </div>
                            <!-- BEGIN: Modal Footer -->
                            <div class="modal-footer">
                                <button id="cancel_documents_btn" type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                                <button id="save_modal_add_position" type="button" data-tw-dismiss="modal" class="btn btn-primary w-20">Save</button>
                            </div>
                            <!-- END: Modal Footer -->
                        </div>
                    </div>
                </div>
                <!-- END: add_position Modal Content -->


                <!-- BEGIN: add_respon Modal Content -->
                <div id="modal_second_add_respon" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header flex items-center justify-center">
                                <h2 class="font-medium text-base mr-auto">New Responsibility Center</h2>
                            </div>

                            <div class="modal-body ">
                                <div class="col-span-12 sm:col-span-6">
                                    <label for="modal-form-2" class="form-label">Name</label>
                                    <input id="modal_rc_name" type="text" class="form-control" placeholder="Responsibility Center ">
                                </div>
                                <div class="col-span-12 sm:col-span-12">
                                    <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Description</label>
                                    <textarea style="height: 100px" id="modal_rc_description" class="form-control" name="modal_rc_description" placeholder="Description" ></textarea>
                                </div>
                            </div>
                            <!-- BEGIN: Modal Footer -->
                            <div class="modal-footer">
                                <button id="cancel_documents_btn" type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                                <button id="save_modal_add_rc" type="button" data-tw-dismiss="modal" class="btn btn-primary w-20">Save</button>
                            </div>
                            <!-- END: Modal Footer -->
                        </div>
                    </div>
                </div>
                <!-- END: add_respon Modal Content -->

                </div>

                <!-- END: Modal Body -->

                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button id="cancel_documents_btn" type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                    {{-- <a href="javascript:;" id="load_employee_save" class="btn btn-primary w-20 load_employee_save">  </a> --}}
                    <button id="load_employee_save" class="btn btn-primary w-20 load_employee_save">Save</button>
                </div>
                <!-- END: Modal Footer -->
            </div>
        </form>
    </div>
</div>
<!-- END: Modal Content -->
