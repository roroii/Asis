


<!-- BEGIN: Overlapping Groups Modal Content -->
<div id="modal_scan_action" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-s">
        <form id="form_add_note" class="modal-content" method="post">
            @csrf
            <!-- BEGIN: Modal Header -->
            <div class="modal-header flex items-center justify-center">
                <h2 id="modal_title_text" class="font-medium text-base mr-auto"></h2>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body">




            <div class="intro-y col-span-12 md:col-span-6 lg:col-span-4">
                <div class=" text-center">
                    <div class="flex pt-5">
                        <div class="w-full flex flex-col lg:flex-row items-center">
                            <div class="lg:ml-4 text-center lg:text-left mt-3 lg:mt-0">
                            <div class="text-slate-500 text-xs mt-0.5">Track Number</div>
                                <a href="javascript:;" class="font-medium"> <label id="model_track_number"></label> </a>
                                <input hidden id="model_track_number_inp" type="text" >
                            </div>
                        </div>
                    </div>
                    <div class="text-center lg:text-left p-5">
                        <div class="text-slate-500 text-xs mt-2">Title</div>
                        <div class="font-medium"><label id="model_document_name"></label></div>
                        <div class="text-slate-500 text-xs mt-2">Description</div>
                        <div class=""><label id="model_document_desc"></label></div>

                        @if (Auth::check())
                            <!-- BEGIN: Send as Select -->
                            <div class="mt-5 mb-5"> <label id="model_document_as"></label>
                                <div >
                                    <select id="model_as" data-placeholder="Select..." class="tom-select w-full" required>

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
                        <div class="form-check form-switch flex flex-col items-start text-slate-500 mt-2 mt-3">
                        <label  class="text-slate-500 text-xs mt-0.5">Note</label>
                            <textarea id="modal_message" class="form-control modal_message mt-1 zoom-in" name="modal_message" placeholder="Add a message" value=""></textarea>
                        </div>

                        <div class="form-check form-switch flex flex-col items-start text-slate-500 mt-2 mt-3">
                            <label  class="text-slate-500 text-xs mt-0.5">From (has official ID)</label>
                            <input autocomplete="off" id="modal_scan_id_from" autofocus type="text" class="form-control py-3 px-4 w-full bg-slate-100 border-slate-200/60 pr-10" placeholder="Scan official ID (Optional)"></input>
                        </div>
                        <div class="mt-10 sendToEmployee">
                            <label id="model_document_from"></label>
                            <div style="position: relative">
                                <select class="select2 w-full" required multiple id="scan_emp_List">
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

                        <div hidden class="form-check form-switch flex flex-col items-start text-slate-500 mt-2 mt-3">
                            <input hidden id="modal_action" autofocus type="text" class="form-control py-3 px-4 w-full bg-slate-100 border-slate-200/60 pr-10" placeholder="">
                        </div>
                    </div>

                </div>
            </div>

            </div>
            <!-- END: Modal Body -->

            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">

                <a data-tw-dismiss="modal" class="btn btn-outline-secondary w-auto mb-2" href="javascript:;">
                    Cancel
                </a>
                <a id="modal_action_btn" data-note-type="important_notes" class="btn btn-primary w-auto mb-2" href="javascript:;">
                    Receive
                </a>
            </div>
            <!-- END: Modal Footer -->
        </form>
    </div>
</div>
<!-- END: Overlapping Groups Modal Content -->
