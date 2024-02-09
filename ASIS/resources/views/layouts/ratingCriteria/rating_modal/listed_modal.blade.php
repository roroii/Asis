<!-- BEGIN: Modal Content -->
<div id="listed_modal" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 id="header_name" class="font-bold text-base mr-auto"></h2>
                
                <div class="dropdown"> 
                    <a class=" w-5 h-5 block" 
                        id="btn_cancel_listed_modal"
                        href="javascript:;" 
                        data-tw-dismiss="modal"> 
                        <i data-lucide="x" class="w-5 h-5 text-slate-500"></i> 
                    </a>
                    
                </div>
            </div> <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->


                {{ csrf_field() }}
                <div class="modal-body">

                    <div id="listed_tbl_div" class="mb-3">
                        
                    </div>

                </div>
                    <!-- END: Modal Body -->

                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button type="button" id="btn_cancel_listed_modal" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                    {{-- <button id="add_criteria_btn" type="submit" class="btn btn-primary w-20">Save</button> --}}
                </div>
                <!-- END: Modal Footer -->
        </div>
    </div>

</div>  <!-- END: Modal Content -->


