@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('My Transactions') }}
@endsection

@section('content')
    <h2 class="intro-y text-lg font-medium mt-10">
        My Transactions
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap xl:flex-nowrap items-center mt-2">
            <div class="flex w-full sm:w-auto">
                <div class="w-56 relative text-slate-500">
                    <input type="text" class="form-control w-56 box pr-10" id="filter-search" placeholder="Search...">
                    <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                </div>
                <select id="filter-status" class="form-select box ml-2">
                    <option value="999999">All Status</option>
                    <option value="11">Approved</option>
                    <option value="12">Dis-approved</option>
                    <option value="1">Pending</option>
                </select>
            </div>
            <div class="hidden md:block mx-auto text-slate-500" id="pagination-summary"></div>

            <div class="w-full xl:w-auto flex items-center mt-3 xl:mt-0" style="visibility: hidden">
                <button class="btn btn-primary shadow-md mr-2"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export to Excel </button>
                <button class="btn btn-primary shadow-md mr-2"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export to PDF </button>
                <div class="dropdown">
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
        <table class="table table-report -mt-2" id="my-transaction-list-table">
            <thead>
            <tr>
                <th class="whitespace-nowrap">TRANSACTION ID</th>
                <th class="whitespace-nowrap">PRE-ENROLLEES ID</th>
                <th class="whitespace-nowrap">NAME</th>
                <th class="text-center whitespace-nowrap">STATUS</th>
                <th class="whitespace-nowrap">APPOINTMENT DATE/TIME</th>
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

    @include('pre_enrollees.Schedule.modal')
@endsection
@section('scripts')
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables@4.9.3/dist/js/tabulator.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="{{BASEPATH()}}/js/ASIS_js/Transactions/my_transactions.js{{GET_RES_TIMESTAMP()}}"></script>

@endsection
