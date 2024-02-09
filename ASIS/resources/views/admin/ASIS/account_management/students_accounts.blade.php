@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('Students Accounts') }}
@endsection

@section('content')
    <h2 class="intro-y text-lg font-medium mt-10">
        Students Accounts
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap xl:flex-nowrap items-center mt-2">
            <div class="flex w-full sm:w-auto">
                <div class="w-56 relative text-slate-500">
                    <input type="text" class="form-control w-56 box pr-10" id="filter-search" placeholder="Search...">
                    <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                </div>
                <select id="filter-status" style="width: 50%;" class="form-select box ml-2">
                    <option value="999999">All</option>
                    <option value="1">Active</option>
                    <option value="1">Verified</option>
                    <option value="0">Un-Verified</option>
                </select>


                <div class="relative w-56 ml-2 hidden">
                    <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400"> <i data-lucide="calendar" class="w-4 h-4"></i> </div>
                    <input type="text" id="date_filter" class="form-control pl-12" autocomplete="off">
                    <a href="javascript:;" class="">
                        <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0 text-primary btn_clear_date_selection" data-lucide="x"></i>
                    </a>

                </div>

            </div>
            <div class="hidden md:block mx-auto text-slate-500" id="pagination-summary"></div>

            <div class="w-full xl:w-auto flex items-center mt-3 xl:mt-0" style="visibility: hidden">
                <button class="btn btn-primary shadow-md mr-2" > <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export to Excel </button>
                <button class="btn btn-primary shadow-md mr-2 btn_students_account_settings"> <i data-lucide="settings" class="w-4 h-4 mr-2"></i> Settings </button>
                <div class="dropdown hidden">
                    <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                        <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span>
                    </button>
                    <div class="dropdown-menu w-40">
                        <ul class="dropdown-content">
                            <li>
                                <a href="" class="dropdown-item"> <i data-lucide="arrow-left-right" class="w-4 h-4 mr-2"></i> Change Status </a>
                            </li>
                            <li>
                                <a href="" class="dropdown-item"> <i data-lucide="bookmark" class="w-4 h-4 mr-2"></i> Bookmark </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- BEGIN: Data List -->
    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible mt-5">
        <table class="table table-report -mt-2" id="transaction-list-table">
            <thead>
            <tr>
                <th class="whitespace-nowrap">STUDENT ID</th>
                <th class="whitespace-nowrap">NAME / EMAIL</th>
                <th class="text-center whitespace-nowrap">ACCOUNT STATUS</th>
                <th class="text-center whitespace-nowrap">EMAIL STATUS</th>
                <th class="text-center whitespace-nowrap">ACTIONS</th>
            </tr>
            </thead>
            <tbody >

            </tbody>
        </table>
    </div>
    <!-- END: Data List -->
    <!-- BEGIN: Pagination -->
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
        <nav class="w-full sm:w-auto sm:mr-auto">
            <ul class="pagination">
                <!-- Pagination links will be added here dynamically -->
            </ul>
        </nav>
        <select id="filter-size" class="w-20 form-select box mt-3 sm:mt-0">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="35">35</option>
            <option value="50">50</option>
            <option value="999999">All</option>
        </select>
    </div>
    <!-- END: Pagination -->
    </div>

    @include('pre_enrollees.modal')

@endsection
@section('scripts')

    <script src="{{BASEPATH()}}/js/ASIS_js/Accounts/manage_students_account.js{{GET_RES_TIMESTAMP()}}"></script>

@endsection
