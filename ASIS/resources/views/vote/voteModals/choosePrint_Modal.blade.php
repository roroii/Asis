 <!-- BEGIN: Modal Content -->
 <div id="chose_print_modal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"><a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x" class="w-6 h-6 text-danger"></i> </a>
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Choose Print</h2>               
            </div> <!-- END: Modal Header -->
            <form action="{{ route('print_vote_result') }}" method="get" target="_blank" enctype="multipart/form-data">
                <div class="modal-body p-10 text-center">
                
                        <input id="type_id" name="type_id" type="hidden">
                        <input id="to_print" name="to_print" type="hidden">
                        <div class="gap-5 mt-1">
                            
                                <div id="print_result_all" class="col-span-12 sm:col-span-4 2xl:col-span-3 bg-slate-200 box p-5 cursor-pointer zoom-in">
                                    <div id="print_result_text" class="font-medium text-base text-primary">Print Result</div>
                                </div>
                            

                            
                                <div id="print_win_result" class="col-span-12 sm:col-span-4 2xl:col-span-3 bg-slate-200 box p-5 cursor-pointer zoom-in mt-2">
                                    <div id="printWin_result_text" class="font-medium text-base text-primary">Print Win Result</div>
                                </div>
                                            
                        </div>
                    
                    
                </div>
                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                    <button id="btn_modal_load_to_print" type="submit" class="btn btn-primary w-20">Generate</button>
                </div> <!-- END: Modal Footer -->
            </form>
        </div>
         
    </div>
</div> <!-- END: Modal Content -->