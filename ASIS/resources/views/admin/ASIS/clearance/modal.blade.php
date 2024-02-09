
<!-- Add Documents Modal -->
<div id="clearance_settings" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form id="form_createDocs"  method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="alert alert-danger" style="display:none"></div>
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Clearance Settings (Admin)</h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-12">
                        <livewire:clearance-settings-powergrid />
                    </div>
                </div>
                <!-- END: Modal Body -->

                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button  type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Close</button>
                </div>
                <!-- END: Modal Footer -->
            </div>
        </form>
    </div>
</div>
<!-- END: Modal Content -->



<!-- Add SIGNATORIES Modal -->
<div id="clearance_signatories_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Clearance Settings (Admin)</h2>

                <div class="dropdown">
                    <button style="width: 180px" class="dropdown-toggle btn btn-outline-primary hidden sm:flex" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="users" class="w-4 h-4 mr-2"></i> Add Signatories </button>
                    <div class="dropdown-menu" style="width: 180px">
                        <ul class="dropdown-content">
                            <li> <a href="javascript:;" class="dropdown-item" data-tw-toggle="modal" data-tw-target="#student_list_mdl"> <i data-lucide="user" class="w-4 h-4 mr-2"></i> Student Affairs</a> </li>
                            <li> <a href="javascript:;" class="dropdown-item" data-tw-toggle="modal" data-tw-target="#faculty_list_mdl"> <i data-lucide="user" class="w-4 h-4 mr-2"></i> Academic Affairs</a> </li>
                            <li> <a href="javascript:;" class="dropdown-item mdl_btn_from_template" data-tw-toggle="modal" data-tw-target="#template_list_mdl"> <i data-lucide="clipboard" class="w-4 h-4 mr-2"></i> From Templates</a> </li>
                        </ul>
                    </div>
                </div>

            </div>
            <!-- END: Modal Header -->

            <div class="modal-body px-5 py-10">

                <div class="col-span-12 sm:col-span-12">

                    <div class="col-span-12 sm:col-span-3 hidden"> <label for="modal-form-1" class="form-label">Clearance ID</label>
                        <input disabled type="text" class="form-control mdl_input_clearance_id">
                    </div>

                    <div class="w-56 relative text-slate-500">
                        <input type="text" class="form-control w-56 box pr-10" id="filter-search_signatories" placeholder="Search...">
                        <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                    </div>


                    <div class="overflow-x-auto">
                        <table id="signatories_list_tbl" class="table table-report -mt-2">
                            <thead>
                            <tr>

                                <th class="whitespace-nowrap">#</th>
                                <th class="whitespace-nowrap">Name</th>
                                <th class="text-center whitespace-nowrap">Type</th>
                                <th class="whitespace-nowrap">Designation</th>
                                <th class="text-center whitespace-nowrap">Status</th>
                                <th class="text-center whitespace-nowrap">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>

                <!-- BEGIN: Pagination -->
                <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-2">
                    <nav class="w-full sm:w-auto sm:mr-auto">
                        <ul id="signatories_pagination" class="pagination">
                            <!-- Pagination links will be added here dynamically -->
                        </ul>
                    </nav>
                    <select id="filter-size_signatories" class="w-20 form-select box mt-3 sm:mt-0">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="35">35</option>
                        <option value="50">50</option>
                        <option value="999999">All</option>
                    </select>
                </div>
                <!-- END: Pagination -->



                <!-- BEGIN: Overlapping Modal Content -->

                <!-- BEGIN: STUDENT LIST MODAL -->
                    <div id="student_list_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="font-medium text-base mr-auto">Student's List</h2>
                            </div>

                            <div class="modal-body p-2">

                                <div class="col-span-12 sm:col-span-12">
                                    <div class="w-56 relative text-slate-500">
                                        <input type="text" class="form-control w-56 box pr-10" id="filter-search-students" placeholder="Search...">
                                        <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                                    </div>

                                    <div class="overflow-x-auto">
                                        <table id="student_list_tbl" class="table table-report -mt-2">
                                            <thead>
                                            <tr>
                                                <th class="whitespace-nowrap">Student ID</th>
                                                <th class="whitespace-nowrap">Name</th>
                                                <th class="whitespace-nowrap">Course</th>
                                                <th class="text-center whitespace-nowrap">STATUS</th>
                                                <th class="text-center whitespace-nowrap">ACTIONS</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <!-- BEGIN: Pagination -->
                                <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
                                    <nav class="w-full sm:w-auto sm:mr-auto">
                                        <ul id="students_pagination" class="pagination">
                                            <!-- Pagination links will be added here dynamically -->
                                        </ul>
                                    </nav>
                                    <select id="filter-size-students" class="w-20 form-select box mt-3 sm:mt-0">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="35">35</option>
                                        <option value="50">50</option>
                                        <option value="999999">All</option>
                                    </select>
                                </div>
                                <!-- END: Pagination -->

                            </div>

                            <!-- BEGIN: Modal Footer -->
                            <div class="modal-footer">
                                <button  type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1 btn_close_modal">Close</button>
                            </div>
                            <!-- END: Modal Footer -->
                        </div>
                    </div>
                </div>
                <!-- END: STUDENT LIST MODAL -->

                <!-- BEGIN: FACULTY LIST MODAL -->
                    <div id="faculty_list_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="font-medium text-base mr-auto">Employee List</h2>
                            </div>

                            <div class="modal-body p-2">
                                <div class="col-span-12 sm:col-span-12">
                                    <div class="w-56 relative text-slate-500">
                                        <input type="text" class="form-control w-56 box pr-10" id="filter-search-faculty" placeholder="Search...">
                                        <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                                    </div>

                                    <div class="overflow-x-auto">
                                        <table id="faculty_list_tbl" class="table table-report -mt-2">
                                            <thead>
                                            <tr>
                                                <th class="whitespace-nowrap">Employee ID</th>
                                                <th class="whitespace-nowrap">Name</th>
                                                <th class="text-center whitespace-nowrap">Status</th>
                                                <th class="text-center whitespace-nowrap">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- BEGIN: Pagination -->
                                <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
                                    <nav class="w-full sm:w-auto sm:mr-auto">
                                        <ul id="employee_pagination" class="pagination">
                                            <!-- Pagination links will be added here dynamically -->
                                        </ul>
                                    </nav>
                                    <select id="filter-size-faculty" class="w-20 form-select box mt-3 sm:mt-0">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="35">35</option>
                                        <option value="50">50</option>
                                        <option value="999999">All</option>
                                    </select>
                                </div>
                                <!-- END: Pagination -->
                            </div>

                            <!-- BEGIN: Modal Footer -->
                            <div class="modal-footer">
                                <button  type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1 btn_close_modal">Close</button>
                            </div>
                            <!-- END: Modal Footer -->
                        </div>
                    </div>
                </div>
                <!-- END: FACULTY LIST MODAL -->



                <!-- BEGIN: FROM TEMPLATE MODAL -->
                <div id="template_list_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="font-medium text-base mr-auto">Template List</h2>
                            </div>


                            <div class="modal-body p-2">
                                <div class="col-span-12 sm:col-span-12">

                                    <div class="col-span-12 sm:col-span-3"> <label for="modal-form-1" class="form-label">Created Clearance ID</label>
                                        <input disabled type="text" class="form-control template_mdl_clearance_id">
                                    </div>

                                    <div class="w-56 relative text-slate-500">
                                        <input type="text" class="form-control w-56 box pr-10" id="filter-search-templates" placeholder="Search...">
                                        <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                                    </div>

                                    <div class="overflow-x-auto">
                                        <table id="template_list_tbl" class="table table-report -mt-2">
                                            <thead>
                                            <tr>
                                                <th class="whitespace-nowrap">Name</th>
                                                <th class="text-center whitespace-nowrap">Type</th>
                                                <th class="whitespace-nowrap">Course</th>
                                                <th class="text-center whitespace-nowrap">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- BEGIN: Pagination -->
                                <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
                                    <nav class="w-full sm:w-auto sm:mr-auto">
                                        <ul id="template_pagination" class="pagination">
                                            <!-- Pagination links will be added here dynamically -->
                                        </ul>
                                    </nav>
                                    <select id="filter-size-template" class="w-20 form-select box mt-3 sm:mt-0">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="35">35</option>
                                        <option value="50">50</option>
                                        <option value="999999">All</option>
                                    </select>
                                </div>
                                <!-- END: Pagination -->
                            </div>

                            <!-- BEGIN: Modal Footer -->
                            <div class="modal-footer">
                                <button  type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1 btn_close_modal">Close</button>
                            </div>
                            <!-- END: Modal Footer -->
                        </div>
                    </div>
                </div>
                <!-- END: FROM TEMPLATE MODAL -->

                <!-- END: Overlapping Modal Content -->

            </div>

            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button  type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1 btn_close_signatory_modal">Close</button>
            </div>
            <!-- END: Modal Footer -->
        </div>
    </div>
