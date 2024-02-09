@extends('layouts.app')
@section('breadcrumb')
    {{ Breadcrumbs::render('Dashboard') }}
@endsection
@section('content')


<div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
    <button id="btn_hiringopen_modal" class="btn btn-primary shadow-md mr-2"  data-tw-toggle="modal" data-tw-target="#new_hiring_modal" >Add position</button>
    <div class="dropdown mr-4">
        <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
            <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span>
        </button>
        <div class="dropdown-menu w-40">
            <ul class="dropdown-content">
                <li>
                    <a target="_blank" href="{{ route('export_position_all') }}" class="dropdown-item"> <i class="fa fa-file-csv text-success mr-2"></i> Request for CSC </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
        <div class="w-56 relative text-slate-500">
            <div class="col-span-12 sm:col-span-6"></label>
                <div class="ml-10">
                    <select id="filter_status" class="select2 w-full">
                        <option></option>
                        <option value="13">available status</option>
                        <option value="1">pending status</option>
                        <option value="14">closed status</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="w-56 relative text-slate-500">
        <div class="col-span-12 sm:col-span-6"></label>
            <div class="ml-auto p-5">
                <button id="refresh" class="btn btn-secondary mr-2">Refresh<i class="fa-solid fa-arrows-rotate  ml-2 text-success"></i> </button>
            </div>
        </div>
    </div>
</div>

<div class="intro-y box p-5 mt-5">
    <div class="overflow-x-auto scrollbar-hidden pb-10">
        <table id="dt_hriring" class="table table-report mt-2 table-hover">
            <thead class="table-dark">
            <tr>
                <th class="text-center whitespace-nowrap hidden">ID</th>
                <th class="text-center whitespace-nowrap ">Place of Assignment</th>
                <th class="text-center whitespace-nowrap ">Position Title</th>
                <th class="text-center whitespace-nowrap hidden">Position Title ID</th>
                <th class="text-center whitespace-nowrap ">Plantilla Item No.</th>
                <th class="text-center whitespace-nowrap ">Posting Date</th>
                <th class="text-center whitespace-nowrap ">Closing Date</th>
                <th class="text-center whitespace-nowrap ">Status</th>
                <th class="text-center whitespace-nowrap ">Actions</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
    @include('hiring_blade.hiring_modal.add_modal')
    @include('hiring_blade.hiring_modal.delete_modal')
    @include('hiring_blade.hiring_modal.new_add_hiring_modal')
@endsection

@section ('scripts')
{{-- <script src="{{ asset('js/hiring_js/hiring.js') }}"></script> --}}
<script src="{{ asset('js/hiring_js/position_hiring.js') }}"></script>
<script src="{{ asset('js/hiring_js/load_hiring_tables.js') }}"></script>
<script src="{{ asset('js/dropdown.js') }}"></script>
@endsection

