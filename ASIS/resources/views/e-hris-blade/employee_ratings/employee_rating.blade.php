@extends('layouts.app')
@section('breadcrumb')
    {{ Breadcrumbs::render('Dashboard') }}
@endsection

@section('content')

<div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-10">
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
        <button id="btn_hiringopen_modal" class="btn btn-primary shadow-md mr-2"  data-tw-toggle="modal" data-tw-target="#add_spms">Add rating</button>
    </div>
</div>
<div class="mt-5">
    <div class="box p-5 rounded-md">
        <div class="overflow-x-auto scrollbar-hidden -mt-3">
            <table id="spms_dt" class="table table-report bordered table-hover dt-responsive nowrap">
                <thead class="">
                    <tr>
                        <th class="text-center whitespace-nowrap">Rating Range</th>
                        <th class="text-center whitespace-nowrap">Adjectival</th>
                        <th class="text-center whitespace-nowrap">Activate</th>
                        <th class="text-center whitespace-nowrap">Active</th>
                        <th class="text-center whitespace-nowrap">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('employee_ratings.modal.add_spms_modal')
@include('employee_ratings.modal.delete_spms_modal')

@endsection

@section('scripts')
<script src="{{ asset('js/employee_rating_js/add_rating_value.js')}}"></script>
@endsection
