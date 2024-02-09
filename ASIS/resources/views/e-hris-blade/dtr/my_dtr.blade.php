@extends('layouts.app')

@section('content')

    <div class="grid grid-cols-12 gap-6 mt-5">
        
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <!--<button class="btn btn-primary shadow-md mr-2 b_action" data-type="action" data-target="show-add">Add New Skill</button>-->
        </div>


        <div class="intro-y box col-span-12 2xl:col-span-6">
            <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base mr-auto">
                    DTR
                </h2>
            </div>
            <div class="p-5 pb-10">

                <div class="grid grid-cols-12 gap-2">
                    <div class="col-span-3">
                        <div class="mb-5">
                            <label for="details"> From </label>
                            <input type="date" id="date_from" name="date_from" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="col-span-3">
                        <div class="mb-5">
                            <label for="details"> To </label>
                            <input type="date" id="date_to" name="date_to" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="col-span-3">
                        <div class="mb-5" style="padding-top: 20px;">
                            <button class="btn btn-primary shadow-md mr-2 b_action" data-type="action" data-target="load-dtr">Load</button>
                            <div class="dropdown inline-block" data-tw-placement="bottom-start"> <button class="dropdown-toggle btn btn-primary" aria-expanded="false" data-tw-toggle="dropdown">Print</button>
                                <div class="dropdown-menu">
                                    <ul class="dropdown-content" style="width: 180px;">
                                        <li> <a href="javascript:;" class="dropdown-item b_action" data-type="action" data-target="print-dtr"><i data-lucide="printer" class="w-4 h-4 mr-2"></i> CSC Form No. 48</a> </li>
                                        <li> <a href="javascript:;" class="dropdown-item b_action" data-type="action" data-target="print-dtr-w-remarks"><i data-lucide="printer" class="w-4 h-4 mr-2"></i> CSC Form No. 48 with Remarks</a> </li>
                                        <li> <a href="javascript:;" class="dropdown-item b_action" data-type="action" data-target="print-dtr-w-total"><i data-lucide="printer" class="w-4 h-4 mr-2"></i> CSC Form No. 48 with Total</a> </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div>

                    <div class="overflow-x-auto">
                        <table class="table table-bordered" style="max-width: 440px; min-width: 440px;">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="whitespace-nowrap text-center" style="max-width: 50px; width: 50px;"></th>
                                    <th colspan="2" class="whitespace-nowrap text-center">AM</th>
                                    <th colspan="2" class="whitespace-nowrap text-center">PM</th>
                                </tr>
                                <tr>
                                    <th colspan="1" class="whitespace-nowrap text-center">IN</th>
                                    <th colspan="1" class="whitespace-nowrap text-center">OUT</th>
                                    <th colspan="1" class="whitespace-nowrap text-center">IN</th>
                                    <th colspan="1" class="whitespace-nowrap text-center">OUT</th>
                                </tr>
                            </thead>
                            <tbody id="dtr-data">
                                <tr>
                                    <td>1</td>
                                    <td>00:00:00</td>
                                    <td>00:00:00</td>
                                    <td>00:00:00</td>
                                    <td>00:00:00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                </div>


            </div>
        </div>


    </div>



    <!-- BEGIN: Modal Content -->
    <div id="mdl__users__select" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 id="" class="font-bold text-base mr-auto">Select Employee</h2>

                </div> <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->

                <div class="modal-body px-5 py-10">
                    <div>

                        <div class="intro-y col-span-12 overflow-x-auto scrollbar-hidden overflow-auto pb-2">
                                <table id="dt_users_select" class="table table-report -mt-2" style="width: 100%;">
                                    <thead>
                                    <tr>
                                        <th class="hidden"></th>
                                        <th class="" style="width: 100px; max-width: 100px;">ID</th>
                                        <th class="whitespace-nowrap"></th>
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
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Close</button>
                </div>
                <!-- END: Modal Footer -->

            </div>
        </div>
    </div>  <!-- END: Modal Content -->



    <!-- BEGIN: Modal Content -->
    <div id="mdl__fp_register" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 id="" class="font-bold text-base mr-auto">Register Fingerprint</h2>

                </div> <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->

                <div class="modal-body px-5 py-10">
                    <div>

                        <div id="fp-reg-features-ui" class="mb-5" align="center">

                        </div>

                        <div id="fp-reg-msg" class="" style="min-width: 20px;" align="center">
                            Put your finger on the fingerprint device.
                        </div>

                    </div>
                </div>
                    <!-- END: Modal Body -->

                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button type="button" href="javascript:;" class="btn btn-outline-secondary w-20 mr-1 b_action" data-type="action" data-target="fp-register-cancel">Cancel</button>
                </div>
                <!-- END: Modal Footer -->

            </div>
        </div>
    </div>  <!-- END: Modal Content -->

    <!-- BEGIN: Modal Content -->
    <div id="mdl__fp_verify" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 id="" class="font-bold text-base mr-auto">Verification</h2>

                </div> <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->

                <div class="modal-body px-5 py-10">
                    <div>

                        <div id="fp-verify-features-ui" class="mb-5" align="center">

                        </div>

                        <div id="fp-verify-msg" class="" style="min-width: 20px;" align="center">
                            Put your finger on the fingerprint device.
                        </div>

                    </div>
                </div>
                    <!-- END: Modal Body -->

                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button type="button" href="javascript:;" class="btn btn-outline-secondary w-20 mr-1 b_action" data-type="action" data-target="fp-verify-cancel">Cancel</button>
                </div>
                <!-- END: Modal Footer -->

            </div>
        </div>
    </div>  <!-- END: Modal Content -->



    <!-- BEGIN: Modal Content -->
    <div id="mdl__add" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 id="" class="font-bold text-base mr-auto">Add Skill</h2>

                </div> <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->

                <div class="modal-body px-5 py-10">
                    <div>

                        <div class="mb-5">
                            <label for="name"> Skill </label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="">
                        </div>

                        <div class="mb-5">
                            <label for="details"> Description (Optional)</label>
                            <input type="text" id="details" name="details" class="form-control" placeholder="">
                        </div>
                        
                        <div class="mb-5">
                            <label for="points"> Default Point(s) (Optional)</label>
                            <input type="number" id="points" name="points" min="0" class="form-control" placeholder="">
                        </div>
                        
                    </div>
                </div>
                    <!-- END: Modal Body -->

                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                    <button type="button" href="javascript:;" class="btn btn-primary w-20 b_action" data-type="action" data-target="data-add">Save</button>
                </div>
                <!-- END: Modal Footer -->

            </div>
        </div>
    </div>  <!-- END: Modal Content -->

    <!-- BEGIN: Modal Content -->
    <div id="mdl__update" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 id="" class="font-bold text-base mr-auto">Add Skill</h2>

                </div> <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->

                <div class="modal-body px-5 py-10">
                    <div>

                        <input type="hidden" id="upd_id" name="id" value="" hidden readonly />

                        <div class="mb-5">
                            <label for="name"> Skill </label>
                            <input type="text" id="upd_name" name="name" class="form-control" placeholder="">
                        </div>

                        <div class="mb-5">
                            <label for="details"> Description (Optional)</label>
                            <input type="text" id="upd_details" name="details" class="form-control" placeholder="">
                        </div>
                        
                        <div class="mb-5">
                            <label for="points"> Default Point(s) (Optional)</label>
                            <input type="number" id="upd_points" name="points" min="0" class="form-control" placeholder="">
                        </div>
                        
                    </div>
                </div>
                    <!-- END: Modal Body -->

                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                    <button type="button" href="javascript:;" class="btn btn-primary w-20 b_action" data-type="action" data-target="data-update">Save</button>
                </div>
                <!-- END: Modal Footer -->

            </div>
        </div>
    </div>  <!-- END: Modal Content -->

    <!-- BEGIN: Modal Content -->
    <div id="mdl__delete" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-body p-0">

                    <input type="hidden" id="del_id" name="id" value="" hidden readonly />

                    <div class="p-5 text-center"> <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Are you sure?</div>
                        <div class="text-slate-500 mt-2">Do you really want to delete this record? <br>This process cannot be undone.</div>
                    </div>
                    <div class="px-5 pb-8 text-center"> <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button> <button type="button" class="btn btn-danger w-24 b_action" data-type="action" data-target="data-delete">Delete</button> </div>
                </div>

            </div>
        </div>
    </div>  <!-- END: Modal Content -->




@endsection

@section('scripts')
    <script src="{{BASEPATH()}}/js/dtr/my_dtr.js{{GET_RES_TIMESTAMP()}}"></script>
@endsection()
