@extends('layouts.app')

@section('content')
    <h2 class="intro-y text-lg font-medium mt-10">
        Criteria
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <button class="btn btn-primary shadow-md mr-2">Add New Criteria</button>
            <div class="dropdown">
                <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                    <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span>
                </button>
                <div class="dropdown-menu w-40">
                    <ul class="dropdown-content">
                        <li>
                            <a href="" class="dropdown-item"> <i data-lucide="printer" class="w-4 h-4 mr-2"></i> Print </a>
                        </li>
                        <li>
                            <a href="" class="dropdown-item"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export to Excel </a>
                        </li>
                        <li>
                            <a href="" class="dropdown-item"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export to PDF </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-x-auto scrollbar-hidden overflow-auto lg:overflow-visible">
                <table id="dt_criteria" class="table table-report -mt-2 table-hover">
                    <thead>
                    <tr>
                        <th class="hidden">ID</th>
                        <th class="whitespace-nowrap">NAME</th>
                        <th class="text-center whitespace-nowrap">NATURE</th>
                        <th class="text-center whitespace-nowrap" style="text-align: center">AREAS</th>
                        <th class="text-center whitespace-nowrap" style="text-align: center">POINTS</th>
                        <th class="text-center whitespace-nowrap" style="text-align: center">ACTIONS</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
        </div>
        <!-- END: Data List -->
    </div>
@endsection

@section('scripts')
    <script src="../js/interview/criteria.js"></script>
@endsection()
