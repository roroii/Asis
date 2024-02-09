<!-- BEGIN: Modal Content -->
<div id="chat_modal_send_message" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center"> <i data-lucide="send" class="w-16 h-16 text-success mx-auto mt-3 fa-beat"></i>
                    <div class="text-3xl mt-5">Send <strong id="name_of_the_person_modal" class="text-primary"></strong> a message!</div>
                    <div class="text-slate-500 mt-2">
                        <input hidden id="user_id_on_send_modal" type="text" value="">
                        <div class="col-span-12 sm:col-span-12">
                            <label for="modal-form-2" class="form-label"></label>
                            <textarea id="sd_modal_sd" style="height: 100px"  class="form-control" name="message" placeholder="Enter your message..." > </textarea>
                        </div>

                    </div>
                </div>
                <div class="px-5 pb-8 text-center"> <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1 "><span class="">Cancel</span></button> <button id="btn_send_message_modal" type="button" class="btn btn-primary w-24 zoom-in">Yes</button> </div>
            </div>
        </div>
    </div>
</div> <!-- END: Modal Content -->
