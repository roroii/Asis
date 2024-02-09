<!-- BEGIN: Modal Content -->
<div id="openVoting_application_Modal" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
   <div class="modal-dialog modal-lg">
       <div class="modal-content"><a id="openAppsetDate_cancelBtn" data-tw-dismiss="modal" href="javascript:;"><i class="fa-sharp fa-light fa-circle-xmark w-5 h-5 text-danger zoom-in"></i> </a>
           <!-- BEGIN: Modal Header -->
           <div class="modal-header">
               <h2 id="header_voteTypeName" class="font-bold text-base mr-auto">OPEN VOTING</h2>

           </div> <!-- END: Modal Header -->

           <form id="openApplicantion_Date_form" enctype="multipart/form-data">

               @csrf

               <input id="voteTypeID" value="0" name="voteTypeID" type="hidden">
               <!-- BEGIN: Modal Body -->
               <div class="modal-body">

                <div class="grid grid-cols-12 gap-6">

                    <div class="col-span-12 sm:col-span-6">
                        <label for="openDate" class="form-label">Open Date</label>
                        <input id="openDate" name="openDate" type="date" class="form-control">
                        <label id="openDate_lbl" class="text-xs text-danger hidden">Opening Date must not be greater than the closing Date</label>
                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <label for="openTime" class="form-label">Open Time</label>
                        <input id="openTime" name="openTime" type="time" class="form-control">
                    </div>

                </div>

                <div class="grid grid-cols-12 gap-6 mt-3">
                    <div class="col-span-12 sm:col-span-6">
                        <label for="closeDate" class="form-label">Close Date</label>
                        <input id="closeDate" name="closeDate" type="date" class="form-control">
                        <label id="closeDate_lbl" class="text-xs text-danger hidden">Closing Date must not be lesser than the opening Date</label>
                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <label for="closeTime" class="form-label">Close Time</label>
                        <input id="closeTime" name="closeTime" type="time" class="form-control">
                    </div>
                </div>
        </div>


           <!-- BEGIN: Modal Footer -->
           <div class="modal-footer">
               {{--  <button type="button" href="javascript:;" class="btn btn-secondary w-20 mr-1" data-tw-dismiss="modal">Close</button>  --}}
               <button id="openAppsetDate_submitBtn" type="submit" href="javascript:;" class="btn btn-primary w-20 mr-1">Set</button>
           </div>
           <!-- END: Modal Footer -->

           </form>

       </div>
   </div>
</div>  <!-- END: Modal Content -->


