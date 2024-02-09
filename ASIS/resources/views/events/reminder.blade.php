@extends('layouts.app')

@section('breadcrumb')
    {{-- {{ Breadcrumbs::render('Vote Type') }} --}}
@endsection
@section('content')
<div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-8">
    <button id="btn_create_reminder" class="btn btn-primary shadow-md mr-2"  data-tw-toggle="modal" data-tw-target="#create_reminder">Create Reminder</button>
</div>

<div class="intro-y box p-5 mt-5">
<div class="overflow-x-auto scrollbar-hidden pb-10">
    <table id="tb_event_list" class="table table-report mt-2 table-hover">
        <thead>
        <tr>
            <th class="text-center whitespace-nowrap">Event</th>
            <th class="text-center whitespace-nowrap ">Description</th>
            <th class="text-center whitespace-nowrap ">Enable</th>
            <th class="text-center whitespace-nowrap ">Status</th>
            <th class="text-center whitespace-nowrap ">Action</th>
        </thead>
        <tbody id="tb_event">

        </tbody>
    </table>
</div>
</div>
@include('events.modal.event_modal')
@include('events.modal.delete_event_modal')
@endsection
@section('scripts')
<script src="{{BASEPATH()}}/js/ASIS_event_reminder/reminder.js{{GET_RES_TIMESTAMP()}}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/classic/ckeditor.js"></script>
@endsection
