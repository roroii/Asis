<div id="update_profile_picture_mdl" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" id="form_profile_picture" method="post" enctype="multipart/form-data">
            @csrf
{{--            <div class="modal-header">--}}
{{--                <h2 class="font-medium text-base mr-auto">Update your profile picture</h2>--}}
{{--            </div>--}}

            <div class="modal-body p-0">
{{--                <div class="intro-y col-span-12 sm:col-span-6 2xl:col-span-4">--}}
{{--                    <div class="box">--}}

                        <input id="current_profile_picture_value" name="current_profile_picture_value" class="hidden">

{{--                        <div class="p-5">--}}
{{--                            <div id="update_profile_holder" class="h-40 2xl:h-56 image-fit rounded-md overflow-hidden before:block before:absolute before:w-full before:h-full before:top-0 before:left-0 before:z-10 before:bg-gradient-to-t before:from-black before:to-black/10">--}}

{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

                <div class="box">
                    <div class="p-5">
                        <label for="validation-form-2" class="form-label w-full flex flex-col sm:flex-row"> Upload profile picture <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Maximum of 5 MB</span> </label>
                        <input id="up_profile_pic"
                               type="file"
                               class="filepond mt-1"
                               name="up_profile_pic[]"
                        >
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <button id="btn_save_profile_pic" type="submit" class="btn btn-primary w-20">Update</button>
            </div>
        </form>
    </div>
</div>




<div id="add_e_signature_mdl" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">

        <form class="modal-content" id="form_e_signature" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body px-5 py-5">

                <input id="old_e_signature_value" name="old_e_signature_value" class="hidden">

                <label for="validation-form-2" class="form-label w-full flex flex-col sm:flex-row"> Upload your E-Signature <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">(Required PNG Format, Maximum of 1MB)</span> </label>
                <input id="e_signature" name="e_signature" type="file"  class="filepond mt-1">
            </div>

            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <button type="submit" class="btn btn-primary w-20">Save</button>
            </div>

        </form>
    </div>
</div>
<!-- END: Modal Content -->

<div id="delete_e_sig_mdl" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center"> <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                    <div class="text-3xl mt-5">Are you sure?</div>
                    <div class="text-slate-500 mt-2">Do you really want to delete these E-Signature? <br>This process cannot be undone.</div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                    <button id="btn_delete_e_sig_mdl" type="button" class="btn btn-danger w-24">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
