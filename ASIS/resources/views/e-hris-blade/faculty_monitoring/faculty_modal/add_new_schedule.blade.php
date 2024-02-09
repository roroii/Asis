<!-- Add Documents Modal -->
<div id="add_new_schedule_modal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="form_createDocs"  method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="alert alert-danger" style="display:none"></div>
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">New Schedule</h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <input hidden id="modal_update_schedule_id" type="text" class="form-control" placeholder="id">



                    <div class="col-span-12 sm:col-span-6">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Subject Name</label>
                        <input id="modal_subject_name" type="text" class="form-control" placeholder="Subject Name">
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Subject Code</label>
                        <input id="modal_subject_code" type="text" class="form-control" placeholder="Subject Code">
                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Type</label>
                        <input id="modal_type" type="text" class="form-control" placeholder="Type">
                    </div>
                    {{-- <div class="col-span-12 sm:col-span-6">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Days</label>
                        <select class="w-full multiple" id="days_modal"  data-placeholder="Select Day(s)" multiple>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                        </select>
                    </div> --}}

                    <div class="col-span-12 sm:col-span-6">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Time</label>
                        <input id="modal_date_time" type="time" class="form-control" placeholder="Time">
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Status</label>
                        <input id="modal_status" type="text" class="form-control" placeholder="Status">
                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Year</label>
                        <input id="modal_year" type="number" class="form-control" placeholder="year" min="2023" value="2023">
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Sem</label>
                        <select class="w-full " id="modal_sem"  data-placeholder="Sem">
                            <option value="1">First Sem</option>
                            <option value="2">Second Sem</option>
                            <option value="3">Summer</option>

                        </select>
                    </div>

                    <div class="col-span-12 sm:col-span-12">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Description</label>
                        <textarea style="height: 100px" id="modal_Description" class="form-control" name="modal_Description" placeholder="Type your Description...." ></textarea>
                    </div>


                </div>
                <!-- END: Modal Body -->

                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button  type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                    <a  href="javascript:;" id="add_new_schedule_btn" class="btn btn-primary w-20 add_new_schedule_btn"> Save </a>
                    {{-- <button id="add_travel_order" class="btn btn-primary w-20 add_travel_order">Save</button> --}}
                </div>
                <!-- END: Modal Footer -->
            </div>
        </form>
    </div>
</div>
<!-- END: Modal Content -->
