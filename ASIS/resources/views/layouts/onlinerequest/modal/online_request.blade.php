
<!-- BEGIN: Modal Content -->
<div id="online_request_modal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header" style="background-color:rgb(30, 64, 175)">
                <h2 class="font-medium text-base mr-auto text-white">Online Request Application</h2> 
               
            
            </div> <!-- END: Modal Header -->
          
            <form method="POST"  enctype="multipart/form-data">
               @csrf
            <!-- BEGIN: Modal Body -->

            <input type="hidden" id="course" name="course"  value="{{ $student_course}}"> 

            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

              <div class="col-span-12 sm:col-span-6"> 
                   <label for="modal-form-3" class="form-label">Office</label> 
                   <select id="office_name" name="office_name" class="tom-select w-full office_name">
                    @foreach($get_offices as $index => $row)
                    <option value="option_select" disabled selected>Choose Office</option>
                    <option value="{{ $row->office_id }}">{{$row->office_name }}</option>
                    @endforeach
                   </select> 
               </div>



             <div class="col-span-12 sm:col-span-6">
            <label for="modal-form-4" class="form-label">Request Type</label>
            <select id="request_type" name="request_type" class="services form-control">
                <option value="0" selected disabled>Choose Request</option>
                <!-- Other options will be appended dynamically via JavaScript -->
            </select>
        </div>


                <div class="col-span-12 sm:col-span-6"> 
                   <label for="modal-form-4" class="form-label">Purpose</label> 
                   <input id="purpose" name="purpose" type="text" class="form-control" placeholder ="Type your purpose here..."> 
               </div>


               <div class="col-span-12 sm:col-span-6"> 
                   <label for="modal-form-4" class="form-label">Number of Copies</label> 
                   <input id="no_of_copies" name="no_of_copies" type="number" class="form-control" value="0"> 
               </div>


                <div class="col-span-12 sm:col-span-6"> 
                    <label for="modal-form-3" class="form-label">Message</label> 
                   <textarea id="message" name="message" rows="2" class="form-control" cols="48" placeholder="Your message is here..."></textarea>
               </div>


           
            </div> <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            </form>

            <div class="modal-footer"> 
               <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <span class="mr-1"><button type="button" id="store_online_request_btn" href="javascript:;" class="btn btn-primary w-20"> <i class="fa-solid fa-location-arrow"></span></i>Request</button> </div>
           <!-- END: Modal Footer -->
        </div>
    </div>
</div> <!-- END: Modal Content -->




