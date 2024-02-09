@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('Responsibility Center') }}
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
        Responsibility Center
    </h2>

</div>
<!-- BEGIN: HTML Table Data -->
<div class="intro-y box p-5 mt-5">
    <div class="overflow-x-auto scrollbar-hidden pb-10">
        <table id="dt__rc" class="table table-report -mt-2 table-hover">
            <thead>
            <tr>
                <th style="display: none" class="text-center whitespace-nowrap ">#ID</th>
                <th class="text-center whitespace-nowrap ">Name</th>
                <th class="text-center whitespace-nowrap ">Descriptions</th>
                <th class="text-center whitespace-nowrap ">Department</th>
                <th class="text-center whitespace-nowrap ">Head</th>
                <th class="text-center whitespace-nowrap ">Action</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<!-- END: HTML Table Data -->
@include('admin.management.mngmodal')
@endsection

@section('scripts')
<script src="../js/rc.js"></script>
    <script src="../build/js/bootstrap-datetimepicker.min.js"></script>
@endsection()
