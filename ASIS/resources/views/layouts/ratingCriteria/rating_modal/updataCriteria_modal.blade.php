 <!-- BEGIN: Modal Content -->
 <div id="update_criteria_Modal" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-bold text-base mr-auto">Update Criteria</h2>
                <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>
                    <div class="dropdown-menu w-40">
                        <ul class="dropdown-content">
                            <li> <a href="javascript:;" class="dropdown-item"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Add Area</a> </li>
                        </ul>
                    </div>
                </div>
            </div> <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body p-10">
                <form id="updateCriteria_form" enctype="multipart/form-data">
                    @csrf
                    
                    <input id="critID_up" name="critID" type="hidden">
                    <div class="mb-5">
                        <div class="mt-2">
                            <label for="position_up"> Position </label>
                            <select id="position_up" name="positioning" class="select2 w-full">
                                <option></option>
                                @foreach (get_position() as $position)

                                <option value="{{ $position->id }}">{{ $position->emp_position }}</option>

                                @endforeach
                            </select>
                           
                        </div>
                        {{-- <input id="applicable" type="text" name="applicable" class="form-control" placeholder="Applicable to"> --}}
                    </div>

                    <div class="flex mb-2 ">
                        <label for="criteria"> Rating Criteria </label> <span class="ml-auto"><a id="select_id" class="text-primary underline decoration-dotted cursor-pointer selectClass">Manually Type Criteria</a></span>
                    </div>

                     <div class="mb-5 competency_div">

                        <select id="competency_up" name="competensing" class="select2 w-full">
                            <option></option>
                            @foreach (get_competency_dictionary() as $competense)

                            <option value="{{ $competense->id }}">{{ $competense->name }}</option>

                            @endforeach
                        </select>
                       
                    </div>

                    <div class="mb-5 criteria_div" >
                        <input id="criteria_up" type="text" name="critersing" class="form-control" placeholder="Type Criteria">
                    </div>


                    <div class="mb-3">
                        <label for="maxrate"> Maximum Rate</label>
                        <input id="maxrate_up" type="text" value="" name="maxrating" class="form-control" placeholder="Maximum Rate">
                      
                    </div>
                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer">
                        <button id="_modal" type="button" href="javascript:;" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                        <button id="UpdateCriteria_btn" type="submit" href="javascript:;" class="btn btn-primary w-20">Update</button>
                    </div>
                    <!-- END: Modal Footer -->
                </form>
            </div>
        </div>
    </div>
</div>  <!-- END: Modal Content -->


