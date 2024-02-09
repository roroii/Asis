<!-- BEGIN: Modal Content -->
<div id="apply_withGroup_modal" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"><a data-tw-dismiss="modal" href="javascript:;"><i class="fa-sharp fa-light fa-circle-xmark w-5 h-5 text-slate-400 zoom-in"></i> </a>
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 id="apply_withGroup_Header" class="font-bold text-base mr-auto">Be a Candidate</h2>

            </div> <!-- END: Modal Header -->

            <form id="fgfdfg" enctype="multipart/form-data">

                @csrf

                <!-- BEGIN: Modal Body -->
            <div class="modal-body">
                <div class="grid grid-cols-12 gap-6">
                    <input id="open_typeID" value="0" name="open_typeID" type="hidden">
                    <input id="vote_typeID" value="0" name="vote_typeID" type="hidden">

                    <div class="intro-y col-span-12">
                        <div class="box mt-2">
                            <div class="flex px-4 pt-5 rounded-md overflow-y-auto font-medium">
                                <h1 id="please_select">Choose Groups</h1>
                                {{-- <span class="ml-auto">
                                    <a href="javascript:;" class="text-primary create_group"
                                        style="text-decoration: none;"
                                        onmouseover="this.style.textDecoration='underline';"
                                        onmouseout="this.style.textDecoration='none';">
                                        <i class="fa-solid fa-plus text-success"></i>
                                        Create Group
                                    </a>
                                </span> --}}
                            </div>

                            <div id="no_group_div" class="border-t border-black/10 dark:border-darkmode-400 px-4 pb-3 overflow-y-auto h-half-screen">

                                <div id="modal_group_div" class="grid grid-cols-12 gap-6 mt-5">


                                    {{-- <div class="intro-y col-span-12 md:col-span-4 zoom-in">
                                        <div class="box">
                                            <div class="flex flex-col lg:flex-row items-center p-5">
                                                <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                                                    <a href="javascript:;" class="font-medium">Group Name</a>
                                                    <div class="text-slate-500 text-xs mt-0.5">Member/s 5/5</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}

                                    <div class="">
                                        <div class="intro-y box py-10 sm:py-20 mt-5 bg-green-100 border-green-200 dark:bg-green-900 dark:border-green-800 animate-fade-in">
                                            <div class="text-center mb-4">
                                                <i class="fas fa-exclamation-triangle fa-beat text-warning h-10 w-10"></i><!-- <i class="fas fa-check-circle text-success text-4xl mx-auto animate-color-change fa-beat"></i> Font Awesome fontawesome.com -->
                                                <h2 class="text-2xl font-semibold mt-2">No Groups Data Found </h2>
                                            </div>
                                            <div class="text-center text-green-700 mt-4">

                                            </div>
                                            <div class="flex items-center justify-center mt-6">

                                            </div>
                                        </div>
                                    </div>


                                </div>
                                {{-- <table id="apply_groups_modal_tbl" class="table table-report cursor-pointer table-hover">
                                    <thead>
                                        <tr>
                                            <th class="whitespace-nowrap"></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table> --}}


                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer applying_modalFooter">
                <button id="cancel-apply" type="button" href="javascript:;" class="btn btn-secondary w-20 mr-1" data-tw-dismiss="modal">Close</button>
                <button id="submit_applyModal_btn" type="submit" href="javascript:;" class="btn btn-primary w-20 mr-1">Next</button>
            </div>
            <!-- END: Modal Footer -->

            </form>

        </div>
    </div>
 </div>  <!-- END: Modal Content -->
