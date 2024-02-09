{{--modal for create new conversation--}}
<div id="add_group_modal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 id="typeModalHeader" class="font-medium text-base mr-auto">
                    Create New Group
                </h2>
                <div class="dropdown sm:hidden">

                </div>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <form id="add_group_form" enctype="multipart/form-data">
                    @csrf
                <div class="modal-body">

                        {{ csrf_field() }}


                            <input id="group_typeID" value="0" name="group_typeID" type="hidden">


                            <div class="flex">
                                <label> Group Name</label>
                            </div>
                            <div class="mb-5" >

                                <input id="group_name" type="text" name="group_name" class="form-control" placeholder="Type Group Name">
                                <label for="voteType" id="voteTypelbl" class="hidden text-danger" >This Field is Require</label>
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
