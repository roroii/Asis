{{--modal for create new conversation--}}
<div id="voteType_modal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 id="typeModalHeader" class="font-medium text-base mr-auto">
                    Add Vote Type
                </h2>
                <div class="dropdown sm:hidden">

                </div>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <form id="VoteType_form" enctype="multipart/form-data">
                    @csrf
                <div class="modal-body">

                    {{ csrf_field() }}


                        <input id="typeIDdd" name="typeID" type="hidden">

                        <div class="flex">
                            <label for="criteria"> Type </label>
                        </div>



                        <div class="mb-5" >

                            <input id="voteType" type="text" name="voteType" class="form-control" placeholder="Type Vote Type">
                            <label for="voteType" id="voteTypelbl" class="hidden text-danger" >Require Vote  Type</label>
                        </div>


                        <div class="mb-3">
                            <label for="typeDescription"> Description</label>
                            <textarea class="form-control" name="typeDescription" id="typeDescription" rows="3" placeholder="Type Description"></textarea>
                            <label id="typeDescriptionlbl" for="typeDescription" class="hidden text-danger">This field is required</label>
                        </div>
                        <!-- END: Modal Body -->

                        <!-- BEGIN: Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" id="btn_voteType_cancel" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                            <button id="add_voteType_btn" type="submit" class="btn btn-primary w-20">Save</button>
                        </div>
                        <!-- END: Modal Footer -->
                </div>
            </form>
        </div>
    </div>
</div>
