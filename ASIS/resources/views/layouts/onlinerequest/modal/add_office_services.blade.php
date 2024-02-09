
<!-- BEGIN: Modal Content -->
<div id="add_office_services_modal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header" style="background-color:rgb(30, 64, 175)">
                <h2 class="font-medium text-base mr-auto text-white">Add Services</h2> 
               
            
            </div> <!-- END: Modal Header -->
          
            <form method="POST"  enctype="multipart/form-data">
               @csrf
            <!-- BEGIN: Modal Body -->

            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-6"> 
                   <label for="modal-form-2" class="form-label">Office</label> <label id="office_id" name="office_id" class="hidden"></label>
                      <input id="office_name" name="office_name" type="text" class="form-control" readonly> 
               </div>


               <div class="col-span-12 sm:col-span-6"> 
                   <label for="modal-form-4" class="form-label">Services</label> 
                   <input id="office_services" name="office_services" type="text" class="form-control"> 
               </div>
           
            </div> <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            </form>

            <div class="modal-footer"> 
               <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <button type="button" id="store_officeServices_btn" href="javascript:;" class="btn btn-primary w-20"><i class="fa-solid fa-plus"></i></i>Save</button> </div>
           <!-- END: Modal Footer -->
        </div>
    </div>
</div> <!-- END: Modal Content -->
