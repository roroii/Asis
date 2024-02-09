<!-- BEGIN: signatories Modal Content -->
<div id="view_conversation_members_modal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form_sendCreatedDocs" class="modal-content" method="post">
        @csrf
        <!-- BEGIN: Modal Header -->
            <div class="modal-header flex items-center justify-center">
                <h2 class="font-medium text-base mr-auto">Conversation Member(s)</h2>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body">
                <div id="modal_content_title_and_desc">

                </div>


                <div class="mt-2">
                    <div class="mr-2">
                        <label class="form-label "><strong>Member(s)</strong></label>
                        <div style="height: 500px" id="modal_content_members" class="chat__user-list overflow-y-auto border-t border-slate-200 dark:border-darkmode-400">



                        </div>
                    </div>
                </div>



                 <!-- BEGIN: signatory history Modal Content -->
                 <div id="modal_second_chat_history" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header flex items-center justify-center">
                                <h2 class="font-medium text-base mr-auto">Chat History</h2>
                            </div>

                            <div class="modal-body ">
                                <div class="mr-2">
                                    <div style="height: 400px" id="load_chat_div_modal_history" class="chat__user-list overflow-y-auto pr-1 pt-1  border-slate-200 dark:border-darkmode-400">

                                    </div>
                                </div>
                            </div>
                            <!-- BEGIN: Modal Footer -->
                            <div class="modal-footer">
                                <button  type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-auto">Done</button>
                            </div>
                            <!-- END: Modal Footer -->
                        </div>
                    </div>
                </div> <!-- END: history Modal Content -->

                <!-- BEGIN: Modal Content -->
                <div id="modal_third_remove_action" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                <div class="p-5 text-center"> <i data-lucide="trash" class="w-16 h-16 text-danger mx-auto mt-3 fa-beat"></i>
                                    <div class="text-3xl mt-5">Remove User?</div>
                                    <div class="text-slate-500 mt-2">Do you really want to remove this user? <br>This process cannot be undone.</div>
                                </div>
                                <div class="px-5 pb-8 text-center"> <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1 "><span class="">Cancel</span></button> <button id="btn_third_modal_remove_user" type="button" class="btn btn-danger w-24 zoom-in">Yes</button> </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- END: Modal Content -->

            </div>
            <!-- END: Modal Body -->

            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-auto">Done</button>
            </div>
            <!-- END: Modal Footer -->
        </form>
    </div>
</div>
<!-- END: signatories Modal Content -->
