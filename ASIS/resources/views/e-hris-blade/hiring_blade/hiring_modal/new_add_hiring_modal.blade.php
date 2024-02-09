 <!-- BEGIN: Modal Content -->
 <div id="new_hiring_modal" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-bold text-base mr-auto">Application Hiring</h2>
                <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>
                    <div class="dropdown-menu w-40">
                        <ul class="dropdown-content">
                            <li> <a href="javascript:;" class="dropdown-item"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Download Docs </a> </li>
                        </ul>
                    </div>
                </div>
            </div> <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
        <form id="pisition_form">
            @csrf
            <div class="intro-y box p-5">
                <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                    <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5"> <i data-lucide="chevron-down" class="w-4 h-4 mr-2"></i> Job information </div>
                        <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                            <div class="col-span-12 sm:col-span-6"> <label for="modal-form-3" class="form-label font-medium" >Placement of Assignment</label>
                                <input id="assign" type="text" class="form-control" placeholder="Enter place of Assignment" maxlength = "100" >
                            </div>
                            <div class="col-span-12 sm:col-span-6"> <label for="modal-form-1" class="form-label font-medium">Position Title</label>
                                <div >
                                    <select id="position_title"  style="width:100%">
                                        @forelse(get_position(' ') as $get_position)
                                        <option></option>
                                        <option value="{{ $get_position->id}}">{{ Str::limit($get_position->emp_position,55)}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6"> <label for="modal-form-2" class="form-label font-medium">Plantilla No:</label>
                                {{-- <div >
                                    <select id="salarygrade" class="select2 w-full">
                                      @forelse(get_salary_grade('') as $get_salarygrade)
                                        <option></option>
                                        <option value="{{ $get_salarygrade->id }}">{{ $get_salarygrade->salarygrade }}</option>
                                        @empty
                                      @endforelse
                                    </select>
                                </div> --}}
                                <input id="item_no" type="text" class="form-control" placeholder="Enter Plantilla no#:" required>
                            </div>
                            <div class="col-span-12 sm:col-span-6"> <label for="modal-form-3" class="form-label font-medium">Eligibility:</label>
                                <input id="eligibility" type="text" class="form-control" placeholder="Enter eligibility:">
                            </div>
                            <div class="col-span-12 sm:col-span-6"> <label for="modal-form-3" class="form-label font-medium">Education:</label>
                                <input id="education" type="text" class="form-control" placeholder="Education">
                            </div>
                            <div class="col-span-12 sm:col-span-6"> <label for="modal-form-3" class="form-label font-medium">Training</label>
                                <input id="training" type="text" class="form-control" placeholder="Training">
                            </div>
                            <div class="col-span-12 sm:col-span-12"> <label for="modal-form-2" class="form-label font-medium">Salary info</label>
                                <div id="faq-accordion-3" class="accordion accordion-boxed">
                                    <div class="accordion-item">
                                        <div id="faq-accordion-content-5" class="accordion-header"> <button class="accordion-button" type="button" data-tw-toggle="collapse" data-tw-target="#faq-accordion-collapse-5" aria-expanded="true" aria-controls="faq-accordion-collapse-5"> <span class="mr-2"><i class="fa fa-coins text-warning"></i></span>Click for salary info</button> </div>
                                        <div id="faq-accordion-collapse-5" class="accordion-collapse collapse show" aria-labelledby="faq-accordion-content-5" data-tw-parent="#faq-accordion-2">
                                            <div class="mt-2">
                                                <label class="font-medium ">SG</label>
                                                <select id="salarygrade" style="width:100%">
                                                    @forelse(get_salary_grade('') as $get_salarygrade)
                                                      <option></option>
                                                      <option value="{{ $get_salarygrade->id }}">{{ $get_salarygrade->name }}</option>
                                                      @empty
                                                    @endforelse
                                                  </select>
                                            </div>
                                            <div class=" relative w-70 mx-auto mt-2">
                                                <label class="font-medium ">Step</label>
                                                <select id="step" style="width:100%">
                                                    @forelse(get_step_salary('') as $step)
                                                      <option></option>
                                                      <option value="{{ $step->stepnum }}">{{ $step->stepname}}</option>
                                                      @empty
                                                    @endforelse
                                                </select>
                                            </div>
                                            {{-- <div class="mt-2">
                                                <div> <label for="modal-form-1" class="form-label font-medium">Tranche</label>
                                                    <div >
                                                        <select id="tranche" class="select2 w-full">
                                                            @forelse(get_salary_grade(' ') as $get_salarygrade)
                                                              <option></option>
                                                              <option value="{{ $get_salarygrade->id }}">{{ $get_salarygrade->salarygrade }}</option>
                                                              @empty
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                </div>
                                            </div> --}}
                                            <div class="mt-2">
                                                <div> <label for="modal-form-1" class="form-label font-medium">Monthly Salary</label>
                                                    <div >
                                                        <input id="monthly_salary" type="number" class="form-control" placeholder="Monthly Salary">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                            </div>
                            {{-- <div class="col-span-12 sm:col-span-6"> <label for="modal-form-3" class="form-label font-medium">Training:</label>
                                <input id="training" type="text" class="form-control" placeholder="Training">
                            </div> --}}
                            <div class="col-span-12 sm:col-span-6"> <label for="modal-form-3" class="form-label font-medium">Work Experience:</label>
                                <input id="work_ex" type="text" class="form-control" placeholder="Work related" required>
                            </div>
                            <div class="col-span-12 sm:col-span-6"> <label for="modal-form-1" class="form-label font-medium">Position type</label>
                                <div >
                                    <select id="position_type" class="select2 w-full" required>
                                        @forelse(get_position_type(' ') as $postype)
                                        <option></option>
                                        <option value="{{ $postype->id}}">{{ $postype->positiontype }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6"> <label for="modal-form-1" class="form-label font-medium">Panels</label>
                                <div >
                                    <select id="ratees" class="select2-multiple w-full" multiple="multiple" required>
                                        @forelse(get_employee() as $panel)
                                        <option></option>
                                        <option value="{{ $panel->agencyid}}">{{ $panel->lastname }} {{ $panel->firstname }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6"> <label for="modal-form-4" class="form-label font-medium">Entry Date</label>
                                <input id="date_entry" type="text" data-daterange="true" class="datepicker form-control" required>
                            </div>

                            {{-- <div class="col-span-12 sm:col-span-12"> <label for="modal-form-1" class="form-label font-medium">Competencies</label>
                                <div >
                                    <select id="competency" class="w-full">
                                        @forelse(get_competency('') as $skill)
                                        <option></option>
                                        <option value="{{ $skill->skillid}}">{{Str::limit($skill->skill,120,'....')}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-12"> <label for="modal-form-5" class="form-label font-medium">Competency Details:</label>
                                <textarea id="competency_details" onchange="" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border" placeholder="" disabled></textarea>
                                <span id="text_competency"></span>
                            </div> --}}

                            <div class="col-span-12 sm:col-span-12 mt-2"> <label for="modal-form-2" class="form-label font-medium">Create a competencies</label>
                                <div id="faq-accordion-3_competencies" class="accordion accordion-boxed">
                                    <div class="accordion-item">
                                        <div id="faq-accordion-content-5" class="accordion-header"> <button class="accordion-button" type="button" data-tw-toggle="collapse" data-tw-target="#faq-accordion-collapse-5" aria-expanded="true" aria-controls="faq-accordion-collapse-5"> <span class="mr-2"><i class="fa fa-user-tie "></i></span>Click for competencies info</button> </div>
                                        <div id="faq-accordion-collapse-5" class="accordion-collapse collapse show" aria-labelledby="faq-accordion-content-5" data-tw-parent="#faq-accordion-2">
                                            <div class="mt-2">
                                                <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                                                    <div class="w-full mt-3 xl:mt-0 flex-1">
                                                        <div class="form-check form-switch">
                                                            <input id="change_input_competencies" class="form-check-input biafc_has_business_interest" type="checkbox">
                                                            <label class="form-check-label leading-relaxed text-slate-500 text-xs" for="preorder-active">Change to input new competencies </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div> <label for="modal-form-1" class="form-label font-medium mt-3">Select Competencies</label>
                                                    <div class="mt-2">
                                                        <input id="competency_input" type="text" class="form-control" placeholder="Enter competency" hidden>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-span-12 sm:col-span-12">
                                                <div>
                                                    <select id="competency" class="" style="width:100%">
                                                        @forelse(get_competency('') as $skill)
                                                        <option></option>
                                                        <option value="{{ $skill->skillid}}">{{$skill->skill}}</option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="overflow-x-auto mt-4 div_style">
                                                <table  id="competencies_tb" class="table mt-2">
                                                    <thead class="">
                                                        <tr>
                                                            <th class="whitespace-nowrap" >List of Competencies</th>
                                                            <th class="whitespace-nowrap text-center" >Action</th>
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

                        </div>
                </div>
            </div>

            <div class="intro-y box p-5">
                <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                    <div class="font-medium text-base flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5"> <i data-lucide="chevron-down" class="w-4 h-4 mr-2"></i> Instructions Remarks/Documents </div>
                    <div class="mt-5">
                        <div class="col-span-12 sm:col-span-12"> <label for="modal-form-5" class="form-label font-medium">Instructions/Remarks:</label>
                            <textarea id="remarks" onchange="" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border" placeholder="Enter instruction/remarks" required></textarea>
                            <span id="text_remark">1</span>/1000
                        </div>
                    </div>
                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                        <div class="font-medium text-base mr-auto">
                            Documents Requirements:
                        </div>
                        <a href="javascript:;" id="add_document_requirements" class="ml-auto text-primary truncate flex items-center add_document_requirements"> <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Add </a>
                    </div>

                    <div style="border-radius: 0.40rem; border-width: 1px;border-color: rgb(var(--color-slate-200) / 0.6);">
                        <table id="dt_job_documents" class="table form-control">
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    {{-- <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <div class="col-span-12 sm:col-span-6 mt-1"> <label for="modal-form-2" class="form-label font-medium">Email Address</label>
                            <input type="email" id="email_address" class="form-control" placeholder="Email Address"  maxlength = "50" required>
                        </div>
                        <div class="col-span-12 sm:col-span-6 mt-1"> <label for="modal-form-2" class="form-label font-medium">Address</label>
                            <input id="address" type="text" class="form-control" placeholder="Address"  maxlength = "200" required>
                        </div>
                        <div class="col-span-12 sm:col-span-12"> <label for="modal-form-1" class="form-label font-medium">Assign HRMO</label>
                            <div >
                                <select id="hrmo_head" class="w-full">
                                    @forelse(get_employee() as $panel)
                                    <option></option>
                                    <option value="{{ $panel->user_id}}">{{ $panel->lastname }} {{ $panel->firstname }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    </div> --}}
                    <div id="faq-accordion-4" class="accordion accordion-boxed mt-4">
                        <div class="accordion-item">
                            <div id="faq-accordion-content-5" class="accordion-header"> <button class="accordion-button" type="button" data-tw-toggle="collapse" data-tw-target="#faq-accordion-collapse-5" aria-expanded="true" aria-controls="faq-accordion-collapse-5"><span class="mr-2"><i class="fa fa-address-card text-dark"></i></span>Contact Info</button> </div>
                            <div id="faq-accordion-collapse-5" class="accordion-collapse collapse show" aria-labelledby="faq-accordion-content-5" data-tw-parent="#faq-accordion-2">
                                        <div class=""> <label for="modal-form-2" class="form-label font-medium">Email Address</label>
                                            <input type="email" id="email_address" class="form-control" placeholder="Email Address"  maxlength = "100" required>
                                        </div>
                                        <div class="mt-2"> <label for="modal-form-2" class="form-label font-medium">Address</label>
                                            <input id="address" type="text" class="form-control" placeholder="Address"  maxlength = "200" required>
                                        </div>
                                        <div class="mt-2"> <label for="modal-form-1" class="form-label font-medium">Assign HRMO</label>
                                                <select id="hrmo_head" style="width:100%">
                                                    @forelse(get_employee() as $panel)
                                                    <option></option>
                                                    <option value="{{ $panel->agencyid}}">{{ $panel->lastname }} {{ $panel->firstname }}</option>
                                                    @empty
                                                    @endforelse
                                                </select>
                                        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
                <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="submit" id="btn_cancel_position" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <button type="submit" id="btn_save_position" href="javascript:;" class="btn btn-primary w-20">Save</button>
            </div>
            <!-- END: Modal Footer -->
        </div>
    </div>
</div>  <!-- END: Modal Content -->
