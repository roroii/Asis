<div id="add_educ_bg_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Add Educational Background</h2>
            </div>

            <div class="modal-body p-0">

                <div class="p-5 grid grid-cols-12 gap-6">

                    <input id="academic_id" class="hidden">
                    <input id="acad_level" class="hidden">

                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Level  </label>
                        <select class="select2 w-full" id="educ_bg_level">
                            <option value="ELEMENTARY">Elementary</option>
                            <option value="SECONDARY">Secondary</option>
                            <option value="VOCATIONAL TRADE COURSE">Vocational/Trade Course</option>
                            <option value="COLLEGE">College</option>
                            <option value="GRADUATE STUDIES">Graduate Studies</option>
                        </select>
                    </div>

                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> School Name <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">(Write in full)</span> </label>
                        <input id="educ_school_name" style="text-transform:uppercase"  type="text" name="educ_school_name" class="form-control" placeholder="School Name" minlength="2" required autocomplete="off">
                    </div>
                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> From <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">(Period of attendance)</span> </label>

                        <div class="relative w-auto mx-auto">
                            <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                                <i data-lucide="calendar" class="w-4 h-4"></i>
                            </div> <input id="educ_school_from" type="text" class="form-control pl-12 ">
                        </div>

                    </div>

                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> To <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">(Period of attendance)</span> </label>

                        <div class="relative w-auto mx-auto">
                            <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                                <i data-lucide="calendar" class="w-4 h-4"></i>
                            </div> <input id="educ_school_to" type="text" class="form-control pl-12 ">
                        </div>

                    </div>
                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Basic Education/Degree/Course <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">(Write in full)</span> </label>
                        <input id="educ_degree_course" style="text-transform:uppercase"  type="text" name="educ_degree_course" class="form-control" placeholder="Basic Education/Degree/Course" minlength="2" required autocomplete="off">
                    </div>
                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Highest Level/Units Earned <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">(If not graduated)</span> </label>
                        <input id="educ_highest_level_earned" style="text-transform:uppercase"  type="text" name="educ_highest_level_earned" class="form-control" placeholder="Highest Level/Units Earned" minlength="2" required autocomplete="off">
                    </div>
                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Year Graduated </label>


                        <input id="educ_year_graduated" style="text-transform:uppercase"  type="text" name="educ_year_graduated" class="form-control" placeholder="Year Graduated" minlength="2" required autocomplete="off">

                        {{-- <div class="relative w-auto mx-auto">
                            <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                                <i data-lucide="calendar" class="w-4 h-4"></i>
                            </div> <input id="educ_year_graduated" type="text" class="form-control pl-12 ">
                        </div> --}}


                    </div>
                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Scholarship/Academic Honors Received </label>
                        <input id="educ_scholarship" style="text-transform:uppercase"  type="text" name="educ_scholarship" class="form-control" placeholder="Scholarship/Academic Honors Received" minlength="2" required autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <button id="add_educ_bg" type="submit" class="btn btn-primary w-20">Add</button>
                <button id="update_educ_bg" type="submit" class="btn btn-primary w-20">Update</button>
            </div>
        </div>
    </div>
</div>


<div id="delete_educ_bg_mdl" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">

                <input id="mdl_academic_input_id" class="hidden">

                <div class="p-5 text-center"> <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                    <div class="text-3xl mt-5">Are you sure?</div>
                    <div class="text-slate-500 mt-2">Do you really want to delete this data? <br>This process cannot be undone.</div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                    <button id="btn_delete_my_educ_bg" type="button" class="btn btn-danger w-24">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
