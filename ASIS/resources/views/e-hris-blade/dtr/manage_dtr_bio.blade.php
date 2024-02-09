@extends('layouts.app')

@section('content')
    <h2 class="intro-y text-lg font-medium mt-10">
        
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <!--<button class="btn btn-primary shadow-md mr-2 b_action" data-type="action" data-target="show-add">Add New Skill</button>-->
        </div>


        <div class="intro-y box col-span-12 2xl:col-span-6">
            <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base mr-auto">
                    Manage Biometric
                </h2>
            </div>
            <div class="p-5 pb-10">


                <div class="form-inline">
                    <div class="input-group">
                        <div id="" class="input-group-text cursor-pointer"><i data-lucide="user"></i></div>
                        <input type="hidden" id="su-id" readonly>
                        <input type="text" id="su-name" class="form-control cursor-pointer bg-white input_action" style="cursor: pointer; background: white;" placeholder="" aria-label="" aria-describedby="" data-type="action" data-target="show-users-select" readonly>
                    </div>
                </div>

                <div id="suc_dev_status" class="mt-4">
                    <div id="suc_dev_status_error" class="alert alert-outline-danger alert-dismissible show flex items-center mb-2 hidden" role="alert"> <i data-lucide="alert-octagon" class="w-6 h-6 mr-2"></i> No Biometric device detected. </div>
                </div>

                <div id="suc_msgs" class="mt-4">
                    
                    <div class="alert alert-outline-danger alert-dismissible show flex items-center mb-2" role="alert"> <i data-lucide="alert-octagon" class="w-6 h-6 mr-2"></i> No fingerprint data detected. </div>

                </div>

                <div id="btn-h-2" class="mt-2">
                </div>
                <div id="btn-h-1" class="mt-2">
                    <button class="btn btn-primary shadow-md mr-2 b_action" data-type="action" data-target="dev-fp-mode-set-register">Register Fingerprint</button>
                    <button class="btn btn-primary shadow-md mr-2 b_action" data-type="action" data-target="dev-fp-data-sync-to-local">Sync Fingerprint To Local</button>
                </div>

                <div id="btn-h-3" class="mt-2 pt-4">
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
        <div id="mdl__fp_verify_success" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-body p-0">

                        <div class="p-5 text-center"> <i class="fas fa-check-double w-16 h-16 text-success mx-auto mt-3"></i>
                            <div id="ttl-verify-success" class="text-3xl mt-5 capitalize"></div>
                            <div id="lbl-verify-success-details" class="text-slate-500 mt-2 capitalize">Verification successful.</div>
                        </div>
                        <div class="px-5 pb-8 text-center"> <button type="button" href="javascript:;" class="btn btn-outline-secondary w-24 mr-1 b_action" data-type="action" data-target="fp-verify-success-cancel">Close</button> </div>
                    </div>

                </div>
            </div>
        </div>  <!-- END: Modal Content -->

        <!-- BEGIN: Modal Content -->
        <div id="mdl__fp_verify_error" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-body p-0">

                        <div class="p-5 text-center"> <i class="far fa-times-circle w-16 h-16 text-danger mx-auto mt-3"></i>
                            <div id="ttl-verify-error" class="text-3xl mt-5 capitalize"></div>
                            <div id="lbl-verify-error-details" class="text-slate-500 mt-2 ">Unable to verify.</div>
                        </div>
                        <div class="px-5 pb-8 text-center"> <button type="button" href="javascript:;" class="btn btn-outline-secondary w-24 mr-1 b_action" data-type="action" data-target="fp-verify-error-cancel">Close</button> </div>
                    </div>

                </div>
            </div>
        </div>  <!-- END: Modal Content -->






@endsection

@section('scripts')
    <script src="{{BASEPATH()}}/js/bioengine/bioengine.js{{GET_RES_TIMESTAMP()}}"></script>
    <script src="{{BASEPATH()}}/js/dtr/manage_bio.js{{GET_RES_TIMESTAMP()}}"></script>
@endsection()
