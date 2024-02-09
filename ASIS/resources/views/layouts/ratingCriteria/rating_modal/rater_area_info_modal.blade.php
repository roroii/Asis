 <!-- BEGIN: Modal Content -->
 <div id="aria_rate_info_modal" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 id="criter_name" class="font-bold text-base mr-auto">Rater Criteria Area Information</h2>
                <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>
                    <div class="dropdown-menu w-40">
                        <ul class="dropdown-content">
                            <li> <a href="javascript:;" class="dropdown-item"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Add Area</a> </li>
                        </ul>
                    </div>
                </div>
            </div> <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div id="raterArea_points_div" class="modal-body">
                
                {{-- <table id="raterArea_points_tbl" class="table table-bordered form-control">
                    <thead>
                            <th style = "width: 70%">Area</th>
                            <th>Max Points</th>
                            <th>Score Points</th>
                    </thead>
                    <tbody>

                    </tbody>
                    <tr>
                        <td>
                            <input id="areaname" type="text" class="form-control" name="areaname[]" id="area_name" placeholder="Enter Area Name" required>
                        </td>
                        <td>
                            <input id="arearate" type="text" class="form-control" name="arearate[]" id="rate_id" placeholder="Enter Area Rate" required>
                        </td>
                        <td>
                            <a href="javascript:;" class="remove-table-row"> <i class="fa fa-trash-alt w-4 h-4 mr-2 text-danger"></i> Remove </a>
                        </td>
                    </tr>

                </table>
                 --}}



                
    
            </div>
            <!-- END: Modal Body -->

            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" id="btn_cancel" href="javascript:;" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">OK</button>
                {{-- <button type="submit" id="btn_save" href="javascript:;" class="btn btn-primary w-20">Save</button> --}}
            </div>
            <!-- END: Modal Footer -->            
        </div>
    </div>
</div>  <!-- END: Modal Content -->


