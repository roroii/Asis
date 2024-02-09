 <!-- BEGIN: Modal Content -->
 <div id="assignPosition_modal" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"><a data-tw-dismiss="modal" href="javascript:;"><i class="fa-sharp fa-light fa-circle-xmark w-6 h-6 text-danger zoom-in"></i> </a>
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-bold text-base mr-auto">Assign Position</h2>

            </div> <!-- END: Modal Header -->

            <form id="asisgn_position_form" enctype="multipart/form-data">

                @csrf

                <!-- BEGIN: Modal Body -->
            <div class="modal-body">
                <div class="grid grid-cols-12 gap-6">
                    <input id="votePositionID" value="0" name="votePositionID" type="hidden">

                    <div class="col-span-12 sm:col-span-12">
                        <div class="col-span-12 sm:col-span-6">
                            <label for="modal-form-6" class="form-label">Election Type</label>
                            <select id="electType_select" name="elecType_select" class="form-control">
                                    <option></option>
                                @foreach(loadElectionType() as $elect_type)
                                    <option value="{{ $elect_type->id }}">{{ $elect_type->vote_type }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>


                    <div class="intro-y col-span-12 lg:col-span-4 xl:col-span-6">
                        <div class="box mt-2">
                            <div class="px-4 pb-3 pt-5 rounded-md overflow-y-auto font-medium">
                                <h1 id="please_select">Select Position/s</h1>
                            </div>

                            <div class="border-t border-black/10 dark:border-darkmode-400 px-4 pb-3 pt-5 overflow-y-auto h-half-screen">

                                <table id="modal_position_tbl" class="table table-report cursor-pointer table-hover">
                                    <thead>
                                        <tr>
                                            <th class="whitespace-nowrap"></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach(loadElectionPosition() as $key => $electionPosition)
                                        <tr class="clickPositionRow" data-toggle="checkbox">
                                            <td>
                                                <div class="flex items-center px-3 py-2 rounded-md hover:bg-gray-500 dark:hover:bg-darkmode-400 transition hover:cursor-pointer">
                                                    <input type="checkbox" class="mr-2 position-checkbox">
                                                    <a id="{{ $electionPosition->id }}" data-position-description="{{ $electionPosition->position_desc }}" class="a-position"  href="javascript:;"> {{ $electionPosition->vote_position }} </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>


                            </div>
                        </div>
                    </div>

                    <div class="intro-y col-span-12 lg:col-span-8 xl:col-span-6">
                        <div class="box mt-2">

                            <div class="px-4 pb-3 pt-5 rounded-md overflow-y-auto font-medium">
                                <h1>Selected Posistion/s</h1>
                            </div>

                            <div class="border-t border-black/10 dark:border-darkmode-400 px-4 pb-3 pt-5 overflow-y-auto h-half-screen positionDiv">

                                <div class="flex justify-center items-center h-full noAvailable">

                                    <h2 class="text-slate-500 text-md"> No Selected position/s.</h2>

                                </div>


                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" href="javascript:;" class="btn btn-secondary w-20 mr-1" data-tw-dismiss="modal">Close</button>
                <button type="submit" href="javascript:;" class="btn btn-primary w-20 mr-1">Save</button>
            </div>
            <!-- END: Modal Footer -->

            </form>

        </div>
    </div>
</div>  <!-- END: Modal Content -->


