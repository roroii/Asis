<!-- Add Documents Modal -->
<div id="make_travel_order_modal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="form_createDocs"  method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="alert alert-danger" style="display:none"></div>
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Travel Order</h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->


                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <input hidden id="modal_update_to_id" type="text" class="form-control" placeholder="id">

                    <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-1" class="form-label">Members</label>
                        <select class="w-full multiple" id="name_modal"  data-placeholder="Select Persons" multiple>
                            <option selected data-ass-type="user" value="{{ Auth::user()->employee }}">{{ loaduser(Auth::user()->employee)->getUserinfo->firstname }} {{ loaduser(Auth::user()->employee)->getUserinfo->lastname }}</option>
                            @forelse (load_profile('') as $profile)
                                @if ($profile)
                                    <option value="{{ $profile->agencyid }}">{{ $profile->firstname }} {{ $profile->lastname }}</option>
                                @else

                                @endif
                            @empty

                            @endforelse
                        </select>
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-2" class="form-label">Date</label>
                        <input id="modal_date_now" type="date" class="form-control" value="<?php echo ('yyyy-MM-dd')?>">
                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-1" class="form-label">Departure Date</label>
                        <input id="modal_departure_date" type="date" class="form-control" placeholder="Departure Date">
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-2" class="form-label">Return Date</label>
                        <input id="modal_return_date" type="date" class="form-control" placeholder="Return Date">
                    </div>

                    <div class="col-span-12 sm:col-span-12">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Position/Designation</label>
                        <select class="w-full" id="pos_des" data-placeholder="Select Position/Designation">

                            @forelse (getAssignmetsHrdetails() as $hr)

                                @if($hr->getDesig)
                                    <option data-ass-type="desig" value="{{ $hr->getDesig->id }}">{{ $hr->getDesig->userauthority  }}</option>
                                @endif

                                @if($hr->getPosition)
                                    <option data-ass-type="position" value="{{ $hr->getPosition->id }}">{{ $hr->getPosition->emp_position  }}</option>
                                @endif
                            @empty

                            @endforelse

                        </select>
                    </div>

                    <div class="col-span-12 sm:col-span-12">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Station</label>
                        <input id="modal_station" type="text" class="form-control" placeholder="Station">
                    </div>
                    <div class="col-span-12 sm:col-span-12">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Destination</label>
                        <input id="modal_destination" type="text" class="form-control" placeholder="Destination">
                    </div>

                    <div class="col-span-12 sm:col-span-12">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Purpose of Travel</label>
                        <textarea style="height: 100px" id="modal_purpose" class="form-control" name="modal_purpose" placeholder="Type your purpose...." ></textarea>
                    </div>

                    <div class="col-span-12 sm:col-span-12">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Signatories </label>
                        <table class="table sig_modal_table">
                            <thead>
                                <tr>

                                    <th style="display:none">User ID</th>
                                    <th style="display:none">Suffix</th>
                                    <th style="display:none">Signatory id</th>
                                    <th >Name</th>
                                    <th >Description</th>
                                    <th >Action</th>

                                </tr>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>
                    </div>

                    <form >
                        <div id="div_hide_if_not_pending" class="col-span-12 sm:col-span-12">

                            <div class="col-span-12 sm:col-span-12">
                                <label for="modal-form-2" class="form-label">Person List / Suffix</label>
                                <div class="input-group flex-1">
                                    <select class="w-full" id="trav_emp_list" data-placeholder="Select Person" required oninvalid="this.setCustomValidity('Please select a person and update details then click add person!')">
                                        @forelse (load_profile('') as $profile)
                                            @if ($profile)
                                                <option value="{{ $profile->agencyid }}">{{ $profile->firstname }} {{ $profile->lastname }}</option>
                                            @else

                                            @endif
                                        @empty

                                        @endforelse
                                    </select>
                                    <div><input id="sd_modal_suffix" type="text" class="form-control" placeholder="Ex. (IT.D, DBM, Ph.D)"></div>
                                </div>
                            </div>

                            <div class="col-span-12 sm:col-span-12">
                                <label for="modal-form-2" class="form-label">Signatory Description</label>
                                <textarea id="sd_modal_sd" style="height: 100px"  class="form-control" name="message" placeholder="Ex.(Recommending approval, Approved by)" > </textarea>
                            </div>
                            <button id="add_row_signatories" type="submit" class="btn ml-auto text-primary truncate flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="plus" data-lucide="plus" class="lucide lucide-plus w-4 h-4 mr-1"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Add Person</button>
                        </div>
                    </form>
                </div>

                <!-- END: Modal Body -->

                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button id="cancel_documents_btn" type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                    <a  href="javascript:;" id="add_travel_order" class="btn btn-primary w-20 add_travel_order"> Save </a>
                    {{-- <button id="add_travel_order" class="btn btn-primary w-20 add_travel_order">Save</button> --}}
                </div>
                <!-- END: Modal Footer -->
            </div>
        </form>
    </div>
</div>
<!-- END: Modal Content -->
