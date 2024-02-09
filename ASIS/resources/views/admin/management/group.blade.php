@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('Groups') }}
@endsection

<style>
.my-swal {
  z-index: X!impotant;
}
</style>
@section('content')
<link rel="stylesheet" href="../build/css/bootstrap-datetimepicker.min.css">
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Manage Groups
    </h2>
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
        <button class="btn btn-primary shadow-md mr-2" data-tw-toggle="modal" data-tw-target="#create_group_modal">Create New Group</button>

    </div>
</div>
<!-- BEGIN: HTML Table Data -->
<div class="intro-y box p-5 mt-5">
    <div class="overflow-x-auto scrollbar-hidden pb-10">
        <table id="dt__group" class="table table-report -mt-2 table-hover">
            <thead>
            <tr>
                <th style="display: none" class="text-center whitespace-nowrap ">#ID</th>
                <th class="text-center whitespace-nowrap ">Name</th>
                <th class="text-center whitespace-nowrap ">Descriptions</th>
                <th class="text-center whitespace-nowrap ">Action</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

@include('admin.management.mngmodal')
@endsection

@section('scripts')
<script src="../js/group.js"></script>
@endsection()
