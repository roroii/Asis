@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('User Privileges') }}
@endsection
{{-- <style>
    div:focus {
    background-color:#3498db;
}
</style> --}}

@section('content')
<link rel="stylesheet" href="../build/css/bootstrap-datetimepicker.min.css">
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Manage User Accounts
    </h2>

    <div class="w-full sm:w-auto flex">
        @php
            $get_user_priv = Session::get('get_user_priv');
        @endphp
        @if($get_user_priv)
            @if ($get_user_priv[0]->create == 1 || Auth::user()->role_name == 'Admin')
                <button id="add_new_account" type="button" class="btn btn-primary shadow-md mr-2 user_priv_table_updated" data-tw-toggle="modal" data-tw-target="#account_modal"> <i class="w-4 h-4 mr-2" data-lucide="plus"></i> New Account </button>
            @else
                <button  type="button" class="no_user_priv btn btn-primary shadow-md mr-2" > <i class="w-4 h-4 mr-2" data-lucide="minus"></i> New Account </button>
            @endif
        @else
            <button id="add_new_account" type="button" class="btn btn-primary shadow-md mr-2 user_priv_table_updated" data-tw-toggle="modal" data-tw-target="#account_modal"> <i class="w-4 h-4 mr-2" data-lucide="plus"></i> New Account </button>
        @endif

        <div class="dropdown" style="position: relative;">
            <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                <span class="w-5 h-5 flex items-center justify-center"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="plus" class="lucide lucide-plus w-4 h-4" data-lucide="plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> </span>
            </button>
            <div class="dropdown-menu w-40" id="_gwv3kf5we">
                <ul class="dropdown-content">
                    <li>
                        @if($get_user_priv)
                            @if ($get_user_priv[0]->write == 1 || Auth::user()->role_name == 'Admin')
                                <a href="javascript:;"class="dropdown-item" data-tw-toggle="modal" data-tw-target="#sync_data_modal"> <i class="w-4 h-4 mr-2" data-lucide="rotate-cw"></i> Sync Data</a>
                            @else
                                <a href="javascript:;"class="no_user_priv dropdown-item"> <i class="w-4 h-4 mr-2" data-lucide="rotate-cw"></i> Sync Data</a>
                            @endif
                            @if ($get_user_priv[0]->export == 1 || Auth::user()->role_name == 'Admin')
                                <a id="export_data_account_profile_employee" href='{{url("admin/profile-export")}}' class="dropdown-item"> <i class="w-4 h-4 mr-2" data-lucide="download"></i> Export Data </a>
                            @else
                                <a href="javascript:;"class="no_user_priv dropdown-item"> <i class="w-4 h-4 mr-2" data-lucide="download"></i> Export Data </a>
                            @endif

                            @if ($get_user_priv[0]->import == 1 || Auth::user()->role_name == 'Admin')
                                <a href='javascript:;' class="dropdown-item" data-tw-toggle="modal" data-tw-target="#import_profile_modal"> <i class="w-4 h-4 mr-2" data-lucide="upload"></i> Import Data </a>
                            @else
                                <a href="javascript:;"class="no_user_priv dropdown-item"> <i class="w-4 h-4 mr-2" data-lucide="upload"></i> Import Data </a>
                            @endif
                        @else
                            <a id="sync_data_account_profile_employee" href="javascript:;"class="dropdown-item"> <i class="w-4 h-4 mr-2" data-lucide="rotate-cw"></i> Sync Data</a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="intro-y grid grid-cols-12 gap-5 mt-5">
    <!-- BEGIN: Item List -->
    <div class="intro-y col-span-12 lg:col-span-8">
        <div class="grid grid-cols-12 gap-5 mt-5">
            <div id="filter_div" data-fil-value="Active" class="col-span-12 sm:col-span-4 2xl:col-span-3 box p-5 cursor-pointer zoom-in">
                <div class="font-medium text-base">Active</div>
                <div id="filer_Active" class=" text-opacity-80 dark:text-slate-500"></div>
            </div>
            <div id="filter_div" data-fil-value="Inactive" class="col-span-12 sm:col-span-4 2xl:col-span-3 box p-5 cursor-pointer zoom-in">
                <div class="font-medium text-base ">Inactive</div>
                <div id="filer_Inactive" class=" text-opacity-80 dark:text-slate-500"></div>
            </div>
            <div id="filter_div" data-fil-value="Active Today" class="col-span-12 sm:col-span-4 2xl:col-span-3 box p-5 cursor-pointer zoom-in">
                <div class="font-medium text-base">Active Today</div>
                <div id="filer_ActiveToday" class=" text-opacity-80 dark:text-slate-500"></div>
            </div>
            <div id="filter_div" data-fil-value="Users" class="col-span-12 sm:col-span-4 2xl:col-span-3 box p-5 cursor-pointer zoom-in">
                <div class="font-medium text-base">Users</div>
                <div id="filer_Users" class=" text-opacity-80 dark:text-slate-500"></div>
            </div>
            <div id="filter_div" data-fil-value="Employees" class="col-span-12 sm:col-span-4 2xl:col-span-3 box p-5 cursor-pointer zoom-in">
                <div class="font-medium text-base">Employees</div>
                <div id="filer_Employees" class=" text-opacity-80 dark:text-slate-500"></div>
            </div>
            <div id="filter_div" data-fil-value="Applicants" class="col-span-12 sm:col-span-4 2xl:col-span-3 box p-5 cursor-pointer zoom-in">
                <div class="font-medium text-base">Applicants</div>
                <div id="filer_Applicants" class=" text-opacity-80 dark:text-slate-500"></div>
            </div>
            <div id="filter_div" data-fil-value="Admin" class="col-span-12 sm:col-span-4 2xl:col-span-3 box p-5 cursor-pointer zoom-in">
                <div class="font-medium text-base">Admin</div>
                <div id="filer_Admin" class=" text-opacity-80 dark:text-slate-500"></div>
            </div>
            <div id="filter_div" data-fil-value="Guest" class="col-span-12 sm:col-span-4 2xl:col-span-3 box p-5 cursor-pointer zoom-in">
                <div class="font-medium text-base">Unused</div>
                <div id="filer_Unused" class=" text-opacity-80 dark:text-slate-500"></div>
            </div>
        </div>
        <div class="intro-y box p-5 mt-5 border-t">
            <div class="overflow-x-auto scrollbar-hidden pb-10">
                <table id="dt__manage_users" class="table table-report -mt-2 table-hover">
                    <thead>
                    <tr>
                        <th style="display: none" class="text-center whitespace-nowrap "><div class="flex"> <input class="form-check-input selectall" type="checkbox" value="" ></div></th>
                        <th style="display: none" class="text-center whitespace-nowrap ">#ID</th>
                        <th style="width: 30%" class="text-center whitespace-nowrap ">Name</th>
                        <th class="text-center whitespace-nowrap ">Last Seen</th>
                        <th class="text-center whitespace-nowrap ">Status</th>
                        <th class="text-center whitespace-nowrap ">Username</th>
                        <th class="text-center whitespace-nowrap ">Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END: Item List -->


    <!-- BEGIN: Ticket -->
    <div class="col-span-12 lg:col-span-4">
        <div class="intro-y pr-1">
            <div class="box p-2">
                <ul class="nav nav-pills" role="tablist">
                    <li id="ticket-tab" class="nav-item flex-1" role="presentation">
                        <button class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#ticket" type="button" role="tab" aria-controls="ticket" aria-selected="true" > User </button>
                    </li>
                    <li id="details-tab" class="nav-item flex-1" role="presentation">
                        <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#details" type="button" role="tab" aria-controls="details" aria-selected="false" > Details </button>
                    </li>
                </ul>
            </div>
        </div>


        <div class="tab-content">
            <div id="ticket" class="tab-pane active" role="tabpanel" aria-labelledby="ticket-tab">
                <div id="div_user_profile" class="box p-5 mt-5">

                </div>

                <div id="div_user_employment" class="box p-5 mt-5">


                </div>

            </div>


            <div id="details" class="tab-pane" role="tabpanel" aria-labelledby="details-tab">
                <div id="div_user_details" class="box p-5 mt-5 div_user_details">


                </div>

            </div>
        </div>
    </div>
    <!-- END: Ticket -->
</div>

@include('admin.management.account_modal.account_modal')
@include('admin.management.account_modal.profile_modal')
@include('admin.management.account_modal.employee_modal')
@include('admin.management.account_modal.profile_import')
@include('admin.management.account_modal.sync_data')
@endsection

@section('scripts')
<script src="../js/account_mngmnt/account_mngnt.js"></script>
@endsection()
