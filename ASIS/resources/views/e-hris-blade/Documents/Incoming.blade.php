@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('Incoming Documents') }}
@endsection

@section('content')

<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Incoming Documents
    </h2>
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
    </div>
</div>
<div  class="intro-y box p-5 mt-5">

    <div class="overflow-x-auto scrollbar-hidden pb-10">
        <table id="dt__incomingDocs" class="table table-report -mt-2 table-hover">
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

@include('Documents.Modals.incoming.receive')
@include('Documents.Modals.receive.receive_attachments')
@endsection
@section('scripts')
    <script src="{{ asset('/js/incoming_Docs.js') }}"></script>
    <script src="{{ asset('/js/document_swal.js') }}"></script>
@endsection

