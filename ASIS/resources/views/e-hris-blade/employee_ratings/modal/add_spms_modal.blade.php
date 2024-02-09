
<!-- BEGIN: Modal Content -->
<div id="add_spms" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Rating value</h2>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <form id="rating_form">
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-6"> <label for="modal-form-1" class="form-label font-bold">Numerical Value</label> <input id="rating_val" type="number" class="form-control" placeholder="example 5"> </div>
                    <div class="col-span-12 sm:col-span-6"> <label for="modal-form-2" class="form-label font-bold">Adjectival</label> <input id="adjectival" type="text" class="form-control" placeholder="Outstanding"> </div>
                    <div class="col-span-12 sm:col-span-12"> <label for="modal-form-3" class="form-label font-bold">Description</label>  <textarea id="rating_desc" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border" placeholder="Enter Description"></textarea> </div>
                    <div class="col-span-12 sm:col-span-12 overflow-x-auto scrollbar-hidden">
                        <table id="spms_table" class="table mt-2 spms_table">
                            <thead>
                                <th class="whitespace-nowrap" hidden> ID </th>
                                <th class="whitespace-nowrap"> Numerical Value </th>
                                <th class="whitespace-nowrap"> Adjectival </th>
                                <th class="whitespace-nowrap"> Description </th>
                                <th class="whitespace-nowrap"> Action </th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </form>
            <!-- END: Modal Body -->

            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer mt-2">
                <button id="btn_cancel_rating_value" type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1"> Cancel </button>
                <button id="btn_save_rating_value" type="button" class="btn btn-primary w-20">Saved</button>
            </div>
            <!-- END: Modal Footer -->
        </div>
    </div>

</div> <!-- END: Modal Content -->
