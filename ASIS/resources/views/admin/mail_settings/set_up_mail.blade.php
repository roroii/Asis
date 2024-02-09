@extends('layouts.app')
@section('breadcrumb')
    {{ Breadcrumbs::render('Dashboard') }}
@endsection

@section('content')

<div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-10">
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
        <button id="btn_hiringopen_modal" class="btn btn-primary shadow-md mr-2"  data-tw-toggle="modal" data-tw-target="#configure_email">Configure email</button>
    </div>
</div>
<div class="mt-5">
    <div class="box p-5 rounded-md">
        <div class="overflow-x-auto scrollbar-hidden -mt-3">
            <table id="mail_config" class="table table-report bordered table-hover dt-responsive nowrap">
                <thead class="">
                    <tr>
                        <th class="text-center whitespace-nowrap hidden">ID</th>
                        <th class="text-center whitespace-nowrap">Mail Driver</th>
                        <th class="text-center whitespace-nowrap">Mail Host</th>
                        <th class="text-center whitespace-nowrap">Mail Port</th>
                        <th class="text-center whitespace-nowrap">Mail Encryption</th>
                        <th class="text-center whitespace-nowrap">Active</th>
                        <th class="text-center whitespace-nowrap">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('admin.mail_settings.modal.configure_mail')
@include('admin.mail_settings.modal.delete_mail_settings')

@endsection

@section('scripts')
<script src="{{ asset('js/system_setting/mail_settings.js')}}"></script>
@endsection
