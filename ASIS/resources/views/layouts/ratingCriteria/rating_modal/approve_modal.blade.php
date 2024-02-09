 <!-- BEGIN: Modal Content -->
 <div id="approve_modal" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content"><a data-tw-dismiss="modal" href="javascript:;" class="text-danger"> <i data-lucide="x" class=" w-4 h-4 text-slate-400"></i> </a>
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 id="proceed_head" class="font-bold text-base mr-auto">Complete</h2>
                
            </div> <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body">
                <input type="hidden" id="rated_id" name="rated_id">
                <input type="hidden" id="shortList_id" name="shortList_id">
                <input type="hidden" id="applicant_id" name="applicant_id">
                <input type="hidden" id="position_id" name="position_id">
                <input type="hidden" id="profile_id" name="profile_id">
                <input type="hidden" id="ref_num" name="ref_num">
                <input type="hidden" id="approving_id" name="approving_id">
                <div class="col-span-12 md:col-span-6 xl:col-span-2">
                    <div class="col-span-12 sm:col-span-6 mt-2">
                        <textarea name="remarks" id="remarks" cols="10" placeholder="Type Remarks" class="form-control" required></textarea>   
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" href="javascript:;" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <button type="button" href="javascript:;" class="btn btn-primary w-20 apprv_btn">Complete</button>
            </div>

        </div>
    </div>
</div>  <!-- END: Modal Content -->
