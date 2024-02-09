
<div id="add_new_office_modal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header" style="background-color:rgb(30, 64, 175)">
                <h2 class="font-medium text-base mr-auto text-white">Add New Office</h2> 
               
            
            </div> <!-- END: Modal Header -->
          
            <form method="POST"  enctype="multipart/form-data">
               @csrf
            <!-- BEGIN: Modal Body -->


          <div class="modal-body">       
                    <div class="row">
                    <div class="col-md-5 pr-1">
                    <div class="form-group">
                        <div class="col-span-12 sm:col-span-8"> 
                            <label for="modal-form-1" class="form-label">Office Name</label> 
                            <input id="officename" name="officename" type="text" class="form-control" required autocomplete="off"  > 
                        </div>
                   
                 </div>        
        </div><!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            </form>

            <div class="modal-footer"> 
               <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <button type="button" id="store_new_office_btn" href="javascript:;" class="btn btn-primary w-20">Save</button> </div>
           <!-- END: Modal Footer -->
        </div>
    </div>
</div> <!-- END: Modal Content -->
