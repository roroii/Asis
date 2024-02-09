
{{--modal for create new sched--}}
<div id="sched_modal_new_sched" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">
                    Add New Schedule
                </h2>
                <div class="dropdown sm:hidden">

                </div>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <form method="POST"  enctype="multipart/form-data">
                @csrf
            <!-- BEGIN: Modal Body -->
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12 sm:col-span-6"> <label for="modal-form-1" class="form-label">Contract ID</label> <input id="modal-form-1" type="text" class="form-control" placeholder="Contract ID"> </div>
                <div class="col-span-12 sm:col-span-6"> <label for="modal-form-2" class="form-label">Activity</label> <input id="modal-form-2" type="text" class="form-control" placeholder="Activity"> </div>
                <div class="col-span-12 sm:col-span-6"> <label for="modal-form-3" class="form-label">Project Name</label> <input id="modal-form-3" type="text" class="form-control" placeholder="Project Name"> </div>
                <div class="col-span-12 sm:col-span-6"> <label for="modal-form-4" class="form-label">Link</label> <input id="modal-form-4" type="text" class="form-control" placeholder="Link"> </div>
                <div class="col-span-12 sm:col-span-6"> <label for="modal-form-6" class="form-label">Status</label> <select id="modal-form-6" class="form-select">
                    <option>System</option>
                    <option>Pending</option>
                    <option>On-Progress</option>
                    <option>Resumed</option>
                    <option>Completed</option>
                </select> </div>
                <div class="col-span-12 sm:col-span-6"> <label for="modal-form-6" class="form-label">Percentage %</label> <select id="modal-form-6" class="form-select">
                        <option>0</option>
                        <option>10</option>
                        <option>25</option>
                        <option>35</option>
                        <option>50</option>
                        <option>65</option>
                        <option>75</option>
                        <option>85</option>
                        <option>95</option>
                        <option>100</option>
                    </select> </div>
                <div class="col-span-12 sm:col-span-6"> <label for="modal-datepicker-1" class="form-label">From</label> <input type="datetime-local" id="modal-datepicker-1" class=" form-control" data-single-mode="true"> </div>
                <div class="col-span-12 sm:col-span-6"> <label for="modal-datepicker-2" class="form-label">To</label> <input type="datetime-local" id="modal-datepicker-2" class=" form-control" data-single-mode="true"> </div>
            </div> <!-- END: Modal Body -->
            <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <a id="save_new_group" href="javascript:;" class="btn btn-primary w-20">Save <i data-lucide="save" style="color: rgb(255, 255, 255)" class="w-4 h-4 text-slate-500 ml-auto"></i></a>
            </div>
            </form>
            <!-- END: Modal Footer -->
        </div>
    </div>
</div>
