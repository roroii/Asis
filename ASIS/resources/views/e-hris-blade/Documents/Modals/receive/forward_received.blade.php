<!-- BEGIN: Forward Docs Modal Content -->
<div id="forward_received_Docs" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
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
                <div class="mt-2">
                    <div class="mr-2">
                        <label class="form-label">Tracking Number</label>
                        <input id="forward_received_DocCode" disabled name="forward_received_DocCode" type="text" class="form-control">
                    </div>
{{--                    <div>--}}
{{--                        <label for="modal-form-1" class="form-label">Expected Receive Date</label>--}}
{{--                        <div class="relative">--}}
{{--                            <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400"> <i data-lucide="calendar" class="w-4 h-4"></i> </div> <input id="forward_receive_date" type="text" name="forward_receive_date" class="datepicker form-control pl-12" data-single-mode="true">--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>

            @if (Auth::check())
                <!-- BEGIN: Send as Select -->
                    <div class="mt-5 mb-5"> <label>Forward as</label>
                        <div >
                            <select id="doc_received_forwardAs" data-placeholder="Select..." class="tom-select w-full" required>

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
                    <label class="form-label w-full flex flex-col sm:flex-row"> Note</label>
                    <textarea style="height: 100px" id="forward_received_note" class="form-control" name="forward_received_note" placeholder="Type your note...."></textarea>
                </div>

                <div class="mt-2 sendToEmployee">
                    <label class="form-label mt-2">Forward to Employees</label>
                    <div style="position: relative">
                        <select class="select2-multiple w-full" multiple="multiple" id="forward_received_emp_List">
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
                <button id="btn_forward_received_docs" class="btn btn-primary w-auto mb-2 btn_release" type="button">Forward</button>
            </div>
            <!-- END: Modal Footer -->
        </form>
    </div>
</div>
<!-- END: Forward Docs Modal Content -->
