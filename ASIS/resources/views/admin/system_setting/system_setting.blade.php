@extends('layouts.app')

@section('content')
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            System Settings
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            @php
                $get_user_priv = Session::get('get_user_priv');
            @endphp
            @if ($get_user_priv[0]->create == 1 || Auth::user()->role_name == 'Admin')
            <button class="btn btn-primary shadow-md mr-2" data-tw-toggle="modal" data-tw-target="#add_new_parameter_modal">Add Paramater</button>
            @endif
        </div>
    </div>
    <div class="intro-y box p-5 mt-5">
        <div class="overflow-x-auto scrollbar-hidden pb-10">
            <table id="dt__system_settings" class="table table-report -mt-2 table-hover">
                <thead>
                <tr>
                    <th class="text-center whitespace-nowrap ">ID</th>
                    <th class="text-center whitespace-nowrap ">Key</th>
                    <th class="text-center whitespace-nowrap ">Value</th>
                    <th class="text-center whitespace-nowrap ">Description</th>
                    <th class="text-center whitespace-nowrap ">Image</th>
                    <th class="text-center whitespace-nowrap ">Action</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    @include('admin.system_setting.modal.modal_setting')
@endsection
@section('scripts')
    <script src="{{ asset('/js/system_setting/system_setting.js') }}"></script>
    {{-- <script src="{{ asset('/js/system_setting/system_image_pond.js') }}"></script> --}}
@endsection
