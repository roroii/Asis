{{--modal for create new conversation--}}
<div id="votePosition_modal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 id="PositionModalHeader" class="font-medium text-base mr-auto">
                    Create Vote Position
                </h2>
                <div class="dropdown sm:hidden">

                </div>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <form id="VotePosition_form" enctype="multipart/form-data">
                    @csrf
                <div class="modal-body">

                        {{ csrf_field() }}


                            {{--  <input id="votePositionIDss" name="votePositionID" type="text">  --}}

                            <input type="hidden" id="votePositionIDss" name="votePositionID">

                            <div class="flex">
                                <label for="position"> Position </label>
                            </div>



                            <div class="mb-5" >

                                <input id="votePosition" type="text" name="votePosition" class="form-control" placeholder="Type Vote Position">
                                <label for="votePositionlbl" id="votePositionlbl" class="hidden text-danger" >Require Vote  Position</label>
                            </div>


                            <div class="mb-3">
                                <label for="positionDescription"> Description</label>
                                <textarea class="form-control" name="positionDescription" id="positionDescription" rows="3" placeholder="Type position Description"></textarea>
                                <label id="positionDescriptionlbl" for="positionDescriptionlbl" class="hidden text-danger">This field is required</label>
                            </div>
                            <!-- END: Modal Body -->

                        <!-- BEGIN: Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" id="btn_votePosition_cancel" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                            <button id="add_votePosition_btn" type="submit" class="btn btn-primary w-20">Save</button>
                        </div>
                        <!-- END: Modal Footer -->
                </div>
            </form>
        </div>
    </div>
</div>
