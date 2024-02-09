<!-- Add Documents Modal -->
<div id="report_list_modal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="form_createDocs" method="GET" action="{{ url('student-enroll/enrollment-print-list') }}" target="_blank">
            @csrf
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="alert alert-danger" style="display:none"></div>
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Export</h2>
                    <button id="downloadExcelBtn" class="btn btn-outline-secondary hidden sm:flex"
                            onclick="downloadExcel('{{ route('exportEnrollmentList') }}',
                                                    document.getElementById('filter_year').value,
                                                    document.getElementById('filter_sem').value,
                                                    document.getElementById('filter_year_level').value,
                                                    document.getElementById('filter_program').value,
                                                    document.getElementById('filter_status').value)">
                        <i data-lucide="file" class="w-4 h-4 mr-2"></i>Excel
                    </button>
                </div>
                <!-- END: Modal Header -->
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-6">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Year</label>
                        <select name="filter_year" id="filter_year" class="btn shadow-md mr-2 w-full">
                            <option value="">All</option>
                            @forelse (load_enroll_list_school_year() as $school_year)
                                <option value="{{ $school_year }}">{{ $school_year }}</option>
                            @empty

                            @endforelse
                        </select>
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Sem</label>
                        <select name="filter_sem" id="filter_sem" class="btn shadow-md mr-2 w-full">
                            <option value="">All</option>
                            @forelse (load_enroll_list_school_sem() as $school_sem)
                                <option value="{{ $school_sem }}">{{ $school_sem }}</option>
                            @empty

                            @endforelse
                        </select>
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Year Level</label>
                        <select name="filter_year_level" id="filter_year_level" class="btn shadow-md mr-2 w-full">
                            <option value="">All</option>
                            @forelse (load_enroll_list_year_level() as $yearlevel)
                                <option value="{{ $yearlevel }}">{{ $yearlevel }}</option>
                            @empty

                            @endforelse
                        </select>
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Course/Program</label>
                        <select name="filter_program" id="filter_program" class="btn shadow-md mr-2 w-full">
                            <option value="">All</option>
                            @forelse (load_enroll_list_program() as $program)
                                <option value="{{ $program }}">{{ $program }}</option>
                            @empty

                            @endforelse
                        </select>
                    </div>

                    <div class="col-span-12 sm:col-span-12">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Status</label>
                        <select name="filter_status" id="filter_status" class="btn shadow-md mr-2 w-full">
                            <option value="">All</option>
                            <option value="0">Pending</option>
                            <option value="1">Approved</option>
                        </select>
                    </div>
                </div>
                <!-- END: Modal Body -->

                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                    <button type="submit" class="btn btn-primary w-20">Print</button>
                </div>
                <!-- END: Modal Footer -->
            </div>
        </form>
    </div>
</div>
<!-- END: Modal Content -->
