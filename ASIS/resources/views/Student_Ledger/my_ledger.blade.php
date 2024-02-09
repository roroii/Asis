@extends('layouts.app')

@section('breadcrumb')
    {{-- {{ Breadcrumbs::render('Vote Type') }} --}}
@endsection

@section('content')

 <!-- BEGIN: Content -->
 <div class="content">
    <div class="intro-y flex items-center mt-4">
        <h2 class="text-lg font-medium mr-auto">
            Student Information
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-4 overflow-auto lg:overflow-visible">
        <!-- BEGIN: Profile Menu -->
        <div class="col-span-12 lg:col-span-4 2xl:col-span-3 flex lg:block flex-col-reverse">
            <div class="intro-y box mt-5 lg:mt-0">
                <div class="relative flex items-center p-5">
                    <div class="w-12 h-12 image-fit">
                        <img id="student_pic"  alt="DSSC profile pic" class="rounded-full overflow-hidden shadow-lg image-fit zoom-in" data-action="zoom" src="">
                    </div>
                    <div class="ml-4 mr-auto">
                        <div class="font-medium text-base"> <label id="student_fullname"></label> </div>
                        <div class="text-slate-500"><label id="course" class="text-xs font-semibold"></label></div>
                    </div>
                </div>
                <div class="p-5 border-t border-slate-200/60 dark:border-darkmode-400">
                    <label class="flex items-center text-primary font-medium">
                        <i class="fa-solid fa-user"></i> <span class="ml-2">Personal Information</span>
                    </label>
                    <label class="flex items-center mt-5">
                        <span class="font-semibold">School Id no:</span> <span id="studentId" class="font-bold ml-2"></span>
                    </label>
                    <label class="flex items-center mt-5">
                        <span class="font-semibold">Course:</span> <span id="student_section" class="font-bold ml-2"></span>
                    </label>
                    <label class="flex items-center mt-5">
                        <span class="font-semibold">School year:</span> <span id="year_lvl" class="font-bold ml-2">Year</span>
                    </label>
                </div>
            </div>
        </div>
        <!-- END: Profile Menu -->
        <div class="col-span-12 lg:col-span-8 2xl:col-span-9 overflow-auto lg:overflow-visible">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: Daily Sales -->
                <div class=" col-span-12 2xl:col-span-12">
                   <!-- BEGIN: Inbox Filter -->
                   <div class="intro-y flex flex-col-reverse sm:flex-row items-center">
                    <div class="w-full sm:w-auto relative mr-auto mt-3 sm:mt-0">
                        <i class="w-4 h-4 absolute my-auto inset-y-0 ml-3 left-0 z-10 text-slate-500" data-lucide="search"></i>
                        <input id="search_input" type="text" class="form-control w-full sm:w-64 box px-10 search_input" placeholder="Search">
                        <div class="inbox-filter dropdown absolute inset-y-0 mr-3 right-0 flex items-center" data-tw-placement="bottom-start">
                            <i class="dropdown-toggle w-4 h-4 cursor-pointer text-slate-500" role="button" aria-expanded="false" data-tw-toggle="dropdown" data-lucide="chevron-down"></i>
                            <div class="inbox-filter__dropdown-menu dropdown-menu pt-2">
                                {{-- <div class="dropdown-content">
                                    <div class="grid grid-cols-12 gap-4 gap-y-3 p-3">
                                        <div class="col-span-6">
                                            <label for="input-filter-1" class="form-label text-xs">From</label>
                                            <input id="input-filter-1" type="text" class="form-control flex-1" placeholder="example@gmail.com">
                                        </div>
                                        <div class="col-span-6">
                                            <label for="input-filter-2" class="form-label text-xs">To</label>
                                            <input id="input-filter-2" type="text" class="form-control flex-1" placeholder="example@gmail.com">
                                        </div>
                                        <div class="col-span-6">
                                            <label for="input-filter-3" class="form-label text-xs">Subject</label>
                                            <input id="input-filter-3" type="text" class="form-control flex-1" placeholder="Important Meeting">
                                        </div>
                                        <div class="col-span-6">
                                            <label for="input-filter-4" class="form-label text-xs">Has the Words</label>
                                            <input id="input-filter-4" type="text" class="form-control flex-1" placeholder="Job, Work, Documentation">
                                        </div>
                                        <div class="col-span-6">
                                            <label for="input-filter-5" class="form-label text-xs">Doesn't Have</label>
                                            <input id="input-filter-5" type="text" class="form-control flex-1" placeholder="Job, Work, Documentation">
                                        </div>
                                        <div class="col-span-6">
                                            <label for="input-filter-6" class="form-label text-xs">List size</label>
                                            <select id="input-filter-6" class="form-select flex-1">
                                                <option></option>
                                                <option>10</option>
                                                <option>25</option>
                                                <option>35</option>
                                                <option>50</option>
                                            </select>
                                        </div>
                                        <div class="col-span-12 flex items-center mt-3">
                                            <button class="btn btn-secondary w-32 ml-auto">Create Filter</button>
                                            <button class="btn btn-primary w-32 ml-2">Search</button>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center mt-3 sm:mt-0 border-t sm:border-0 border-slate-200/60 pt-5 sm:pt-0 mt-5 sm:mt-0 -mx-5 sm:mx-0 sm:px-0 pl-2 pr-2">
                        <select id="filter_size" class=" ml-5 flex items-center justify-center form-select flex-1 form-select-sm">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="35">35</option>
                            <option value="50">50</option>
                            <option value="999999">All</option>
                        </select>
                    </div>
                </div>
                <!-- END: Inbox Filter -->
                <!-- BEGIN: Inbox Content -->
                <div class="overflow-x-auto scrollbar-hidden">
                    <table class="table table-hover intro-y inbox box mt-5 w-full">
                        <thead>
                            <tr class="p-5 text-slate-500 border-b border-slate-200/60 h-10">
                                <th class="w-60 text-center">
                                    School Year
                                </th>
                                <th class="w-64 sm:w-auto text-center">
                                    Semester
                                </th>
                                <th class="whitespace-nowrap pl-10 text-center">
                                    Total Amount
                                </th>
                            </tr>
                        </thead>

                        <tbody id="tb_ledger">
                            <!-- Table body content -->
                        </tbody>
                        <tfoot>
                            <tr class="p-5 flex flex-col sm:flex-row items-center text-center sm:text-left text-slate-500">
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- END: Inbox Content -->
                </div>
                <!-- END: Daily Sales -->
            </div>
        </div>
    </div>
</div>
<!-- END: Content -->

{{-- @include('vote.voteModals.voters_modal') --}}


@endsection
@section('scripts')
<script src="{{BASEPATH()}}/js/ASIS_student_ledger/student_ledger.js{{GET_RES_TIMESTAMP()}}"></script>
@endsection