</div>
<!-- END: SIGNATORIES Content -->


<!-- BEGIN::    CREATE STUDENT CLEARANCE Modal -->
<div id="create_clearance_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto label_clearance_modal">Create Clearance</h2>

                <div class="dropdown">
                    <button style="width: 180px" class="dropdown-toggle btn btn-outline-primary hidden sm:flex mdl_btn_edit_signatories" aria-expanded="false"
                        > <i data-lucide="users" class="w-4 h-4 mr-2"></i>
                        Edit Signatories
                    </button>
                </div>
            </div>

            <!-- END: Modal Header -->

            <!-- BEGIN: Modal Body -->
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                <div class="col-span-12 sm:col-span-3 hidden"> <label for="modal-form-1" class="form-label">Clearance ID</label>
                    <input disabled type="text" class="form-control input_clearance_id_mdl">
                </div>

                <div class="col-span-12 sm:col-span-12">
                    <div class="input-form">
                        <label for="modal-form-1" class="form-label w-full flex flex-col sm:flex-row">Clearance Name: <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-danger">Required *</span> </label>
                        <input id="clearance_name" type="text" class="form-control clearance_name" placeholder="Clearance Name....">
                    </div>
               </div>

                <div class="col-span-12 sm:col-span-6"> <label for="modal-form-6" class="form-label">Clearance Type:</label>
                    <select id="clearance_type" class="form-select">
                        <option value="NON_GRADUATING">NON GRADUATING</option>
                        <option value="GRADUATING">GRADUATING</option>
                    </select>
                </div>



                <div class="col-span-12 sm:col-span-6">
                    <div class="input-form">
                        <label for="modal-form-6" class="form-label w-full flex flex-col sm:flex-row">Clearance for: <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-danger">Required *</span> </label>
                        <select id="clearance_program" class="form-select flex-1"  multiple="multiple">


                            @foreach(load_enroll_list_program() as $program)
                                <option value="{{ $program }}">{{ $program }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-span-12 sm:col-span-6"> <label for="modal-form-1" class="form-label"> School Year:</label>
                    <input disabled id="clearance_schoolYear" value="{{ $school_year->key_value  }}" type="text" class="form-control clearance_schoolYear">
                </div>
                <div class="col-span-12 sm:col-span-6"> <label for="modal-form-1" class="form-label"> School Semester:</label>
                    <input disabled id="clearance_schoolSem" value="{{ $school_sem->key_value  }}" type="text" class="form-control clearance_schoolSem">
                </div>

            </div>
            <!-- END: Modal Body -->

            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button  type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Close</button>
                <button class="btn btn-primary mr-1 mb-2 btn_save_clearance"> Save </button>

            </div>
            <!-- END: Modal Footer -->

        </div>
    </div>
</div>
<!-- END::    CREATE STUDENT CLEARANCE Modal -->







<!-- BEGIN::    VIEW MORE SIGNATORIES Modal -->
<div id="view_more_signatory_mdl" data-tw-backdrop="static" class="modal modal_z_index_edited" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto label_clearance_modal">For Signatory List</h2>

            </div>
            <!-- END: Modal Header -->

            <div class="modal-body p-4">

                <div class="col-span-12 sm:col-span-12">
                    <div class="w-56 relative text-slate-500">
                        <input type="text" class="form-control w-56 box pr-10" id="filter-search-students-clearance" placeholder="Search...">
                        <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                    </div>

                    <div class="intro-y inbox box mt-5">
                        <div id="my_signatories_list_tbl" class="overflow-x-auto sm:overflow-x-visible">

                        </div>
                    </div>
                </div>


                <!-- BEGIN: Pagination -->
                <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
                    <nav class="w-full sm:w-auto sm:mr-auto">
                        <ul id="signatory_list_pagination" class="signatory_list_pagination pagination">
                            <!-- Pagination links will be added here dynamically -->
                        </ul>
                    </nav>
                    <select id="filter-size-signatory-list" class="w-20 form-select box mt-3 sm:mt-0">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="35">35</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <!-- END: Pagination -->

            </div>



            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button  type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Close</button>
            </div>
            <!-- END: Modal Footer -->

        </div>
    </div>
</div>
<!-- END::    VIEW MORE SIGNATORIES Modal -->




<!-- BEGIN::    VIEW MY CLEARANCE SIGNED MODAL -->
<div id="view_my_clearance_signed_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto label_clearance_modal">List of Signed</h2>

            </div>
            <!-- END: Modal Header -->

            <div class="modal-body p-5">

                <div class="col-span-12 sm:col-span-12">
                    <div class="overflow-x-auto">

                        <table id="my_clearance_signed_list_tbl" class="table table-report -mt-2">
                            <thead>
                            <tr>
                                <th class="whitespace-nowrap">Name / Designation</th>
                                <th class="whitespace-nowrap">STATUS</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>



            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button  type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Close</button>
            </div>
            <!-- END: Modal Footer -->

        </div>
    </div>
</div>
<!-- END::    VIEW MY CLEARANCE SIGNED MODAL -->




<!-- BEGIN::    CREATE IMPORTANT NOTES  MODAL -->
<div id="create_important_notes_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto label_clearance_modal">Create Important Notes</h2>

            </div>
            <!-- END: Modal Header -->

            <div class="modal-body p-5">


                <div class="col-span-12 sm:col-span-12">

                    <div class="col-span-12 sm:col-span-6">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row font-medium"> Toggle On if Note is for all Program <div class="sm:ml-auto mt-1 sm:mt-0 form-check form-switch"><input class="form-check-input btn_switch_note_for_all" type="checkbox"></div> </label>
                    </div>

                    <div class="col-span-12 sm:col-span-6 note_for_program_div">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Note for: </label>

                        <select id="note_for_program" class="form-select flex-1"  multiple="multiple">
                            @forelse (load_enroll_list_program() as $program)
                                <option value="{{ $program }}">{{ $program }}</option>
                            @empty
                                <option>No Data</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="col-span-12 sm:col-span-6  mt-3"> <label for="modal-form-6" class="form-label">Title:</label>
                        <input id="admin_note_title" type="text" name="name" class="form-control" placeholder="Title..." minlength="2" required>

                    </div>

                    <div class="input-form mt-3">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Note <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 10 characters</span> </label>
                        <textarea id="admin_notes" class="form-control" name="comment" style="height: 8rem" placeholder="Type your note..." minlength="10" required></textarea>
                    </div>
                </div>
            </div>



            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button  type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Close</button>
                <button class="btn btn-primary mr-1 mb-2 btn_mdl_save_notes"> Save </button>
            </div>
            <!-- END: Modal Footer -->

        </div>
    </div>
</div>
<!-- END::    CREATE IMPORTANT NOTES MODAL -->
