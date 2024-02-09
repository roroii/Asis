@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('Outgoing Documents') }}
@endsection

@section('content')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Outgoing Documents
        </h2>
{{--        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">--}}
{{--            <button class="btn btn-primary shadow-md mr-2" href="javascript:;" data-tw-toggle="modal" data-tw-target="#sched_modal_new_sched">New Schedule</button>--}}
{{--            <div class="dropdown ml-auto sm:ml-0">--}}
{{--                <button class="dropdown-toggle btn px-2 box text-slate-500" aria-expanded="false" data-tw-toggle="dropdown">--}}
{{--                    <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span>--}}
{{--                </button>--}}
{{--                <div class="dropdown-menu w-40">--}}
{{--                    <ul class="dropdown-content">--}}
{{--                        <li>--}}
{{--                            <a class="dropdown-item" href="javascript:;" data-tw-toggle="modal" data-tw-target="#chat_modal_new_group"> <i data-lucide="users" class="w-4 h-4 mr-2"></i> Create Group </a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a class="dropdown-item" href="javascript:;" data-tw-toggle="modal" data-tw-target="#chat_modal_settings"> <i data-lucide="settings" class="w-4 h-4 mr-2"></i> Settings </a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
    <div class="intro-y box p-5 mt-5">
        <!-- BEGIN: Content -->
        <div class="overflow-x-auto scrollbar-hidden pb-10">
            <table id="dt__outgoingDocs" class="table table-report -mt-2 table-hover">
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
    @include('Documents.Modals.outgoing.outgoing_attachments')
    @include('Documents.Modals.receive.receive_attachments')
    @include('Documents.Modals.outgoing.other_modals')
@endsection

@section('scripts')
    <script src="{{ asset('/js/outgoing_Docs.js') }}"></script>
    <script src="{{ asset('/js/document_swal.js') }}"></script>
    <script src="{{ asset(('/js/add_document_attachments.js')) }}"></script>
@endsection
