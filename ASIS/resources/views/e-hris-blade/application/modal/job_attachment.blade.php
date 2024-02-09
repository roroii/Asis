<div id="job_attachment_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"> <a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x" class="w-8 h-8 text-slate-400"></i> </a>
            @csrf
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Attachment Details</h2>
            </div>
            <div class="modal-body">
                <div class="intro-y col-span-12 sm:col-span-6 2xl:col-span-4 pb-5">
                    <div class="text-slate-600 dark:text-slate-500">
                        <div class="overflow-x-auto scrollbar-hidden pb-10">
                            <table id="dt__attachment_list" class="table table-report -mt-2 table-hover">
                                <thead class="btn-secondary">
                                <tr>
                                    <th class="whitespace-nowrap ">Attached Files</th>
                                    <th class="text-center whitespace-nowrap ">Action</th>
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
            <div class="modal-footer download_all_div">
{{--                <a href="javascript:;" target='_blank' id="btn_download_all" type="button" class="btn btn-outline-secondary"> Download All </a>--}}
            </div>
        </div>
    </div>
</div>
