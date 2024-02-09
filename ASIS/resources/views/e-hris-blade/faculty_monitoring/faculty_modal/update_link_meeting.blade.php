<!-- Add Documents Modal -->
<div id="modal_update_link_meeting" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form_link_meeting"  method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="alert alert-danger" style="display:none"></div>
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Linked meetings</h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <input hidden id="modal_update_link_id" type="text" class="form-control" placeholder="id">

                    <div class="col-span-12 sm:col-span-12">
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
                    </div>

                    <div class="col-span-12 sm:col-span-12">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Title</label>
                        <input id="modal_title_meeting" name="modal_title_meeting" type="text" class="form-control" placeholder="Link">
                    </div>

                    <div class="col-span-12 sm:col-span-12">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Link</label>
                        <input id="modal_link_meeting" name="modal_link_meeting" type="text" class="form-control" placeholder="Link">
                    </div>

                    <div class="col-span-12 sm:col-span-12">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Description</label>
                        <textarea style="height: 100px" id="modal_link_meeting_description" class="form-control" name="modal_link_meeting_description" placeholder="Type your Description...." ></textarea>
                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Expected Time Start</label>
                        <input id="modal_date_time_start" type="time" class="form-control" placeholder="Time Start">
                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Expected Time End</label>
                        <input id="modal_date_time_end" type="time" class="form-control" placeholder="Time End">
                    </div>

                    <div class="col-span-12 sm:col-span-12">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Auto End After (hour)</label>
                        <input id="modal_end_after_meeting" type="number" name="modal_end_after_meeting" min="1" max="24" type="text" value="1" class="form-control" placeholder="Hours">
                    </div>

                    <div class="col-span-12 sm:col-span-12">
                        <div class="alert alert-outline-warning alert-dismissible show flex items-center bg-warning/20 dark:bg-darkmode-400 dark:border-darkmode-400 mt-5" role="alert">
                            <span><i data-lucide="alert-triangle" class="w-6 h-6 mr-3"></i></span>
                            <span class="text-slate-800 dark:text-slate-500">Please ensure that you carefully consider the specific day(s) of the subject for which you may require additional privileges to update this data. <a class="text-primary font-medium" href="javascript:;">Learn More</a></span>
                            <button type="button" class="btn-close dark:text-white" data-tw-dismiss="alert" aria-label="Close"> <i data-lucide="x" class="w-4 h-4"></i> </button>
                        </div>
                    </div>



                </div>
                <!-- END: Modal Body -->

                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button  type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                    <a  href="javascript:;" id="add_update_link_meeting_modal_btn" class="btn btn-primary w-20 add_update_link_meeting_modal_btn"> Save </a>
                </div>
                <!-- END: Modal Footer -->
            </div>
        </form>
    </div>
</div>
<!-- END: Modal Content -->
