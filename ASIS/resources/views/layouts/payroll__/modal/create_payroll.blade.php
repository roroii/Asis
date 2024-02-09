{{--modal for user priv--}}
<div id="modal_create_new_payroll" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">
                    New Payroll
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

                    <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-1" class="form-label">From Date</label>
                        <input id="modal_departure_date" type="date" class="form-control" placeholder="From Date">
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-2" class="form-label">To Date</label>
                        <input id="modal_return_date" type="date" class="form-control" placeholder="To Date">
                    </div>

                    <div class="col-span-12 sm:col-span-12">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Payment Type</label>
                        <select class="w-full"id="pos_des">



                        </select>
                    </div>

                    <div class="col-span-12 sm:col-span-12">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Employee </label>
                        <select class="w-full"id="pos_des">



                        </select>
                    </div>

                    <div class="col-span-12 sm:col-span-12">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Employee in Payroll</label>

                            <div class="col-span-12 sm:col-span-12">
                                <div class="overflow-x-auto">
                                    <table id="dt__user_priv" class="table table-report  table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="display: none"><div class="flex"><span > ID</span> </div></th>

                                                <th><input class="form-check-input selectall_Print ml-3" type="checkbox" value="" ><span class="ml-3"> Employee</span></th>
                                                <th class="text-center"><div class="flex"><span > Amount</span> </div></th>
                                                <th class="text-center"><div class="flex"><span > Action</span> </div></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                    </div>

                    <div class="col-span-12 sm:col-span-12">
                        <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row"> Signatories </label>
                        <table class="table sig_modal_table">
                            <thead>
                                <tr>

                                    <th >User ID</th>
                                    <th >Name</th>
                                    <th >Description</th>
                                    <th >Action</th>

                                </tr>
                            </thead>
                            <tbody>
                            </tbody>

                        </table>
                    </div>


                    <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-1" class="form-label">Employees</label>
                        <select class="w-full"  id="trav_emp_list">
                            <option ></option>
                            @forelse (loaduser('') as $users)
                                @if ($users->getUserinfo)
                                    <option value="{{ $users->employee }}">{{ $users->getUserinfo->firstname }} {{ $users->getUserinfo->lastname }}</option>
                                @else
                                @endif
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-2" class="form-label">Employee Extension</label>
                        <input id="sd_modal_" type="text" class="form-control" placeholder="Description">
                    </div>
                    <div class="col-span-12 sm:col-span-12">
                        <label for="modal-form-2" class="form-label">Signatory Description</label>
                        <input id="sd_modal_" type="text" class="form-control" placeholder="Description">
                    </div>
                    <a href="javascript:;" id="add_row_signatories" class="ml-auto text-primary truncate flex items-center"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="plus" data-lucide="plus" class="lucide lucide-plus w-4 h-4 mr-1"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Add </a>



                </div> <!-- END: Modal Body -->
                <!-- END: Modal Body -->
                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                    <a id="update_user_priv_modal_save" href="javascript:;" class="btn btn-primary w-20">Save <i data-lucide="save" style="color: rgb(255, 255, 255)" class="w-4 h-4 text-slate-500 ml-auto"></i></a>
                </div>
            </form>
            <!-- END: Modal Footer -->
        </div>
    </div>
</div>
