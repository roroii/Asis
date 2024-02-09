 <!-- BEGIN: Modal Content -->
 <div id="testPart_modal" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-bold text-base mr-auto">Employment Testing</h2>
                <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>
                    <div class="dropdown-menu w-40">
                        <ul class="dropdown-content">
                            <li> <a href="javascript:;" class="dropdown-item"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Download Docs </a> </li>
                        </ul>
                    </div>
                </div>
            </div> <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
        <form id="hiring_form">
            @csrf
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-6"> <label for="modal-form-1" class="form-label font-medium">Position</label>
                    <div >
                        <select id="position" class="select2 w-full">
                            @forelse(get_position(' ') as $get_position)
                            <option></option>
                            <option value="{{ $get_position->id }}">{{ $get_position->emp_position }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-6"> <label for="modal-form-2" class="form-label font-medium">Salary Grade</label>
                    <div >
                        <select id="salary_grade" class="select2 w-full">
                          @forelse(get_salary_grade('') as $get_salarygrade)
                            <option></option>
                            <option value="{{ $get_salarygrade->id }}">{{ $get_salarygrade->salarygrade }}</option>
                            @empty
                          @endforelse
                        </select>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-6"> <label for="modal-form-3" class="form-label font-medium">Salary Rate</label>
                    <input id="salary_rate" type="number" class="form-control" placeholder="Enter Salary rate">
                </div>
                <div class="col-span-12 sm:col-span-6"> <label for="modal-form-1" class="form-label font-medium">Position type</label>
                    <div >
                        <select id="post_type" class="select2 w-full">
                            @forelse(get_position_type(' ') as $postype)
                            <option></option>
                            <option value="{{ $postype->id}}">{{ $postype->positiontype }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                </div>
                 <div class="col-span-12 sm:col-span-6"> <label for="modal-form-4" class="form-label font-medium">Entry Date</label>
                    <input id="entry_date" type="text" data-daterange="true" class="datepicker form-control">
                </div>
                <div class="col-span-12 sm:col-span-12"> <label for="modal-form-5" class="form-label font-medium">Description</label>
                    <textarea id="text_description" onchange="" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border" placeholder="Enter the description"></textarea>
                    <span id="text_count">1</span>/500
                </div>

            </div>
        </form>
                <!-- END: Modal Body -->

            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="submit" id="btn_cancel" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <button type="submit" id="btn_save" href="javascript:;" class="btn btn-primary w-20">Save</button>
            </div>
            <!-- END: Modal Footer -->
        </div>
    </div>
</div>  <!-- END: Modal Content -->
