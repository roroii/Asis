 <!-- BEGIN: Modal Content -->
 <div id="rateModal" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-bold text-base mr-auto">Rate Areas</h2>
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
                <form id="saveRate_form" enctype="multipart/form-data">
                    @csrf
                    <input id="applicant_ids" name="applicant_ids" type="hidden">
                    <input id="position" name="position" type="hidden">
                    <input id="position_type" name="position_type" type="hidden">
                    <input id="applicant_list_id" name="applicant_list_id" type="hidden">
                    <input id="applicant_job_ref" name="applicant_job_ref" type="hidden">
                    <input id="total_rate" value="0"  name="total_rate" type="hidden">
                    <input id="total_average_rate" value="0"  name="total_average_rate" type="hidden">
                    <input id="count_criteria" name="count_criteria" type="hidden">
                    <input id="max_ave" name="max_ave" type="hidden">
                    <input id="max_percent" name="max_percent" type="hidden">

                    {{-- <input id="maximumrate" name="maximumrate" type="hidden">
                    <input id="rateSum" type="hidden"> --}}

                    <!--Start Toggle Button -->
                    <div class="flex flex-col sm:flex-row items-center p-1 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto">
                            
                        </h2>
                        <div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
                            <label class="form-check-label ml-0" for="show-example-5">Use Average</label>
                            <input id="rating_check" name="rating_check" class="show-code form-check-input mr-0 ml-3" type="checkbox">
                            <input id="checkbox" name="checkbox" type="hidden">
                        </div>
                    </div>

                    <!--End Toggle Button -->

                    <table id="manageRating_table" class="table table-bordered form-control">
                        <thead>
                            <tr>
                                    <th style="width: 70%">Criteria</th>
                                    <th>Max Points</th>
                                    <th>Areas</th>
                                    <th>Rate</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot id="tfoot_id">
                            <tr>

                                <th id="total_name" class="whitespace-nowrap">Total Percent</th>
                                <th id="foot_maxrating" class="whitespace-nowrap text-center">0%</th>
                                <th class="whitespace-nowrap"></th>
                                <th id="foot_totalrate" class="whitespace-nowrap text-center">0%</th>
                               

                            </tr>

                        </tfoot>

                    </table>
                    {{-- <div class="intro-y block sm:flex items-center h-10 ">
                        <a id="max_rate" class="mr-5 ">Maximum Rate: <label id="maxratelabel"></label></a>
                        <a id="sumOf_rate" class="ml-auto mr-5 "><label id="area_ratelabel"></label></a>
                    </div> --}}
                        <!-- END: Modal Body -->
                        <div id="remarks_div">
                            <div></div>
                            <textarea class="form-control preserveLines" name="remarks" id="remarks" cols="70%" placeholder="Please Write a Comment.." rows="3" required></textarea>
                            <div class="intro-y flex flex-col sm:flex-row items-center mt-3">

                                <div class="mr-auto">

                                </div>

                            </div>

                        </div>

                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer">
                        <button id="cnl_rate_modal" type="button" href="javascript:;" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                        <button id="saveRate_btn" type="submit" href="javascript:;" class="btn btn-primary w-20">Save</button>
                    </div>
                    <!-- END: Modal Footer -->
                </form>
            </div>
        </div>
    </div>
</div>  <!-- END: Modal Content -->


