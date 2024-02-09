{{--modal for create new conversation--}}
<div id="parties_modal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 id="typeModalHeader" class="font-medium text-base mr-auto">
                    Add Parties
                </h2>
                <div class="dropdown sm:hidden">

                </div>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <form id="parties_form" enctype="multipart/form-data">
                    @csrf
                <div class="modal-body">

                        {{ csrf_field() }}


                            <input id="parties_id" name="parties_id" type="hidden">

                            <div class="flex">
                                <label for="parties_name"> Parties </label>
                            </div>

                            <div class="mb-5" >

                                <input id="parties_name" type="text" name="parties_name" class="form-control" placeholder="Parties">
                                <label for="partieslbl" id="partieslbl" class="hidden text-danger" >This Field is Required</label>
                            </div>

                            <div class="mb-3">
                                <label for="partiesDescription"> Description</label>
                                <textarea class="form-control" name="partiesDescription" id="partiesDescription" rows="3" placeholder="Parties Description"></textarea>
                                <label id="partiesDescriptionlbl" for="partiesDescriptionlbl" class="hidden text-danger">This field is required</label>
                            </div>
                            <!-- END: Modal Body -->

                        <!-- BEGIN: Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" id="btn_voteType_cancel" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                            <button id="add_parties_btn" type="submit" class="btn btn-primary w-20">Save</button>
                        </div>
                        <!-- END: Modal Footer -->
                </div>
            </form>
        </div>
    </div>
</div>
