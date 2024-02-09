@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('Document Settings') }}
@endsection

@section('content')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Document Settings
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            <button class="btn btn-primary shadow-md mr-2">Create New</button>
            <div class="dropdown ml-auto sm:ml-0">
                <button class="dropdown-toggle btn px-2 box text-slate-500" aria-expanded="false" data-tw-toggle="dropdown">
                    <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span>
                </button>
                <div class="dropdown-menu w-40 mt-1">
                    <ul class="dropdown-content mt-1">
                        <li>
                            <a class="dropdown-item" href="javascript:;" data-tw-toggle="modal" data-tw-target="#new_DocType"> <i data-lucide="settings" class="w-4 h-4 mr-2"></i> Document Type </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:;" data-tw-toggle="modal" data-tw-target="#new_DocLevel"> <i data-lucide="settings" class="w-4 h-4 mr-2"></i> Document Level </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="intro-y box p-5 mt-5">
        <!-- BEGIN: Content -->
        <ul class="nav nav-tabs" role="tablist">
            <li id="example-1-tab" class="nav-item flex-1" role="presentation">
                <button id="btn_docType" class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#docType" type="button" role="tab" aria-controls="docType" aria-selected="true"> Document Type </button>
            </li>
            <li id="example-2-tab" class="nav-item flex-1" role="presentation">
                <button id="btn_docLevel" class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#docLevel" type="button" role="tab" aria-controls="docLevel" aria-selected="false"> Document Level </button>
            </li>
        </ul>

        <div class="tab-content border-l border-r border-b">
            <div id="docType" class="tab-pane leading-relaxed p-5 active" role="tabpanel" aria-labelledby="docType">
                <div class="overflow-x-auto scrollbar-hidden pb-10">
                    <table id="dt__docType" class="table table-report -mt-2 table-hover">
                        <thead>
                        <tr>
                            <th style="display: none" class="text-center whitespace-nowrap ">#ID</th>
                            <th class="text-center whitespace-nowrap ">Document Type</th>
                            <th class="text-center whitespace-nowrap ">Descriptions</th>
                            <th class="text-center whitespace-nowrap ">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div id="docLevel" class=" tab-pane leading-relaxed p-5 " role="tabpanel" aria-labelledby="docLevel" style="width: 100%">
                <div  class="overflow-x-auto scrollbar-hidden pb-10">
                    <table style="width: 100%" id="dt__docLevel" class="table table-report -mt-2 table-hover">
                        <thead>
                        <tr>
                            <th style="display: none" class="text-center whitespace-nowrap ">#ID</th>
                            <th class="text-center whitespace-nowrap ">Document Level</th>
                            <th class="text-center whitespace-nowrap ">Descriptions</th>
                            <th class="text-center whitespace-nowrap ">Color</th>
                            <th class="text-center whitespace-nowrap ">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('admin.management.document_modal.create_DocType')
    @include('admin.management.document_modal.create_DocLevel')
    @include('admin.management.document_modal.update_DocType')
    @include('admin.management.document_modal.create_DocLevel')
    @include('admin.management.document_modal.update_DocLevel')


@endsection
@section('scripts')
    <script src="../js/doc_settings.js"></script>
@endsection


