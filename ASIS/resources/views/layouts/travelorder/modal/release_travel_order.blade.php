<!-- Add Documents Modal -->
<div id="release_travel_order_modal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="form_createDocs"  method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="alert alert-danger" style="display:none"></div>
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Release Travel Order</h2>
                </div>
                <!-- END: Modal Header -->

                <!-- BEGIN: Modal Body -->

                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <input hidden id="modal_release_to_id" type="text" class="form-control" placeholder="id">

                    <div class="col-span-12 sm:col-span-12">
                        @if (Auth::check())
                            <!-- BEGIN: Send as Select -->
                            <div class="mt-5 mb-5"> <label>Release as</label>
                                <div >
                                    <select id="doc_sendAs" data-placeholder="Select..." class="tom-select w-full" required>

                                        <option data-ass-type="user" value="{{ Auth::user()->employee }}">{{ loaduser(Auth::user()->employee)->getUserinfo->firstname }} {{ loaduser(Auth::user()->employee)->getUserinfo->lastname }}</option>

                                        @forelse (getAssignmetsHrdetails() as $hr)
                                            @if ($hr->getPosition)
                                                <option data-ass-type="position" value="{{ $hr->getPosition->id }}">{{ $hr->getPosition->emp_position  }}</option>
                                            @endif

                                            @if($hr->getDesig)
                                                <option data-ass-type="desig" value="{{ $hr->getDesig->id }}">{{ $hr->getDesig->userauthority  }}</option>
                                            @endif
                                        @empty

                                        @endforelse

                                        @forelse (getAssignmets()->where('type','rc')->groupBy('type_id') as $id => $rc)
                                            @forelse ($rc as $rcdet)
                                                @if ($rcdet->getOffice)
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
                    </div>

                    <div class="col-span-12 sm:col-span-12">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Message</label>
                        <textarea style="height: 100px" id="message" class="form-control" name="message" placeholder="Type your message...." ></textarea>
                    </div>

                    <div class="col-span-12 sm:col-span-12">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Trail Release to </label>
                        <table class="table sig_modal_table_modal">
                            <thead>
                                <tr>

                                    <th >User ID</th>
                                    <th >Name</th>
                                    <th >Description</th>

                                </tr>
                            </thead>
                            <tbody>
                            </tbody>

                        </table>
                    </div>
                </div>
                <!-- END: Modal Body -->


                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button id="cancel_documents_btn" type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                    <a href="javascript:;" id="btn_release_travel_order_modal" class="btn btn-primary w-20 "> Release </a>
                </div>
                <!-- END: Modal Footer -->
            </div>
        </form>
    </div>
</div>
<!-- END: Modal Content -->
