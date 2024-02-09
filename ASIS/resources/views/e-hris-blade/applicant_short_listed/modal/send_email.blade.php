 <!-- BEGIN: Modal Content -->
 <div id="send_email_notification" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <!-- BEGIN: Modal Header -->
             <div class="modal-header">
                 <h2 class="font-medium text-base mr-auto">Sent Email Notification</h2>
                 <i class="fa fa-paper-plane w-5 h-5 primary fa-beat text-primary"></i>
             </div> <!-- END: Modal Header -->
             <form class="modal-content" id="email_attachment" enctype="multipart/form-data">
                @csrf
             <!-- BEGIN: Modal Body -->
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-12"> <label for="modal-form-2" class="form-label font-semibold">To</label> <input id="email_to" name="email_to" type="text" class="form-control" placeholder="example@gmail.com"> </div>
                    <div class="col-span-12 sm:col-span-12"> <label for="modal-form-1" class="form-label font-semibold">Message Title</label> <input id="email_title" name="email_title" type="text" class="form-control" placeholder="example@gmail.com"> </div>
                    <div class="col-span-12 sm:col-span-12"> <label for="modal-form-5" class="form-label font-semibold">Message Content</label>
                        <textarea id="email_mesages" name = "email_mesages" onchange="" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border" placeholder="Enter notes" ></textarea>
                    </div>
                    <div class="col-span-12 sm:col-span-12"> <label for="modal-form-5" class="form-label font-semibold">Closing Remarks</label>
                        <textarea id="email_closing_tag" name = "email_closing_tag" onchange="" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border" placeholder="Enter notes" ></textarea>
                    </div>
                    <div class="col-span-12 sm:col-span-12"> <label for="modal-form-1" class="form-label font-semibold">Attach Files</label>
                        <input id="email_attachments" name="email_attachments[]" type="file">
                    </div>
                </div>
                <!-- END: Modal Body -->
             <!-- BEGIN: Modal Footer -->
             <div class="modal-footer mt-2">
                <button type="button" id="btn_cancel_email_notif" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <button id="btn_send_email" type="submit" class="btn btn-primary w-20">Send</button>
            </div>
        </form><!-- END: Modal Footer -->
         </div>
     </div>
 </div> <!-- END: Modal Content -->
