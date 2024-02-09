@extends('layouts.app')

@section('content')
    <h2 class="intro-y text-lg font-medium mt-10">
        
    </h2>

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 2xl:col-span-9">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-8">
                    <div class="intro-y flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            Overview
                        </h2>
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-lucide="printer" class="report-box__icon text-primary"></i> 
                                        <div class="ml-auto">
                                            <div class="report-box__indicator bg-success cursor-pointer" style="min-width: 30px; min-height: 20px;" title="">  </div>
                                        </div>
                                    </div>
                                    <div id="stats_printed_total" class="text-3xl font-medium leading-8 mt-6">0</div>
                                    <div class="text-base text-slate-500 mt-1 fs_c_4">Total Request</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-lucide="printer" class="report-box__icon text-success"></i> 
                                        <div class="ml-auto">
                                            <div class="report-box__indicator bg-success cursor-pointer" style="min-width: 30px; min-height: 20px;" title="">  </div>
                                        </div>
                                    </div>
                                    <div id="stats_printed_current" class="text-3xl font-medium leading-8 mt-6">0</div>
                                    <div class="text-base text-slate-500 mt-1 fs_c_4">Vehicle Request</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <!--<button class="btn btn-primary shadow-md mr-2 b_action" data-type="action" data-target="show-add">Add New Skill</button>-->
        </div>


        <div class="intro-y box col-span-12 2xl:col-span-12">

            <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base mr-auto">
                    Callendar
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

                        </div>
                    </div>
                </div>


                <div>
                    
                    <div id="zcalendar"></div>

                    <br/>
                    <br/>
                    
                </div>


                <div>


                </div>


            </div>
        </div>


    </div>



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
    <script src="{{BASEPATH()}}/assets/mycalendar/calendar.js{{GET_RES_TIMESTAMP()}}"></script>
    <script src="{{BASEPATH()}}/js/request/overview.js{{GET_RES_TIMESTAMP()}}"></script>
@endsection()
