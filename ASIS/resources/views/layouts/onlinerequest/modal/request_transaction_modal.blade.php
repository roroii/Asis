<div id="request_transaction_modal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
  
            <div class="modal-header" style="background-color:rgb(30, 64, 175)">
                <h2 class="font-medium text-white">Please Schoose date and Program you want to generate</h5>
        </div>
 
    <form method="POST" action="/onlinerequest/dashboard/print_transcation" target="_blank" >
        {{ csrf_field() }}

<!-- BEGIN: Transaction Details -->

    <!-- Start Category-->

    <div class="col-span-12 lg:col-span-4">
     
                            <div class="dropdown-content">
                                <div class="grid grid-cols-12 gap-4 gap-y-3 p-3">
                                    <div class="col-span-6">
                                        <label for="input-filter-1" class="form-label text-xs">From</label>
                                        <input id="date_from_req" name="date_from_req" type="date" class="form-control flex-1">
                                    </div>
                                    <div class="col-span-6">
                                        <label for="input-filter-2" class="form-label text-xs">To</label>
                                        <input id="date_to_req" name="date_to_req" type="date" class="form-control flex-1">
                                    </div>
                                    <div class="col-span-6">
                                        <label for="input-filter-4" class="form-label text-xs">Program</label>
                                        <select id="programCourse" name="programCourse" class="form-control" data-placeholder="Select program">
                                            
                                            @forelse($get_StudentCourse as $course)
                                            
                                            <option value="{{$course->studmajor}}">{{$course->

                                            studmajor}}</option>
                                            
                                            @empty
                                            
                                            <p>No Data Available</p>

                                            @endforelse
    
                                        </select>
                                    </div>
                                    <div class="col-span-12 flex items-center mt-3">
                                       
                                        <button class="btn btn-primary ml-auto" id="program_Course_btn">Print<span class="ml-2"><i data-lucide="printer" class="w-5 h-5"></i></span></button> &nbsp<button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                                    </div>
                               

<!-- END: Catergory Details -->
</div>
</div>
</form>
</div>




