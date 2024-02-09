 <!-- BEGIN: Modal Content -->
 <div id="arias_modal" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 id="criters_name" class="font-bold text-base mr-auto">Manage Areas</h2>
                <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>
                    <div class="dropdown-menu w-40">
                        <ul class="dropdown-content">
                            <li> <a href="javascript:;" class="dropdown-item"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Add Area</a> </li>
                        </ul>
                    </div>
                </div>
            </div> <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body">
                <form id="area_form" enctype="multipart/form-data">
                    @csrf
                    <input id="crit_id" name="critID" type="hidden">
                    <input id="crit_max" name="crit_max" type="hidden">
                    <input id="competency_id" name="competency_id" type="hidden">
                    <div class="intro-y block sm:flex items-center h-10 ">
                        <a name="add_more" id="add_more" class="ml-auto mr-5 cursor-pointer"><i class="fa fa-plus w-3 h-3 mr-1 text-primary"></i>Add Row</a>
                    </div>
                    <table id="addArea_table" class="table table-bordered form-control">
                        <tr>
                                <th style = "width: 70%">Area</th>
                                <th>Points</th>
                                <th>Action</th>
                        </tr>

                    </table>
                    <div class="flex mt-5">
                        <label for="">Maximum Points: </label>&nbsp;
                        <label id="crit_max_points" for="" class="mr-20"></label>
                        <label for="" class="ml-auto">Input Points: </label>&nbsp;
                        <label id="input_points" for="" class="mr-20">0</label>
                    </div>



                    {{-- <div id="m_body" class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                        <input id="crit_id" name="critID" type="hidden">

                        <div id="areas_div" class="col-span-12 sm:col-span-12"> <label for="modal-form-5" class="form-label font-medium">Add Areas</label>

                            <div class="flex justify-center items-center">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 ml-2 text-slate-400 zoom-in" title="Add Row">
                                    <a id="addRow" class="flex justify-center items-center addArea" href="javascript:;"> <i class="fa fa-plus items-center text-center text-success"></i> </a>

                                    <div class="dropdown-menu w-40">

                                    </div>

                                </div>
                                <input type="text" name="areas_c" id="areas_c" class="form-control" placeholder="Enter Area">


                            </div>


                        </div>

                    </div> --}}

                        <!-- END: Modal Body -->

                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" id="btn_cancel" href="javascript:;" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                        <button type="submit" id="btn_save" href="javascript:;" class="btn btn-primary w-20">Save</button>
                    </div>
                    <!-- END: Modal Footer -->
                </form>
            </div>
        </div>
    </div>
</div>  <!-- END: Modal Content -->


