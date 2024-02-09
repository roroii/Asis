{{--modal for create new conversation--}}
<div id="voters_modal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content"><a id="cancel_voters_modal" data-tw-dismiss="modal" href="javascript:;"><i class="fa-sharp fa-light fa-circle-xmark w-5 h-5 text-danger zoom-in"></i> </a>
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 id="voters_ModalHeader" class="font-medium text-base">
                    
                </h2>
               
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
                <form id="voters_form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        {{ csrf_field() }}

                        <input id="type_idsss" value="0" name="type_id" type="hidden">

                        <div class="px-4 pb-3 overflow-y-auto h-half-screen">

                            <table id="program_tbl" class="table table-report -mt-2 cursor-pointer">
                                <thead>
                                    <tr>
                                        <th style="width:10%;" class="text-center whitespace-nowrap"> <input type="checkbox" name="check_all" id="check_all"> <label for="check_all"> Select All </label></th>
                                        <th style="width: 90%; text-align: center;" class="text-center whitespace-nowrap">Program Name</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                        <!-- BEGIN: Modal Footer -->
                        <div class="flex mt-2">
                            <button id="print_allVoters" onclick="printAllVoters()" type="button" class="btn btn-primary w-auto mr-2"> Print All <i class="fa fa-print ml-2"></i></button>
                            <div class="ml-auto save_btn_div">
                                <button type="button" id="btn_revert" class="btn btn-outline-secondary w-20 mr-2">Revert</button>
                                <button id="add_voters_btn" type="submit" class="btn btn-primary w-20">Save</button>
                            </div>
                        </div>
                        <!-- END: Modal Footer -->

                        <div id="Voters_div" class="grid grid-cols-12 gap-6 mt-5">

                        </div>

                    </div>
                </form>

            <!-- END: Modal Body -->
        </div>
    </div>
</div>
