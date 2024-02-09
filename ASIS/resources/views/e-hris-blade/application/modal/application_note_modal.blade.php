<div id="application_approval_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"> <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x" class="w-8 h-8 text-slate-400"></i> </a>
            @csrf
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Add Note</h2>
            </div>
            <div class="modal-body">
                <div class="intro-y col-span-12 sm:col-span-6 2xl:col-span-4 pb-5">
                    <div class="text-slate-600 dark:text-slate-500">

                        <div class="col-span-12 sm:col-span-12"> <label for="modal-form-5" class="form-label font-medium">Type your note here</label>
                            <textarea id="application_note" onchange="" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border" placeholder="........"></textarea>
                        </div>

                        <div class="input-form col-span-12 lg:col-span-6">

                            <input class="hidden" id="applicant_id">
                            <input class="hidden" id="job_ref_no">


                        </div>

                        <div id="job_attachments_div">

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer download_all_div">
                <a href="javascript:;" id="btn_submit_approval" type="button" class="btn btn-primary"> Submit </a>
            </div>
        </div>
    </div>
</div>
