<!-- BEGIN: Modal Content -->
<div id="btn_set_sem_sched" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Create Schedule</h2>
            </div> <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-6"> <label for="modal-form-1" class="form-label font-semibold">Semester</label>
                    <select id="sem"  style="width:100%">
                        @forelse ($sem as $sems)
                                <option></option>
                                <option value={{ $sems->oid }}>{{ $sems->semdesc }}</option>
                        @empty
                            No data
                        @endforelse
                    </select>
                </div>
                <div class="col-span-12 sm:col-span-6"> <label for="modal-form-2" class="form-label font-semibold">School-year</label>
                    <select id="sc-y"  style="width:100%">
                        <option></option>
                        <option value=""></option>
                    </select>
                </div>
                <div class="col-span-12 sm:col-span-6"> <label for="modal-form-3" class="form-label font-semibold">Date Open</label>
                    <div class="relative  mx-auto">
                        <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                        </div>
                        <input type="text" class="datepicker form-control pl-12" data-single-mode="true">
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-6"> <label for="modal-form-4" class="form-label font-semibold">Date Close</label>
                    <div class="relative  mx-auto">
                        <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                        </div>
                        <input type="text" class="datepicker form-control pl-12" data-single-mode="true">
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-12"> <label for="modal-form-5" class="form-label font-semibold">Department</label>
                    <div>
                        <select id="department_name"  style="width:100%">
                                @forelse ($department as $dept  )
                                        <option></option>
                                        <option value={{ $dept->deptcode }}> {{ $dept->deptname }}</option>
                                @empty
                                No data found
                                @endforelse
                        </select>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-12"> <label for="modal-form-5" class="form-label font-semibold">Program</label>
                    <div>
                        <select id="program_desc"  style="width:100%" class="select2-multiple" multiple="multiple">
                        </select>
                    </div>
                </div>
                <div id="faq-accordion-2" class="accordion accordion-boxed col-span-12 sm:col-span-12 mt-2">
                    <div class="accordion-item">
                        <div id="faq-accordion-content-5" class="accordion-header"> <button class="accordion-button" type="button" data-tw-toggle="collapse" data-tw-target="#faq-accordion-collapse-5" aria-expanded="true" aria-controls="faq-accordion-collapse-5"> List of open program </button> </div>
                        <div id="faq-accordion-collapse-5" class="accordion-collapse collapse show" aria-labelledby="faq-accordion-content-5" data-tw-parent="#faq-accordion-2">
                            <div class="accordion-body text-slate-600 dark:text-slate-500 leading-relaxed"> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. </div>
                        </div>
                    </div>
                </div>
            </div> <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <button type="button" class="btn btn-primary w-20">Saved</button>
            </div> <!-- END: Modal Footer -->
        </div>
    </div>
</div> <!-- END: Modal Content -->
