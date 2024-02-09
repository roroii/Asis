<div id="send_CreatedDocs" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form id="form_sendCreatedDocs" class="modal-content" method="post">
            @csrf
            <!-- BEGIN: Modal Header -->
            <div class="modal-header flex items-center justify-center">
                <h2 class="font-medium text-base mr-auto">Release Document</h2>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body">
                <div class="grid grid-cols-3 mt-2">
                    <div class="mr-2">
                        <label for="modal-form-1" class="form-label">Tracking Number</label>
                        <input id="send_DocCode" disabled name="send_DocCode" type="text" class="form-control">
                    </div>
                    <div class="mr-2">
                        <label for="modal-form-1" class="form-label">Expected Receive Date</label>
                        <div class="relative">
                            <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400"> <i data-lucide="calendar" class="w-4 h-4"></i> </div> <input id="expected_receive_date" type="text" name="receive_date" class="datepicker form-control pl-12" data-single-mode="true">
                        </div>
                    </div>
                    <div>
                        <label for="modal-form-1" class="form-label">Expected Release Date</label>
                        <div class="relative">
                            <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400"> <i data-lucide="calendar" class="w-4 h-4"></i> </div> <input id="expected_release_date" type="text" name="receive_date" class="datepicker form-control pl-12" data-single-mode="true">
                        </div>
                    </div>
                </div>

            @if (Auth::check())
                <!-- BEGIN: Send as Select -->
                <div class="mt-5 mb-5"> <label>Release as</label>
                    <div >
                        <select id="doc_sendAs" data-placeholder="Select..." class="tom-select w-full" required>

                            <option data-ass-type="user" value="{{ Auth::user()->employee }}">{{ loaduser(Auth::user()->employee)->getUserinfo->firstname }} {{ loaduser(Auth::user()->employee)->getUserinfo->lastname }}</option>


                            @forelse (getAssignmetsHrdetails() as $hr)
                                @if($hr->getPosition)
                                    <option data-ass-type="position" value="{{ $hr->getPosition->id }}">{{ $hr->getPosition->emp_position  }}</option>
                                @endif
                                @if($hr->getDesig)
                                    <option data-ass-type="desig" value="{{ $hr->getDesig->id }}">{{ $hr->getDesig->userauthority  }}</option>
                                @endif
                            @empty

                            @endforelse

                            @forelse (getAssignmets()->where('type','rc')->groupBy('type_id') as $id => $rc)
                                @forelse ($rc as $rcdet)
                                    @if($rcdet->getOffice)
                                        <option data-ass-type="rc" value="{{ $rcdet->getOffice->responid }}">{{  $rcdet->getOffice->centername  }}</option>
                                    @endif

                                @empty

                                @endforelse
                            @empty

                            @endforelse

                            @forelse (getAssignmets()->where('type','group')->groupBy('type_id') as $id => $group)
                                @forelse ($group as $groupdet)
                                    @if ($groupdet->getGroup)
                                        <option data-ass-type="group" value="{{ $groupdet->getGroup->id }}">{{ $groupdet->getGroup->name }}</option>
                                    @else

                                    @endif
                                @empty

                                @endforelse
                            @empty

                            @endforelse

                        </select>

                    </div>
                </div>
            @endif
                <!-- END: Send as Select -->
                <div class="col-span-12 sm:col-span-6 mb-5">
                    <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Note</label>
                    <textarea style="height: 100px" id="send_doc_note" class="form-control" name="send_doc_note" placeholder="Type your note...."></textarea>
                </div>

                <ul class="nav nav-tabs" role="tablist">
                    <li id="modal_rd_tab_fast_send" class="nav-item flex-1" role="presentation"> <button class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#modal_div_tab_fast_send" type="button" role="tab" aria-controls="modal_div_tab_fast_send" aria-selected="true"><i class="fa fa-bolt w-4 h-4 mr-2"></i> Quick Release </button> </li>
                    <li id="modal_rd_tab_trail_send" class="nav-item flex-1" role="presentation"> <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#modal_div_tab_trail_send" type="button" role="tab" aria-controls="modal_div_tab_trail_send" aria-selected="false"><i class="fa fa-map-marker w-4 h-4 mr-2"></i> Trail Release </button> </li>
                </ul>
                <div class="tab-content border-l border-r border-b">
                    <div id="modal_div_tab_fast_send" class="tab-pane leading-relaxed p-5 active" role="tabpanel" aria-labelledby="modal_rd_tab_fast_send">
                        <div class="grid grid-cols-3 mt-2">
                            <div class="form-check form-switch flex flex-col items-start mt-3">
                                <label for="post-form-5" class="form-check-label ml-0 mb-2">Release to All</label>
                                <input id="btn_sendToAll" name="btn_sendToAll" class="form-check-input sendToAll" type="checkbox" value="1">
                            </div>
                            <div class="form-check form-switch flex flex-col items-start mt-3">
                                <label for="post-form-6" class="form-check-label ml-0 mb-2">Show Author Name</label>
                                <input id="checkBox_shoAuthor" name="checkBox_shoAuthor" class="form-check-input" type="checkbox">
                            </div>
                        </div>

                        <div class="mt-10 sendToEmployee">
                            <label class="form-label mt-2">Release to Employees</label>
                            <div style="position: relative">
                                <select class="select2-multiple w-full" multiple="multiple" id="emp_List">
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

                        <div class="mt-2 sendToGroups">
                            <label class="form-label mt-2">Release to Groups</label>
                            <div style="position: relative">
                                <select class="select2-multiple w-full" multiple="multiple" id="grp_List">
                                    @forelse (loadGroups('') as $groups)
                                        <option value="{{ $groups->id }}">{{ $groups->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>

                        <div class="mt-2 sendToRC">
                            <label class="form-label mt-2">Release to Responsibility Center</label>
                            <div style="position: relative">
                                <select class="select2-multiple w-full" multiple="multiple" id="rc__list">
                                    @forelse (loadrc('') as $rc)
                                        <option value="{{ $rc->responid }}">{{ $rc->centername }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="modal_div_tab_trail_send" class="tab-pane leading-relaxed p-5" role="tabpanel" aria-labelledby="modal_rd_tab_trail_send">
                        <div class="grid grid-cols-3 mt-2 flex justify-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="radioBtn_emps" value="user">
                                <label  class="form-check-label" for="inlineRadio1">Release to Employees</label>
                            </div>
{{--                            <div hidden class="form-check form-check-inline">--}}
{{--                                <input hidden class="form-check-input" type="radio" name="inlineRadioOptions" id="radioBtn_groups" value="groups">--}}
{{--                                <label hidden class="form-check-label" for="inlineRadio1">Send to Groups</label>--}}
{{--                            </div>--}}
{{--                            <div hidden class="form-check form-check-inline">--}}
{{--                                <input hidden class="form-check-input" type="radio" name="inlineRadioOptions" id="radioBtn_rc" value="rc">--}}
{{--                                <label hidden class="form-check-label" for="inlineRadio1">Send to RC</label>--}}
{{--                            </div>--}}
                        </div>
                        <div id="div__empList" class="overflow-x-auto scrollbar-hidden grid grid-cols-4 mt-5">
                            <button id="btn__openModalEmpList" class="btn btn-sm btn-primary w-auto mb-2 mr-5 hidden" type="button" data-tw-toggle="modal" data-tw-target="#addEmps">
                                <i class="fa fa-user-plus w-4 h-4 mr-2 release_icon"></i> Add Employee
                            </button>
                            <button id="btn__openModalGroupList" class="btn btn-sm btn-primary w-auto mb-2 mr-5 hidden" type="button" data-tw-toggle="modal" data-tw-target="#addGroups">
                                <i class="fa fa-users-cog w-4 h-4 mr-2 release_icon"></i> Add Groups
                            </button>
                            <button id="btn__openModalRCList" class="btn btn-sm btn-primary w-auto mb-2 mr-5 hidden" type="button" data-tw-toggle="modal" data-tw-target="#addRC">
                                <i class="fa fa-briefcase w-4 h-4 mr-2 release_icon"></i> Add RC
                            </button>
                            <div id="div__modalEndTrail" class="form-check form-switch flex flex-col items-start mt-1 hidden">
                                <label for="post-form-5" class="form-check-label ml-0 mb-2 mr-5">Mark as End of Trail</label>
                                <input id="btn__modalEndTrail" name="btn__modalEndTrail" class="form-check-input sendToAll" type="checkbox" value="1">
                            </div>
                        </div>
                        <div id="div__track_list" class="w-full border px-3 py-2 hidden">
                            <ul id="track_table">
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Modal Body -->

            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-auto mb-2">Cancel</button>
                <button id="btn_FastRelease" class="btn btn-primary w-auto mb-2 btn_release" type="button">Release
{{--                    <i class="fa fa-paper-plane w-4 h-4 mr-2 release_icon"></i>Release--}}
                </button>

                <button id="btn_TrailRelease" class="btn btn-primary w-auto mb-2 hidden" type="button">Release
{{--                    <i class="fa fa-paper-plane w-4 h-4 mr-2 release_icon"></i>Release--}}
                </button>
                <button id="btn_Test" class="btn btn-primary w-auto mb-2 hidden" type="button">
                    <i class="fa fa-paper-plane w-4 h-4 mr-2"></i> Test
                </button>
            </div>
            <!-- END: Modal Footer -->
        </form>
    </div>
</div>

<!-- BEGIN: Overlapping Employee Modal Content -->
<div id="addEmps" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Search Employee</h2>
                <div class="text-center">
                    <a href="javascript:;" data-tw-dismiss="modal" class="btn btn-primary">Close</a>
                </div>
            </div>
            <div class="overflow-x-auto scrollbar-hidden p-5">
                <table id="dt__employeeList" class="table table-report -mt-2 table-hover">
                    <thead>
                    <tr>
                        <th class="text-center whitespace-nowrap ">Agency ID</th>
                        <th class="text-center whitespace-nowrap ">Employee Name</th>
                        <th class="text-center whitespace-nowrap ">Action</th>

                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- END: Overlapping Employee Modal Content -->

<!-- BEGIN: Overlapping Groups Modal Content -->
<div id="addGroups" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Search Groups</h2>
                <div class="text-center">
                    <a href="javascript:;" data-tw-dismiss="modal" class="btn btn-primary">Close</a>
                </div>
            </div>
            <div class="overflow-x-auto scrollbar-hidden p-5">
                <table id="dt__groupList" class="table table-report -mt-2 table-hover">
                    <thead>
                    <tr>
                        <th class="text-center whitespace-nowrap ">Group Name</th>
                        <th class="text-center whitespace-nowrap ">Head</th>
                        <th class="text-center whitespace-nowrap ">Action</th>

                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- END: Overlapping Groups Modal Content -->

<!-- BEGIN: Overlapping RC Modal Content -->
<div id="addRC" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Search Responsibility Center</h2>
                <div class="text-center">
                    <a href="javascript:;" data-tw-dismiss="modal" class="btn btn-primary">Close</a>
                </div>
            </div>
            <div class="overflow-x-auto scrollbar-hidden p-5">
                <table id="dt__rcList" class="table table-report -mt-2 table-hover">
                    <thead>
                    <tr>
                        <th class="text-center whitespace-nowrap ">Name</th>
                        <th class="text-center whitespace-nowrap ">Descriptions</th>
                        <th class="text-center whitespace-nowrap ">Department</th>
                        <th class="text-center whitespace-nowrap ">Head</th>
                        <th class="text-center whitespace-nowrap ">Action</th>

                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- END: Overlapping Groups Modal Content -->

<!-- BEGIN: Forward Docs Modal Content -->
<div id="forward_Docs" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form class="modal-content" method="post">
        @csrf
        <!-- BEGIN: Modal Header -->
            <div class="modal-header flex items-center justify-center">
                <h2 class="font-medium text-base mr-auto">Forward Document</h2>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body">
                <div class="grid grid-cols-3 mt-2">
                    <div class="mr-2">
                        <label for="modal-form-1" class="form-label">Tracking Number</label>
                        <input id="forward_DocCode" disabled name="forward_DocCode" type="text" class="form-control">
                    </div>
                    <div>
                        <label for="modal-form-1" class="form-label">Expected Receive Date</label>
                        <div class="relative">
                            <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400"> <i data-lucide="calendar" class="w-4 h-4"></i> </div> <input id="forward_receive_date" type="text" name="forward_receive_date" class="datepicker form-control pl-12" data-single-mode="true">
                        </div>
                    </div>
                </div>

            @if (Auth::check())
                <!-- BEGIN: Send as Select -->
                    <div class="mt-5 mb-5"> <label>Forward as</label>
                        <div >
                            <select id="doc_forwardAs" data-placeholder="Select..." class="tom-select w-full" required>

                                <option data-ass-type="user" value="{{ Auth::user()->employee }}">{{ loaduser(Auth::user()->employee)->getUserinfo->firstname }} {{ loaduser(Auth::user()->employee)->getUserinfo->lastname }}</option>


                                @forelse (getAssignmetsHrdetails() as $hr)
                                    @if($hr->getPosition)
                                        <option data-ass-type="position" value="{{ $hr->getPosition->id }}">{{ $hr->getPosition->emp_position  }}</option>
                                    @endif
                                    @if($hr->getDesig)
                                        <option data-ass-type="desig" value="{{ $hr->getDesig->id }}">{{ $hr->getDesig->userauthority  }}</option>
                                    @endif
                                @empty

                                @endforelse

                                @forelse (getAssignmets()->where('type','rc')->groupBy('type_id') as $id => $rc)
                                    @forelse ($rc as $rcdet)
                                        @if($rcdet->getOffice)
                                            <option data-ass-type="rc" value="{{ $rcdet->getOffice->responid }}">{{  $rcdet->getOffice->centername  }}</option>
                                        @endif

                                    @empty

                                    @endforelse
                                @empty

                                @endforelse

                                @forelse (getAssignmets()->where('type','group')->groupBy('type_id') as $id => $group)
                                    @forelse ($group as $groupdet)
                                        @if ($groupdet->getGroup)
                                            <option data-ass-type="group" value="{{ $groupdet->getGroup->id }}">{{ $groupdet->getGroup->name }}</option>
                                        @else

                                        @endif
                                    @empty

                                    @endforelse
                                @empty

                                @endforelse

                            </select>
                        </div>
                    </div>
            @endif

            <!-- END: Send as Select -->
                <div class="col-span-12 sm:col-span-6">
                    <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Note</label>
                    <textarea style="height: 100px" id="send_note" class="form-control" name="send_note" placeholder="Type your note...."></textarea>
                </div>

                <div class="mt-2 sendToEmployee">
                    <label class="form-label mt-2">Forward to Employees</label>
                    <div style="position: relative">
                        <select class="forward-select2-multiple w-full" multiple="multiple" id="forward_emp_List">
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
            </div>
            <!-- END: Modal Body -->

            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-auto mb-3">Cancel</button>
                <button id="btn_Forward" class="btn btn-primary w-auto mb-2 btn_release" type="button">Forward</button>
            </div>
            <!-- END: Modal Footer -->
        </form>
    </div>
</div>
<!-- END: Forward Docs Modal Content -->

<!-- BEGIN: QR Preview Modal Content -->
<div id="QR_preview" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <form class="modal-content" method="post">
            <a id="btn_closeQRModal" data-tw-dismiss="modal"><i class="fa-regular fa-circle-xmark w-4 h-4 mr-2 text-primary"></i></a>
        @csrf
        <!-- BEGIN: Modal Header -->
            <div class="modal-header flex items-center justify-center">
                <h2 class="font-medium text-base mr-auto">QR Preview</h2>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body">
                <div class="intro-y col-span-12 md:col-span-6 lg:col-span-4 xl:col-span-3">
                    <div class="box">
                        <div class="p-5">
                            <div class="h-40 2xl:h-56 image-fit rounded-md overflow-hidden">
                                <div id="myQR" class="flex justify-center rounded-md"></div>
                            </div>
                            <div id="trackingNumber">Tracking Number:</div>
                            <div>Recipient: </div>
                            <div>Status: </div>
                        </div>
                        <div class="flex justify-center lg:justify-end items-center p-5 border-t border-slate-200/60 dark:border-darkmode-400">
                            <a class="flex items-center text-primary mr-auto" href="javascript:;"> <i class="fa fa-map-marked w-4 h-4 mr-2 text-primary"></i> Track </a>
                            <a id="print_QR" class="flex items-center mr-3" href="#" target="_blank"> <i class="fa fa-print w-4 h-4 mr-2 text-primary"></i> Print </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Modal Body -->
        </form>
    </div>
</div>
<!-- END: QR Preview Modal Content -->
