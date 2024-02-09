<!-- BEGIN: Overlapping Groups Modal Content -->
<div id="add_new_track" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-s">
        <form id="form_sendCreatedDocs" class="modal-content" method="post">
            @csrf
            <!-- BEGIN: Modal Header -->
            <div class="modal-header flex items-center justify-center">
                <h2 class="font-medium text-base mr-auto">Release Trail</h2>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body">
                <div>
                    <div class="mr-2">
                        <label class="form-label">Tracking Number</label>
                        <input id="send_DocCode" disabled name="send_DocCode" type="text" class="form-control">
                    </div>
                </div>
            <div class="mt-2">
                <label>Add user to trail</label>
                <div class="mt-2">
                    <select class="select2-multiple w-full" multiple="multiple" id="receive_modal_add_trail">
                        @forelse (loaduser('') as $users)

                            @if ($users->getUserinfo)
                                <option value="{{ $users->employee }}">{{ $users->getUserinfo->firstname }} {{ $users->getUserinfo->lastname }}</option>
                            @else

                            @endif

                        @empty

                        @endforelse
                      </select>
                </div>
            </div>
            <!-- END: Basic Select -->
            <!-- BEGIN: Transactions -->
            <div class="col-span-12 md:col-span-6 xl:col-span-4 2xl:col-span-12 mt-3 2xl:mt-8">
                <div class="intro-x flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Trail
                    </h2>
                </div>
                <div  class="mt-5">

                </div>
            </div>
            <!-- END: Transactions -->
            <!-- BEGIN: Recent Activities -->
                                <div class="col-span-12 md:col-span-6 xl:col-span-4 2xl:col-span-12 mt-3">
                                    <div class="intro-x flex items-center h-10">
                                        <h2 class="text-lg font-medium truncate mr-5">
                                            Recent Activities
                                        </h2>
                                        <a href="" class="ml-auto text-primary truncate">Show More</a>
                                    </div>
                                    <div id="load_trail_record" class="mt-5 relative before:block before:absolute before:w-px before:h-[85%] before:bg-slate-200 before:dark:bg-darkmode-400 before:ml-5 before:mt-5">

                                    </div>
                                </div>
                                <!-- END: Recent Activities -->
            <!-- BEGIN: Nested Select -->
            </div>
            <!-- END: Modal Body -->

            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <a id="add_track_modal_button" class="btn btn-primary w-auto mb-2" href="javascript:;">
                    <i class="fa fa-inbox w-4 h-4 mr-2"></i> Done
                </a>
            </div>
            <!-- END: Modal Footer -->
        </form>
    </div>
</div>
<!-- END: Overlapping Groups Modal Content -->


<!-- BEGIN: Overlapping Groups Modal Content -->
<div id="view_track" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-s">
        <form id="form_sendCreatedDocs" class="modal-content" method="post">
        @csrf
        <!-- BEGIN: Modal Header -->
            <div class="modal-header flex items-center justify-center">
                <h2 class="font-medium text-base mr-auto">Release Trail</h2>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body">
                <div>
                    <div class="mr-2">
                        <label class="form-label">Tracking Number</label>
                        <input id="view_DocCode" disabled name="send_DocCode" type="text" class="form-control">
                    </div>
                </div>
                <!-- BEGIN: Transactions -->
                <div class="col-span-12 md:col-span-6 xl:col-span-4 2xl:col-span-12 mt-3 2xl:mt-8">
                    <div class="intro-x flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            Trail
                        </h2>
                    </div>
                    <div  class="mt-5">

                    </div>
                </div>
                <!-- END: Transactions -->
                <!-- BEGIN: Recent Activities -->
                <div class="col-span-12 md:col-span-6 xl:col-span-4 2xl:col-span-12 mt-3">
                    <div class="intro-x flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            Recent Activities
                        </h2>
                        <a href="" class="ml-auto text-primary truncate">Show More</a>
                    </div>
                    <div id="view_loaded_trail_record" class="mt-5 relative before:block before:absolute before:w-px before:h-[85%] before:bg-slate-200 before:dark:bg-darkmode-400 before:ml-5 before:mt-5">

                    </div>
                </div>
                <!-- END: Recent Activities -->
                <!-- BEGIN: Nested Select -->
            </div>
            <!-- END: Modal Body -->

            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-primary w-20 mr-1">OK</button>
            </div>
            <!-- END: Modal Footer -->
        </form>
    </div>
</div>
<!-- END: Overlapping Groups Modal Content -->

