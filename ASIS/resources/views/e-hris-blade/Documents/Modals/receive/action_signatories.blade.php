<!-- BEGIN: signatories Modal Content -->
<div id="view_signatories_modal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="form_sendCreatedDocs" class="modal-content" method="post">
        @csrf
        <!-- BEGIN: Modal Header -->
            <div class="modal-header flex items-center justify-center">
                <h2 class="font-medium text-base mr-auto">Signatories Information</h2>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body">
                <div id="modal_content_title_and_desc">

                </div>


                <div class="mt-2">
                    <div class="mr-2">
                        <label class="form-label "><strong>Signatories</strong></label>
                        <div id="modal_content_signatories" class="chat__user-list overflow-y-auto scrollbar-hidden pr-1 pt-1 border-t border-slate-200 dark:border-darkmode-400">



                        </div>
                    </div>
                </div>



                 <!-- BEGIN: signatory history Modal Content -->
                 <div id="modal_second_signatory_history" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header flex items-center justify-center">
                                <h2 class="font-medium text-base mr-auto">Signatory Action History</h2>
                            </div>

                            <div class="modal-body ">
                                <div class="mr-2">
                                    <div id="load_sig_div_modal_history" class="chat__user-list overflow-y-auto scrollbar-hidden pr-1 pt-1  border-slate-200 dark:border-darkmode-400">

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


                <!-- BEGIN: signatory action Modal Content -->
                <div id="modal_third_signatory_action" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header flex items-center justify-center">
                                <h2 class="font-medium text-base mr-auto">Take Action</h2>
                            </div>

                            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                                <input hidden id="modal_release_signatory_id" type="text" class="form-control" placeholder="id">
                                <input hidden id="modal_release_document_track_id" type="text" class="form-control" placeholder="id">
                                <input hidden id="modal_release_document_doc_track_id" type="text" class="form-control" placeholder="id">

                                <div class="col-span-12 sm:col-span-12">
                                    @if (Auth::check())
                                        <!-- BEGIN: Send as Select -->
                                        <div class=" mb-5"> <label>Name</label>
                                            <div >
                                                <select id="doc_sendAs" data-placeholder="Select..." class="tom-select w-full" required>
                                                    <option data-ass-type="user" value="{{ Auth::user()->employee }}">{{ loaduser(Auth::user()->employee)->getUserinfo->firstname }} {{ loaduser(Auth::user()->employee)->getUserinfo->lastname }}</option>
                                                </select>

                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-span-12 sm:col-span-12">
                                    <div class=" mb-5"> <label>Action</label>
                                        <div >
                                            <select id="action_third_modal_list" data-placeholder="Select..." class="tom-select w-full" required>
                                                <option value="1">Approved</option>
                                                <option value="2">Disapproved</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-span-12 sm:col-span-12">
                                    <div class=" mb-5"> <label>Allow e-Signature?</label>
                                        <div >
                                            <select id="e-sig_third_modal_list" data-placeholder="Select..." class="tom-select w-full" required>
                                                <option value="1">Yes</option>
                                                <option value="2">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-span-12 sm:col-span-12">
                                    <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Message</label>
                                    <textarea style="height: 100px" id="third_modal_message" class="form-control" name="message" placeholder="Type your message...." ></textarea>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-auto3">Close</button>
                                <a href="javascript:;" id="btn_action_third_save_modal" class="btn btn-primary w-20 "> Save </a>
                            </div>
                        </div>
                    </div>
                </div> <!-- END: action Modal Content -->


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
