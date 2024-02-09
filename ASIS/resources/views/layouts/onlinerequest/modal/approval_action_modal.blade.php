
<div id="approval_action_modal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header" style="background-color:rgb(30, 64, 175)">
                <h2 class="font-medium text-white">Requested Action for</h5><p class="font-medium text-white">(</p>
                  <p id="std_fullname_txt" class="font-medium text-white"></p><p class="font-medium text-white">)</p>
        </div>

        <form method="POST"  enctype="multipart/form-data">
         @csrf

        <div class="modal-body">
                    <div class="row">

                    <input id="std_id" class="hidden">
                      <input id="studid" class="hidden">

            <div class="col-md-5 pr-1">
                 <div class="form-group">
                  <div class="col-span-12 sm:col-span-6"> 
                        <label for="modal-form-1" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select" required>
                        <option value="option_select" disabled selected>Please Select</option>
                        <option value="Approved">Approved</option>
                        <option value="Disapproved">Disapproved</option>
                </select>
            </div><br>


                    <div class="col-span-12 sm:col-span-6"> 
                            <label for="modal-form-1" class="form-label">Claim Date</label>
                          <input type="date" id="claim_date" name="claim_date" class="form-control">
                    </div>

            </div><br>

              <div class="col-span-12 sm:col-span-6"> 
                            <label for="modal-form-1" class="form-label">Message</label>
                           <textarea id="messages" name="messages" type="text" class="form-control"rows="2" cols="30"></textarea>  
                </div> <br> 


               <div class="col-span-12 sm:col-span-6"> 
                    <label for="modal-form-1" class="form-label">Attachment file</label>
                   <input id="attachments_request_id" type="file" class="filepond mt-1" name="attachments_request_id[]">
           
                </div><br> 

                    <div class="col-span-12 sm:col-span-6 hidden"> 
                </div> 

                </div>
        </div> 
    </div>
    </form>
    <div class="modal-footer">
        <button type="button" id="approve_request_btn" href="javascript:;" class="approve_request_btn btn btn-sm btn-primary w-30 mr-1 mb-2"><span class="mr-1"><i class="fa-solid fa-location-arrow"></i></span>Submit</button>
        <button type="button" data-tw-dismiss="modal" class="btn btn-sm btn-outline-secondary w-30 mr-1 mb-2">Cancel</button>
            </div>
        </div>
    </div>
</div>


