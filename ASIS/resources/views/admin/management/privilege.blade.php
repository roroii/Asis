@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('User Privileges') }}
@endsection

@section('content')


<link rel="stylesheet" href="../build/css/bootstrap-datetimepicker.min.css">
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Manage User Privileges
    </h2>
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">

    </div>

    <div class="w-full sm:w-auto flex">
        <button type="button" class="btn btn-primary shadow-md mr-2 user_priv_table_updated"> <i class="w-4 h-4 mr-2" data-lucide="settings"></i> Add Privileges </button>

        <div class="dropdown" style="position: relative;">
            <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                <span class="w-5 h-5 flex items-center justify-center"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="plus" class="lucide lucide-plus w-4 h-4" data-lucide="plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> </span>
            </button>
            <div class="dropdown-menu w-40" id="_gwv3kf5we">
                <ul class="dropdown-content">
                    <li>
                        <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#user_priv_modal_reload_priv" class="dropdown-item"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="user" data-lucide="user" class="lucide lucide-user w-4 h-4 mr-2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> Includ Privileges </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- BEGIN: HTML Table Data -->
<div class="intro-y box p-5 mt-5">
    <div class="overflow-x-auto scrollbar-hidden pb-10">
        <table id="dt__users" class="table table-report -mt-2 table-hover">
            <thead>
                <tr>
                    <th style="width: 100px">

                        <div class="input-group flex-1">
                            <input id="selectall" name="selectall" class="form-check-input selectall w-5 h-5" type="checkbox" value="" >
                            <div><label class="pl-5" for="selectall">Select *</label></div>
                        </div>


                    </th>
                    <th  class="text-center whitespace-nowrap ">#ID</th>
                    <th class="text-center whitespace-nowrap ">Name</th>
                    <th class="text-center whitespace-nowrap ">Sex</th>
                    <th class="text-center whitespace-nowrap ">Last Seen</th>
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
<script src="../js/user-priv.js"></script>
@endsection()
