<div id="applicant_details_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"><a data-tw-dismiss="modal" href="javascript:;"> <i data-lucide="x" class="w-8 h-8 text-slate-400"></i> </a>
            @csrf
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Applicant Details</h2>
            </div>
            <div class="modal-body">
                <div class="intro-y col-span-12 sm:col-span-6 2xl:col-span-4">
                    <div class="p-5">
                        <div class="h-40 2xl:h-56 image-fit rounded-md overflow-hidden before:block before:absolute before:w-full before:h-full before:top-0 before:left-0 before:z-10 before:bg-gradient-to-t before:from-black before:to-black/10">
                            <img id="profile_picture" alt="Profile Picture" class="rounded-md">
                            <span class="absolute top-0 bg-pending/80 text-white text-xs m-5 px-2 py-1 rounded z-10">Featured</span>
                            <div id="profile_first_name" class="absolute bottom-0 text-white px-5 pb-6 z-10">

                            </div>
                        </div>
                        <div class="text-slate-600 dark:text-slate-500 mt-5">
{{--                            <div class="flex items-center font-bold"> Applied for: </div>--}}
                            <table id="dt__applied_pos" class="table table-report table-hover">
                                <thead class="btn-secondary">
                                <tr>
                                    <th >Positions</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

{{--                            <div id="applied_for_div">--}}

{{--                            </div>--}}

                        </div>

{{--                        <div class="mt-5 border-t border-slate-200/60 dark:border-darkmode-400 p-2">--}}

{{--                            <table id="dt__attachment_list" class="table table-report -mt-2 table-hover">--}}
{{--                                <thead class="btn-secondary">--}}
{{--                                <tr>--}}
{{--                                    <th class="whitespace-nowrap ">Attached Files</th>--}}
{{--                                    <th class="text-center whitespace-nowrap ">Action</th>--}}
{{--                                </tr>--}}
{{--                                </thead>--}}
{{--                                <tbody>--}}

{{--                                </tbody>--}}
{{--                            </table>--}}

{{--                            <div class="flex items-center mt-5"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> Status: Pending </div>--}}
{{--                        </div>--}}

                    </div>
                    <div class="flex justify-center lg:justify-end items-center p-5 border-t border-slate-200/60 dark:border-darkmode-400">
{{--                        <a class="flex items-center text-primary mr-auto" href="javascript:;"> <i data-lucide="eye" class="w-4 h-4 mr-1"></i> Preview </a>--}}
{{--                        <a class="flex items-center mr-3" href="javascript:;"> <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit </a>--}}
{{--                        <a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal"> <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
