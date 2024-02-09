@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('Returned Documents') }}
@endsection

@section('content')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Returned Documents
        </h2>

    </div>
    <div class="intro-y box p-5 mt-5">
        <!-- BEGIN: Content -->
        <div class="overflow-x-auto scrollbar-hidden pb-10">
            <table id="dt__returnedDocs" class="table table-report -mt-2 table-hover">
                <thead>
                <tr>
                    <th style="display: none" class="text-center whitespace-nowrap ">#ID</th>
                    <th class="text-center whitespace-nowrap ">Code</th>
                    <th class="text-center whitespace-nowrap ">Title</th>
                    <th class="text-center whitespace-nowrap ">Message</th>
                    <th class="text-center whitespace-nowrap ">Type/Level</th>
                    <th class="text-center whitespace-nowrap ">Status</th>
                    <th class="text-center whitespace-nowrap ">Attachments</th>
                    <th class="text-center whitespace-nowrap ">Action</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

        </div>
    </div>
    @include('Documents.Modals.returned.returned_attachments')
    @include('Documents.Modals.receive.receive_attachments')
    @include('Documents.Modals.returned.other_modals')
@endsection

@section('scripts')
    <script src="{{ asset('/js/returned_Docs.js') }}"></script>
    <script src="{{ asset('/js/document_swal.js') }}"></script>
    <script src="{{ asset(('/js/add_document_attachments.js')) }}"></script>
@endsection
