 <!-- BEGIN: Modal Content -->
 <div id="ratingArias_modal" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 id="criteria_name" class="font-bold text-base mr-auto">Rate Areas</h2>
                <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>
                    <div class="dropdown-menu w-40">
                        <ul class="dropdown-content">
                            <li> <a href="javascript:;" class="dropdown-item"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Add Area</a> </li>
                        </ul>
                    </div>
                </div>
            </div> <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body p-10 text-center">
                <div id="errorCacher"></div>
                <form id="ratingarea_form" enctype="multipart/form-data">
                    @csrf
                    <input id="sumAll"  type="hidden">
                    <input id="criteria_id" name="criteria_id" type="hidden">
                    <input id="applicant_id" name="applicant_id" type="hidden">
                    <input id="position_id" name="position_id" type="hidden">
                    <input id="applicant_list_ids" name="applicant_list_ids" type="hidden">
                    <input id="applicant_job_refs" name="applicant_job_refs" type="hidden">

                    <input id="maximumrate" name="maximumrate" type="hidden">
                    <input id="rateSum" type="hidden">
                    <table id="ratingArea_table" class="table table-bordered form-control">
                        <thead>
                            <tr>
                                    <th style="width: 65%">Area</th>
                                    <th class="text-center" style="width: 10%">Max Points</th>
                                    <th class="text-center">Your Rate</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>

                    </table>
                    <div class="intro-y block sm:flex items-center h-10 ">
                        <a id="max_rate" class="mr-5 ">Maximum Points: <label id="maxratelabel"></label></a>
                       <label id="input_areaRate" for="" class="ml-auto mr-5">Inputs Points:</label> <a id="sumOf_rate"><label id="area_ratelabel"></label></a>
                    </div>
                        <!-- END: Modal Body -->

                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer">
                        <button id="cnl_area_rating" type="button" href="javascript:;" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                        <button type="submit" href="javascript:;" class="btn btn-primary w-20">Save</button>
                    </div>
                    <!-- END: Modal Footer -->
                </form>
            </div>
        </div>
    </div>
</div>  <!-- END: Modal Content -->


