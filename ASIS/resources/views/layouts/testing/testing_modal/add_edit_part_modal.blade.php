 <!-- BEGIN: Modal Content -->
 <div id="testPart_modal" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-bold text-base mr-auto">Employment Testing</h2>
                <div class="dropdown sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>
                    <div class="dropdown-menu w-40">
                        <ul class="dropdown-content">
                            <li> <a href="javascript:;" class="dropdown-item"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Download Docs </a> </li>
                        </ul>
                    </div>
                </div>
            </div> <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <form id="test_Part_form">
                @csrf
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <input id="part_id" name="part_id" type="hidden">

                    <div class="col-span-12 sm:col-span-12"> <label for="modal-form-5" class="form-label font-medium">Test Part</label>
                        <input type="text" name="test_part" id="test_part" class="form-control" placeholder="Enter Test Part">
                    </div>

                    <div class="col-span-12 sm:col-span-12"> <label for="modal-form-5" class="form-label font-medium">Description</label>
                        <textarea id="part_desc" name="part_desc" onchange="" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border" placeholder="Enter the description"></textarea>
                        <span id="text_count">0</span>/500
                    </div>

                </div>

                    <!-- END: Modal Body -->

                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button type="submit" id="btn_cancel" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                    <button type="submit" id="btn_save" href="javascript:;" class="btn btn-primary w-20">Save</button>
                </div>
                <!-- END: Modal Footer -->
            </form>
        </div>
    </div>
</div>  <!-- END: Modal Content -->
