<!-- Add Documents Modal -->
<div id="lingking_agency_esms_modal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="form_createDocs"  method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="alert alert-danger" style="display:none"></div>
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Agency/e-SMS</h2>
                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">

                    <div class="col-span-12 sm:col-span-12">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Faculty</label>
                        <select class="w-full" id="esms_faculty"  data-placeholder="Faculty" >
                            <option value=""></option>
                            @forelse (load_esms_profiles('') as $esms_faculty)
                                <option value="{{ $esms_faculty->empid }}">{{ $esms_faculty->fullname }}</option>
                            @empty

                            @endforelse
                        </select>
                    </div>
                    <div class="col-span-12 sm:col-span-12">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Agency Employee</label>
                        <select class="w-full" id="agency_employee"  data-placeholder="Employee" >
                            <option value=""></option>
                            @forelse (loaduser('') as $users)
                                @if ($users->getUserinfo)
                                    <option value="{{ $users->employee }}">{{ $users->getUserinfo->firstname }} {{ $users->getUserinfo->lastname }}</option>
                                @else
                                @endif
                            @empty
                            @endforelse
                        </select>
                    </div>

                    <div class="col-span-12 sm:col-span-12">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Linked Data </label>
                        <div class="overflow-x-auto scrollbar-hidden pb-10">
                        <table id="dt__linked_data" class="table table-report -mt-2 table-hover">
                            <thead>
                            <tr>
                                <th class="text-center whitespace-nowrap"> Full Name </th>
                                <th class="text-center whitespace-nowrap"> Faculty </th>
                                <th class="text-center whitespace-nowrap"> Faculty ID </th>
                                <th class="text-center whitespace-nowrap"> Agency </th>
                                <th class="text-center whitespace-nowrap"> Agency ID </th>
                                <th> Action </th>
                            </tr>
                            </thead>
                            <tbody>


                            </tbody>
                        </table>
                        </div>
                    </div>


                </div>

                <!-- END: Modal Body -->

                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                    <a href="javascript:;" id="add_new_linking_btn" class="btn btn-primary w-20 add_new_linking_btn"> Save </a>
                    {{-- <button id="add_travel_order" class="btn btn-primary w-20 add_travel_order">Save</button> --}}
                </div>
                <!-- END: Modal Footer -->
            </div>
        </form>
    </div>
</div>
<!-- END: Modal Content -->
