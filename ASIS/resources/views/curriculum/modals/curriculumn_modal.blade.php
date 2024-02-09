<!-- Add/Update Curriculum Modal -->
<div id="curriculum_modal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="alert alert-danger" style="display:none"></div>
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Add/Update Curriculum</h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <!-- Curriculum Name -->
                    <div class="col-span-12 sm:col-span-6">
                        <label for="curriculum_name">Curriculum Name</label>
                        <input type="text" id="curriculum_name" name="curriculum_name" class="form-control" placeholder="e.g. Curriculum for BSIT">
                        <input type="text" id="curriculum_id" name="curriculum_id" class="form-control hidden" placeholder="">
                    </div>
                    <!-- Degree Program -->
                    <div class="col-span-12 sm:col-span-6">
                        <label for="degree_program">Degree Program</label>
                        <select id="degree_program" class="form-select">
                            @foreach($deptcode as $fordept)
                                <option value="{{ $fordept }}">{{ $fordept }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Curriculum Effective Date -->
                    <div class="col-span-12 sm:col-span-6">
                        <label for="curriculum_schoolyear">Effective School Year</label>
                        <select  name="modal_sy" id="modal_sy" class="btn shadow-md form-control flex-1">
                            @forelse (load_esms_year('') as $i => $sy)
                                <option value="{{ $sy }}">{{ $sy }}</option>
                            @empty

                            @endforelse
                        </select>
                    </div>
                    <!-- Degree Program -->
                    <div class="col-span-12 sm:col-span-6">
                        <label for="college_program">For College</label>
                        <select id="college_program" class="form-select">
                            @foreach($collcode as $forcoll)
                                <option value="{{ $forcoll }}">{{ $forcoll }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Description -->
                    <div class="col-span-12">
                        <label for="curriculum_description">Description</label>
                        <textarea id="curriculum_description" name="curriculum_description" class="form-control" rows="4" required></textarea>
                    </div>

                    <!-- Curriculum Name -->
                    <div class="col-span-12 sm:col-span-6">
                        <label for="curriculum_name" class="form-label">Major</label>
                       <select  name="modal_major" id="modal_major" class="form-control">
                            @foreach($studmajor as $major)
                                <option value="{{ $major }}">{{ $major }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Degree Program -->
                    <div class="col-span-12 sm:col-span-6">
                            <label for="modal-form-2" class="form-label">Title</label>
                            <div class="input-group flex-1">
                                    <input type="text" id="curriculum_year-name" name="curriculum_year-name" class="form-control" placeholder="e.g. First Year">

                                <div class="pl-5">
                                    <a href="javascript:;" class="btn btn-outline-primary mr-2 -mt-0.5 before:content-[''] before:absolute before:w-4 before:h-4 before:bg-primary/20 before:rounded-full lg:before:animate-ping after:content-[''] after:absolute after:w-4 after:h-4  after:border-1 after:border-white/60 after:dark:border-darkmode-300" onclick="addYearTable()"><i data-lucide="plus" class="w-4 h-5"></i></a>
                                </div>
                            </div>
                    </div>

                    <div class="col-span-12 sm:col-span-12" id="modal-content">

                        <!-- Existing content or where the added tables will appear -->

                    </div>

                    <!-- BEGIN: Overlapping Modal Content -->
                    <div id="next-overlapping-modal-add-subject" class="modal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- BEGIN: Modal Header -->
                                <div class="modal-header">
                                    <h2 id="subject-modal-title" class="font-medium text-base mr-auto">Add Subject</h2>
                                    <div class="dropdown sm:hidden">
                                        <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown">
                                            <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i>
                                        </a>
                                        <div class="dropdown-menu w-40">
                                            <ul class="dropdown-content">
                                                <li>
                                                    <a href="javascript:;" class="dropdown-item">
                                                        <i data-lucide="file" class="w-4 h-4 mr-2"></i> Download Docs
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div> <!-- END: Modal Header -->
                                <!-- BEGIN: Modal Body -->
                                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                    <div class="col-span-12 sm:col-span-6">
                                        <label for="subject-modal-school-year" class="form-label">School Year</label>
                                        <select id="subject-modal-school-year" class="form-select">
                                            @foreach($uniqueSy as $sy)
                                                <option value="{{ $sy }}">{{ $sy }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-span-12 sm:col-span-6">
                                        <label for="subject-modal-semester" class="form-label">Sem</label>
                                        <select id="subject-modal-semester" class="form-select">
                                            @foreach($uniqueSem as $sem)
                                                <option value="{{ $sem }}">{{ $sem }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-span-12 sm:col-span-6">
                                        <label for="subject-modal-college" class a="form-label">College</label>
                                        <select id="subject-modal-college" class="form-select">
                                            @foreach($uniqueForcoll as $forcoll)
                                                <option value="{{ $forcoll }}">{{ $forcoll }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-span-12 sm:col-span-6">
                                        <label for="subject-modal-department" class="form-label">Department</label>
                                        <select id="subject-modal-department" class="form-select">
                                            @foreach($uniqueFordept as $fordept)
                                                <option value="{{ $fordept }}">{{ $fordept }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-span-12 sm:col-span-12">
                                        <table id="subject-modal-table" class="table w-full">
                                            <thead>
                                                <tr>
                                                    <th>Subject Code</th>
                                                    <th>Description</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div> <!-- END: Modal Body -->
                                <!-- BEGIN: Modal Footer -->
                                <div class="modal-footer">
                                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Close</button>
                                </div> <!-- END: Modal Footer -->
                            </div>
                        </div>
                    </div>
                    <!-- END: Overlapping Modal Content -->
                </div>
                <!-- END: Modal Body -->

                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                    <a href="javascript:;" id="save_curriculumn" data-tw-dismiss="modal" class="btn btn-primary w-20 btn-rgb-hover">Save</a>
                </div>
                <!-- END: Modal Footer -->
            </div>
    </div>
</div>
<!-- END: Modal Content -->
