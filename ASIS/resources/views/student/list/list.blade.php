@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('Student List') }}
@endsection

@section('content')


    <h2 class="intro-y text-lg font-medium mt-10">
        Student List
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap xl:flex-nowrap items-center mt-2">
            <div class="flex w-full sm:w-auto">
                <div style="width: 21rem" class="relative text-slate-500">
                    <input style="width: 21rem" type="text" class="form-control box pr-10" id="filter-search" placeholder="Search...">
                    <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                </div>

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
    <div class="intro-y overflow-auto lg:overflow-visible mt-5 sm:mt-0">
        <div class="overflow-x-auto scrollbar-hidden">
            <table class="table table-report -mt-2" id="student_list_table">
                <thead>
                <tr>
                    <th class="whitespace-nowrap">Student ID</th>
                    <th class="whitespace-nowrap">Student Name / Address</th>
                    <th class="whitespace-nowrap">Email / Contact Number</th>
                    <th class="whitespace-nowrap text-center">Action</th>
                </tr>
                </thead>
                <tbody >

                </tbody>
            </table>
        </div>
    </div>
    <!-- END: Data List -->

    <!-- BEGIN: Pagination -->
    <div style="visibility: hidden" class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
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


    <div id="student_info_modal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- BEGIN: Modal Header -->
                <div class="modal-header justify-center items-center">
                    <i data-lucide="user" class="w-5 h-5 text-dark mr-3 "></i>
                    <h2 class="font-medium text-base mr-auto mt-1">Student Information</h2>
                </div>
                <!-- END: Modal Header -->

                <!-- BEGIN: Modal Body -->
                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-1" class="form-label">Student ID</label>
                        <input id="student_id" type="text" class="form-control" placeholder="Student ID">
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-1" class="form-label">First Name</label>
                        <input id="student_firstname" type="text" class="form-control" placeholder="First Name">
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-1" class="form-label">Middle Name</label>
                        <input id="student_midname" type="text" class="form-control" placeholder="Middle Name">
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-1" class="form-label">Last Name</label>
                        <input id="student_lastname" type="text" class="form-control" placeholder="Last Name">
                    </div>
                    <div class="col-span-12 sm:col-span-12">
                        <label for="modal-form-1" class="form-label">Address</label>
                        <input id="student_address" type="text" class="form-control" placeholder="Address">
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-1" class="form-label">Email</label>
                        <input id="student_email" type="text" class="form-control" placeholder="Email">
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <label for="modal-form-1" class="form-label">Contact Number</label>
                        <input id="student_contact" type="text" class="form-control" placeholder="Contact Number">
                    </div>
                </div>
                <!-- END: Modal Body -->


                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Close</button>
                </div>
                <!-- END: Modal Footer -->

            </div>
        </div>
    </div>


</div>

@endsection

@section('scripts')


    <script type="text/javascript" src="https://unpkg.com/tabulator-tables@4.9.3/dist/js/tabulator.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="{{BASEPATH()}}/js/student/list.js{{GET_RES_TIMESTAMP()}}"></script>
    <script src="{{BASEPATH()}}/js/dropdown.js{{GET_RES_TIMESTAMP()}}"></script>


@endsection
