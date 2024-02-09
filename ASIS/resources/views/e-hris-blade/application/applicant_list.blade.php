@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('Application') }}
@endsection

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Applicant List
        </h2>
    </div>
    <div class="intro-y box p-5 mt-5">
        <div class="overflow-x-auto scrollbar-hidden pb-10">
            <table id="dt__applicant_list" class="table table-report -mt-2 table-hover">
                <thead>
                <tr>
{{--                    <th class="whitespace-nowrap">ID</th>--}}
                    <th >Applicants</th>
{{--                    <th class="text-center">Position(s) Applied</th>--}}
{{--                    <th class="whitespace-nowrap">Date Applied</th>--}}
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    @include('application.modal.applicant_list_modal')
    @include('application.modal.applicant_details_modal')
    @include('application.modal.approve_modal')
    @include('application.modal.application_note_modal')
    @include('application.modal.job_attachment')
@endsection

@section('scripts')
    <script src="{{ asset('/js/application/application_list.js') }}"></script>
    <script src="{{ asset('/js/dropdown.js') }}"></script>
@endsection
