<!-- BEGIN: Modal Content -->
<div id="addCriteria_modal" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 id="addAndUpdate_header" class="font-bold text-base mr-auto">Add Criteria</h2>
                <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>
                    <div class="dropdown-menu w-40">
                        <ul class="dropdown-content">
                            <li> <a href="javascript:;" class="dropdown-item"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Download Docs </a> </li>
                        </ul>
                    </div>
                </div>
            </div> <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->



            <form id="addCriteriaForm" enctype="multipart/form-data">

                {{ csrf_field() }}
                <div class="modal-body">

                    <input id="critID" name="critID" type="hidden">
                    <div class="mb-5">
                        <div class="mt-2">
                            <label for="applicable_to"> Position </label>
                            <select id="positionss" name="positioning" class="select2 w-full">
                                <option></option>
                                @foreach (get_position() as $position)

                                <option value="{{ $position->id }}">{{ $position->emp_position }}</option>

                                @endforeach
                            </select>
                            <label for="positionLabel" id="positionLabel" class="text-danger" >Please Seletect Position</label>
                        </div>
                        {{-- <input id="applicable" type="text" name="applicable" class="form-control" placeholder="Applicable to"> --}}
                    </div>

                    <div class="flex mb-2 ">
                        <label for="criteria"> Rating Criteria </label> <label id="select_id" class="ml-auto text-primary underline decoration-dotted cursor-pointer selectClass"> Manual Type Criteria </label>
                    </div>

                     <div class="mb-5 competency_div">

                        <select id="competency" name="competensing" class="select2 w-full">
                            <option></option>
                            @foreach (get_competency_dictionary() as $competense)

                            <option value="{{ $competense->id }}">{{ $competense->name }}</option>

                            @endforeach
                        </select>
                        <label for="competencyLabel" id="competencyLabel" class="text-danger" >Please Select Competency</label>
                    </div>

                    <div class="mb-5 criteria_div" >

                        <input id="criteria" type="text" name="critersing" class="form-control" placeholder="Type Criteria">
                        <label for="criteriaLabel" id="criteriaLabel" class="text-danger" >Please Type Criteria</label>
                    </div>


                    <div class="mb-3">
                        <label for="maxrate"> Maximum Rate</label>
                        <input id="maxrate" type="text" value="" name="maxrating" class="form-control" placeholder="Maximum Rate">
                        <label id="rateLabel" for="maxrateLabel" class="text-danger">Rate field is required</label>
                    </div>

                    <div class="add_rowBtn_div mb-5">
                        <button id="add_row" type="button" href="javascript:;" class="btn btn-primary w-20"> <span class="mr-2"><i class="fa fa-plus-circle" aria-hidden="true"></i></span> Add</button>
                    </div>

                    <table id="crit_tbl" class="table table-report -mt-2">
                        <thead>
                            <th class="whitespace-nowrap">Position</th>
                            <th class="whitespace-nowrap">Criteria</th>
                            <th class="whitespace-nowrap">Max Rate</th>
                            <th class="whitespace-nowrap">Action</th>
                        </thead>

                        <tbody>

                        </tbody>
                    </table>

                </div>
                    <!-- END: Modal Body -->

                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button type="button" id="btn_cancel" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                    <button id="add_criteria_btn" type="submit" class="btn btn-primary w-20">Save</button>
                </div>
                <!-- END: Modal Footer -->
            </form>
        </div>
    </div>

</div>  <!-- END: Modal Content -->


