<div id="add_file_attachments_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" id="form_applicant_attachments" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Add File Attachments</h2>
            </div>

            <input id="position_ref_number" name="position_ref_number" class="hidden">

            <div id="attachment_type_div" class="hidden">

            </div>

            <div id="attachment_id_div" class="hidden">

            </div>

            <div class="modal-body p-5">

                <div id="attachment_div"  class="input-form">

                </div>
{{--                <div class="input-form">--}}
{{--                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Attach Personal Data Sheet <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Maximum of 5 MB</span> </label>--}}
{{--                    <input id="personal_data_sheet"--}}
{{--                           type="file"--}}
{{--                           class="filepond mt-1"--}}
{{--                           name="personal_data_sheet[]"--}}
{{--                           multiple--}}
{{--                    >--}}
{{--                </div>--}}

{{--                <div class="input-form mt-5">--}}
{{--                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Attach Performance Rating Sheet (if applicable) <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Maximum of 5 MB</span> </label>--}}
{{--                    <input id="prs"--}}
{{--                           type="file"--}}
{{--                           class="filepond mt-1"--}}
{{--                           name="prs[]"--}}
{{--                           multiple--}}
{{--                    >--}}
{{--                </div>--}}

{{--                <div class="input-form mt-5">--}}
{{--                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Attach Photo Copy of Eligibility/Rating/License <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Maximum of 5 MB</span> </label>--}}
{{--                    <input id="eligibility"--}}
{{--                           type="file"--}}
{{--                           class="filepond mt-1"--}}
{{--                           name="cs[]"--}}
{{--                           multiple--}}
{{--                    >--}}
{{--                </div>--}}

{{--                <div class="input-form mt-5">--}}
{{--                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Attach Transcript of Records <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Maximum of 5 MB</span> </label>--}}
{{--                    <input id="tor"--}}
{{--                           type="file"--}}
{{--                           class="filepond mt-1"--}}
{{--                           name="tor[]"--}}
{{--                           multiple--}}
{{--                    >--}}
{{--                </div>--}}

            </div>
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Close</button>
                <button id="submit_attachments" type="submit" class="btn btn-primary w-20 mr-1">Submit</button>
            </div>
        </form>
    </div>
</div>
