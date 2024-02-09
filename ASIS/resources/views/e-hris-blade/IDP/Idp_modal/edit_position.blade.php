<div id="edit_jod_desc" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Edit job Description</h2>

            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-12"> <label for="modal-form-1" class="form-label  font-semibold">Position</label>
                    <div>
                        <select id="edit_pos" class="" style="width:100%">
                            @forelse(get_position(' ') as $get_position)
                                        <option></option>
                                        <option value="{{ $get_position->id}}">{{ Str::limit($get_position->emp_position,55)}}</option>
                                        @empty
                                        @endforelse
                        </select>
                    </div>
                 </div>
                <div class="col-span-12 sm:col-span-12"> <label for="modal-form-2" class="form-label font-semibold">Designation</label>
                    <div>
                        <select id="edit_desig" class="" style="width:100%">
                            @forelse(get_designation('') as $desig)
                            <option></option>
                            <option value="{{$desig->id}}">{{$desig->userauthority}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-12"> <label for="modal-form-3" class="form-label font-semibold">Unit Department</label>
                    <div>
                        <select id="edit_unit_department" class="" style="width:100%">
                            @forelse(payroll_Responsibility_Center('') as $office)
                            <option></option>
                            <option value="{{ $office->responid}}">{{$office->centername}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-12"> <label for="modal-form-4" class="form-label font-semibold">Dept.Head</label>
                    <div>
                        <select id="edit_department_head" class="" style="width:100%">
                            @forelse(get_competency('') as $skill)
                            <option></option>
                            <option value="{{ $skill->skillid}}">{{$skill->skill}}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                </div>
            </div> <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <button id="btn_save_edit_pos" type="button" class="btn btn-primary w-20">Send</button> </div> <!-- END: Modal Footer -->
        </div>
    </div>
</div> <!-- END: Modal Content -->
