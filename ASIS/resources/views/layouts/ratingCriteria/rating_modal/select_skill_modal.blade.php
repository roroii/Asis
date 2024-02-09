 <!-- BEGIN: Modal Content -->
 <div id="select_skill_modal" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-bold text-base mr-auto">Select Competency Skill</h2>
                <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>
                    <div class="dropdown-menu w-40">
                        <ul class="dropdown-content">
                            <li> <a href="javascript:;" class="dropdown-item"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Add Area</a> </li>
                        </ul>
                    </div>
                </div>
            </div> <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body">

                    <input type="hidden" id="comp_id" name="comp_id">
                    <input type="hidden" id="skill_point" name="skill_point">
                    <div id="_skill_dropdown" class="mb-5">


                        <select id="_skills" name="position" class="select2 w-full">
                            <option></option>';
                            @foreach(get_competency_skill() as $compet_skill)
                            
                                <option value="{{ $compet_skill->skillid }}">{{ $compet_skill->skill }}</option>
                                
                            @endforeach
                        </select>
                    </div>


                        <!-- END: Modal Body -->

                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" id="btn_c_skill_select" href="javascript:;" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                        <button type="button" id="btn_skill_select" href="javascript:;" class="btn btn-primary w-20">Select</button>
                    </div>
                    <!-- END: Modal Footer -->
            </div>
        </div>
    </div>
</div>  <!-- END: Modal Content -->


