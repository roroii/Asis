@extends('layouts.app')

@section('content')
    <h2 class="intro-y text-lg font-medium mt-10">
        
    </h2>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <!--<button class="btn btn-primary shadow-md mr-2 b_action" data-type="action" data-target="show-add">Add New Skill</button>-->
        </div>


        <div class="intro-y box col-span-12 2xl:col-span-12">

            <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base mr-auto">
                    Manage Biometric Data
                </h2>
            </div>
            <div class="p-5 pb-10">

                <div class="pb-5">
                    <input type="file" id="input_attlog" name="input_attlog" accept=".dat, .txt" hidden />
                    <label id="input_attlog_lbl" for="input_attlog" class="btn btn-primary shadow-md mr-2 b_action" data-type="action" data-target="show-attlog-file-select" >Upload Attendance Log</label>
                </div>


                <div class="mt-5">

                    <div id="progress-upload-h" class="font-medium" style="visibility: hidden;">
                        <div class="flex">
                            <div class="mr-auto">Uploading ' <span id="progress-upload-name"></span> ' </div>
                            <div><span id="progress-upload-percent-text">0</span>%</div>
                        </div>
                        <div class="progress h-1 mt-2">
                            <div id="progress-upload-bar" class="progress-bar bg-primary" style="width: 0%;" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <div id="status-upload-h" class="grid grid-cols-12 gap-6 mt-5" style="display: none;">
                        <div class="intro-y col-span-12 lg:col-span-6">
                            <div class="box">
                                <div class="flex flex-col sm:flex-row items-center p-5">
                                    <div class="sm:ml-2 sm:mr-auto text-center sm:text-left mt-3 sm:mt-0">
                                        <a href="javascript:;" class="font-medium"><span id="status-upload-data-count">0</span> attendance log data.</a> 
                                        <div class="text-slate-500 text-xs mt-0.5"></div>
                                        <div id="progress-upload-save-h" class="font-medium" style="visibility: visible;">
                                            <div class="flex">
                                                <div class="mr-auto"></div>
                                                <div><span id="progress-upload-save-percent-text"></span></div>
                                            </div>
                                            <div class="progress h-1 mt-2">
                                                <div id="progress-upload-save-bar" class="progress-bar bg-primary" style="width: 0%;" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex mt-4 lg:mt-0">
                                        <button id="status-upload-btn-save" class="btn btn-primary py-1 px-2 mr-2 b_action" data-type="action" data-target="show-data-upload-save-confirm"> Save Data </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


            </div>
        </div>


    </div>


    <!-- BEGIN: Modal Content -->
    <div id="mdl__attlog_upload_confirm" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 id="" class="font-bold text-base mr-auto">Upload Attendance Log</h2>

                </div> <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->

                <div class="modal-body px-5 py-10">
                    <div class="font-medium">

                        Confirm uploading attendance log '<span id="attlog_upload_confirm_name"></span>' ?

                    </div>
                </div>
                <!-- END: Modal Body -->

                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary w-20 mr-1 b_action" data-type="action" data-target="attlog-upload-cancel">Close</button>
                    <button type="button" class="btn btn-primary w-20 mr-1 b_action" data-type="action" data-target="attlog-upload-confirm">Upload</button>
                </div>
                <!-- END: Modal Footer -->

            </div>
        </div>
    </div>  <!-- END: Modal Content -->
    
    <!-- BEGIN: Modal Content -->
    <div id="mdl__attlog_upload_save_confirm" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 id="" class="font-bold text-base mr-auto">Save Attendance Log</h2>

                </div> <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->

                <div class="modal-body px-5 py-10">
                    <div class="font-medium">

                        Confirm save attendance log ?

                    </div>
                </div>
                <!-- END: Modal Body -->

                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Close</button>
                    <button type="button" class="btn btn-primary w-20 mr-1 b_action" data-type="action" data-target="attlog-upload-save-confirm">Save</button>
                </div>
                <!-- END: Modal Footer -->

            </div>
        </div>
    </div>  <!-- END: Modal Content -->
    


    <!-- BEGIN: Modal Content -->
    <div id="mdl__list_records" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 id="" class="font-bold text-base mr-auto">Records</h2>

                </div> <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->

                <div class="modal-body px-5 py-10">
                    <div>

                        <div class="intro-y col-span-12 overflow-x-auto scrollbar-hidden overflow-auto pb-2">
                                <table id="dt_records" class="table table-report -mt-2" style="width: 100%;">
                                    <thead>
                                    <tr>
                                        <th class="hidden"></th>
                                        <th class="whitespace-nowrap">Details</th>
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
    <div id="mdl__record_details" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div class="modal-header">
                    <h2 id="record-details-title" class="font-bold text-base mr-auto">Details</h2>

                </div> <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->

                <div class="modal-body px-5 py-10">
                    <div>

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
                                    <tbody id="record-data">
                                    </tbody>
                                </table>
                            </div>


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






@endsection

@section('scripts')
    <script src="{{BASEPATH()}}/js/dtr/manage_data.js{{GET_RES_TIMESTAMP()}}"></script>
@endsection()
