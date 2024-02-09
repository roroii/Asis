@extends('layouts.app')
@section('content')

@livewireStyles
{{-- @powerGridStyles --}}
{{-- <link rel="stylesheet" href="{{url('')}}/css/tailwind_min.min.css{{GET_RES_TIMESTAMP()}}" /> --}}
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/flatpickr" defer></script> --}}

    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Faculty
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
            @if(Session::has('get_user_priv'))
                @if (Session::get('get_user_priv')[0]->create == 1 || Auth::user()->role_name == 'Admin')
                    <button id="add_new_schedule" type="button" class="btn btn-primary shadow-md mr-2 user_priv_table_updated" data-tw-toggle="modal" data-tw-target="#add_new_schedule_modal"> <i class="w-4 h-4 mr-2" data-lucide="plus"></i> Add Schedule </button>

                @else
                    <button  type="button" class="not_allowed_to_take_action btn btn-primary shadow-md mr-2" > <i class="w-4 h-4 mr-2" data-lucide="minus"></i> Add Schedule </button>

                @endif
            @else

            <button id="add_new_schedule" type="button" class="btn btn-primary shadow-md mr-2 user_priv_table_updated" data-tw-toggle="modal" data-tw-target="#add_new_schedule_modal"> <i class="w-4 h-4 mr-2" data-lucide="plus"></i> Add Schedule </button>

            @endif
            <div class="dropdown" style="position: relative;">
                <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                    <span class="w-5 h-5 flex items-center justify-center"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="plus" class="lucide lucide-plus w-4 h-4" data-lucide="plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> </span>
                </button>
                <div class="dropdown-menu w-40" id="_gwv3kf5we">
                    <ul class="dropdown-content">
                        <li>
                            @if(Session::has('get_user_priv'))
                                @if (Session::get('get_user_priv')[0]->create == 1 || Auth::user()->role_name == 'Admin')
                                    <a  href="javascript:;" class="dropdown-item" data-tw-toggle="modal" data-tw-target="#lingking_agency_esms_modal"> <i class="w-4 h-4 mr-2" data-lucide="user" ></i> Admin </a>
                                @else
                                    {{-- <a href="javascript:;"class="no_user_priv dropdown-item not_allowed_to_take_action"> <i class="w-4 h-4 mr-2" data-lucide="user"></i> Admin </a> --}}
                                @endif
                            @else
                                <a  href="javascript:;" class="dropdown-item" data-tw-toggle="modal" data-tw-target="#lingking_agency_esms_modal"> <i class="w-4 h-4 mr-2" data-lucide="user"></i> Admin </a>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="intro-y box p-5 mt-5">

        <div class="flex flex-col sm:flex-row items-center">
            <div class="grid-span-12 sm:grid-span-12">
                <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Year</label>
                <select style="width: 150px" name="filter_year" id="filter_year" class="btn shadow-md mr-2">
                    @forelse (load_esms_year('') as $i => $sy)
                        <option value="{{ $sy }}">{{ $sy }}</option>
                    @empty

                    @endforelse
                </select>
            </div>

            <div class="grid-span-12 sm:grid-span-12">
                <label for="validation-form-6" class="form-label w-full flex flex-col sm:flex-row">Sem</label>
                <select style="width: 150px" name="filter_sem" id="filter_sem" class="btn shadow-md mr-2">
                    @forelse (load_esms_sem('') as $i => $sem)
                        <option value="{{ $sem }}">{{ $sem }}</option>
                    @empty

                    @endforelse
                </select>
            </div>
        </div>

        <div class="overflow-x-auto scrollbar-hidden pb-10">
            <table id="dt__faculty_subjects" class="table table-report -mt-2 table-hover">
                <thead>
                <tr>
                    <th  class="text-center whitespace-nowrap ">Faculty</th>
                    <th class="text-center whitespace-nowrap ">Subject Code</th>
                    <th class="text-center whitespace-nowrap ">Section</th>
                    <th style="display:none" class="text-center whitespace-nowrap ">Day(s)</th>
                    <th style="display:none" class="text-center whitespace-nowrap ">Time</th>
                    <th style="display:none" class="text-center whitespace-nowrap ">Room</th>
                    <th style="display:none" class="text-center whitespace-nowrap ">Building</th>
                    <th class="text-center whitespace-nowrap ">Block</th>
                    <th class="text-center whitespace-nowrap ">Student Limit</th>
                    <th class="text-center whitespace-nowrap ">Forcoll</th>
                    <th class="text-center whitespace-nowrap ">Department</th>
                    <th class="text-center whitespace-nowrap ">Load</th>
                    <th class="text-center whitespace-nowrap ">Class Status</th>
                    <th class="text-center whitespace-nowrap ">Action</th>
                </tr>
                </thead>
                <tbody>


                </tbody>
            </table>
        </div>
    </div>

    @include('faculty_monitoring.faculty_modal.add_new_schedule')
    @include('faculty_monitoring.faculty_modal.linking_faculty_esms')
    @include('faculty_monitoring.faculty_modal.update_link_meeting')

@endsection
@section('scripts')
    {{-- @livewireScripts
    @powerGridScripts --}}
    <script src="{{ asset('/js/faculty_monitoring/faculty.js') }}"></script>
@endsection

