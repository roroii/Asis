<!-- BEGIN: Super Large Modal Content -->
<div id="addTarget_modal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <a id="cancel_develop_target" data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x" class="w-8 h-8 text-slate-500"></i> </a>
            <!-- BEGIN: Modal Header -->
            <div class="alert alert-danger" style="display:none"></div>

            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">COMPETENCY ASSESSMENT AND DEVELOPMENT PRIORITIES </h2>
            </div>
            <!-- END: Modal Header -->

            <!-- BEGIN: Modal Body -->
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                <div class="col-span-12 sm:col-span-12">
                    <div class="intro-y">

                        <form id="addTarget_form" enctype="multipart/form-data">
                            @csrf
                            <!--1-->
                            <div id="div_target_textarea" class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5 mb-5">
                                
                                <input type="hidden" id="ridp_id" name="ridp_id">
                                <div class="input-form">
                                    <h2 id="exclusive_year" class="block font-medium text-base mb-5">
                                        Development Target  <span id="from_year_label"></span><span id="to_year_label"></span>
                                    </h2> 
                                        <div class="grid grid-cols-12 gap-4 gap-y-3">
                                            

                                            <div class="input-form col-span-12 lg:col-span-12">

                                                <textarea id="rdev_target" name="rdev_target" rows="2" class="form-control" placeholder="....."></textarea>
                                            </div>
                                            
                                        </div>
                                    
                                </div>

                                <div class="input-form">
                                    <h2 id="exclusive_year" class="block font-medium text-base mt-5 mb-5">
                                        Performance Goal this Supports  <span id="from_year_label"></span><span id="to_year_label"></span>
                                    </h2> 
                                        <div class="grid grid-cols-12 gap-4 gap-y-3">
                                            

                                            <div class="input-form col-span-12 lg:col-span-12">
                                                
                                                <textarea id="rdev_goal" name="rdev_goal" rows="2" class="form-control" placeholder="....."></textarea>
                                            </div>
                                            
                                        </div>
                                    
                                </div>
                                <div class="input-form">
                                    <h2 id="exclusive_year" class="block font-medium text-base mt-5 mb-5">
                                        Objective  <span id="from_year_label"></span><span id="to_year_label"></span>
                                    </h2> 
                                        <div class="grid grid-cols-12 gap-4 gap-y-3">
                                            

                                            <div class="input-form col-span-12 lg:col-span-12">
                                                <textarea  id="rdev_objective" name="rdev_objective" rows="2" class="form-control" placeholder="....."></textarea>
                                            </div>
                                            
                                        </div>
                                    
                                </div>

                                <div class="input-form">
                                    
                                    <button id="add_taget_btn" type="button" class="btn btn-primary w-auto">Add</button> 
                                </div>

                            </div>

                            {{-- /table --}}

                            <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5 mb-5 overflow-x-auto">

                                <table id="taget_table" class="table table-report -mt-2 table-hover">
                                    <thead>
                                        <th>#</th>
                                        <th>Development Target</th>
                                        <th>Performance Goal this Supports</th>
                                        <th>Objective</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                    
                                    </tbody>
                                </table>
                                

                            </div>
                            <div class="modal-footer dev_targetSave"> 
                               
                                <button id="btn_saveTarget" type="submit" class="btn btn-primary w-20">Save</button> 
                            </div> 
                            <!-- END: Modal Footer -->
                           
                        </form>
                    </div>
                </div>

            </div>
            <!-- END: Modal Body -->

        </div>
    </div>
</div>
<!-- END: Super Large Modal Content -->

