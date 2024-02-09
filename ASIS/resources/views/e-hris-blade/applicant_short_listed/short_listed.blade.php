@extends('layouts.app')
@section('breadcrumb')
    {{ Breadcrumbs::render('Dashboard') }}
@endsection

@section('content')

            <div class="intro-y flex flex-col sm:flex-row items-center mt-4">
                <span > <label for="modal-form-1" class=" form-label font-medium ">Filter Status</label></span>
            </div>
        <div class="intro-y flex flex-col sm:flex-row items-center">
            <div class="">
                <select id="filter" class="w-40 h-9 font-extrabold">
                    <option></option>
                    <option value="10">Waiting</option>
                    <option value="11">Approved</option>
                </select>
            </div>
        </div>

        <div class="intro-y box p-5 mt-5">
            <div id = "short_listed_table" class="overflow-x-auto scrollbar-hidden pb-10">
            </div>
        </div>

@include('applicant_short_listed.modal.applicant_info')
@include('applicant_short_listed.modal.new_applicant_info');
@include('applicant_short_listed.modal.send_email');
@endsection

@section('scripts')
<script src="{{ asset('js/short_listed/short_list.js') }}"></script>
<script src="{{ asset('js/dropdown.js') }}"></script>
@endsection
