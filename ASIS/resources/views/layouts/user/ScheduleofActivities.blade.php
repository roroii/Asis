@extends('layouts.app')

@section('content')

<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Public Files
    </h2>
    <div class="relative text-slate-500 pr-1 pt-1 mt-4">
        <input onkeyup="doDelayedSearch(this.value)" autocomplete="off" id="search_scan_documet" onfocus="this.value='';" autofocus type="text" class="form-control h-100 w-full" placeholder="Scan Document...">
        <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0 text-slate-500" data-lucide="Scan"></i>
    </div>
</div>
<div class="intro-y p-5 mt-5">
    <div class="overflow-x-auto scrollbar-hidden pb-10">
        <table id="dt__publicFiles" class="table table-report -mt-2 table-hover">
            <thead>
            <tr>
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

@endsection

@section('scripts')
    <script src="{{ asset('/js/publicFiles.js') }}"></script>
    <script src="{{ asset('/js/document_swal.js') }}"></script>
    <script src="{{ asset('/js/scan_Doc.js') }}"></script>
@endsection()
