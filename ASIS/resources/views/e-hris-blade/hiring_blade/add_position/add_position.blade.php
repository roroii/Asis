@extends('layouts.app')
@section('breadcrumb')
    {{ Breadcrumbs::render('Dashboard') }}
@endsection

@section('content')

<div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-10">
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
        <button id="btn_hiringopen_modal" class="btn btn-primary shadow-md mr-2"  data-tw-toggle="modal" data-tw-target="#add_position" >Add position</button>
    </div>
</div>
<div class="mt-5">
    <div class="box p-5 rounded-md">
        <div class="overflow-auto lg:overflow-visible -mt-3">
            <table id="position_display_table" class="table table-report bordered table-hover dt-responsive nowrap">
                <thead class="">
                    <tr>
                        <th class="text-center whitespace-nowrap">Position</th>
                        <th class="text-center whitespace-nowrap">Description</th>
                        <th class="text-center whitespace-nowrap">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('hiring_blade.add_position.position_modal.add_position_modal')

@endsection

@section('scripts')
<script src="{{ asset('js/hiring_js/create_poisiton.js') }}"></script>
<script src="{{ asset('js/dropdown.js') }}"></script>
@endsection
