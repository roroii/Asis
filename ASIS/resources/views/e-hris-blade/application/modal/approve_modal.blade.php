<div id="job_approval_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"> <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x" class="w-8 h-8 text-slate-400"></i> </a>
            @csrf
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Application Approval</h2>
            </div>
            <div class="modal-body">
                <div class="intro-y col-span-12 sm:col-span-6 2xl:col-span-4 pb-5">
                    <div class="text-slate-600 dark:text-slate-500">

                        <div class="input-form col-span-12 lg:col-span-6">

                            <input class="hidden" id="applicant_id">
                            <input class="hidden" id="job_ref_no">

{{--                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Applied Position(s) </label>--}}
{{--                            <select class="select2 w-full" id="applied_pos">--}}
{{--                            </select>--}}
                            <table id="dt__approve_applied_pos" class="table table-report table-hover">
                                <thead class="btn-secondary">
                                <tr>
                                    <th >Positions</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                        <div id="job_attachments_div">

                        </div>
                    </div>
                </div>
            </div>
{{--            <div class="modal-footer download_all_div">--}}
{{--                <a href="javascript:;" id="btn_approve_application" type="button" class="btn btn-primary"> Approve Application </a>--}}
{{--            </div>--}}
        </div>
    </div>
</div>
