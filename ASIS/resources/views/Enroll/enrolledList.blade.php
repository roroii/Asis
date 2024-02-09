@extends('layouts.app')

@section('breadcrumb')
@endsection

@section('content')

{{-- <link rel="stylesheet" href="{{url('')}}/css/tailwind_min.min.css{{GET_RES_TIMESTAMP()}}" /> --}}
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                Enrollment
            </h2>
            
            {{-- <div class="intro-y flex flex-col sm:flex-row items-center mt-8">

                    @if( auth()->user()->role === 'Admin')
                        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                            <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#report_list_modal" class="btn btn-primary shadow-md mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="file-text" data-lucide="file-text" class="lucide lucide-file-text w-4 h-4 mr-2"><path d="M14.5 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V7.5L14.5 2z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><line x1="10" y1="9" x2="8" y2="9"></line></svg> Export </a>
                            <div class="pos-dropdown dropdown ml-auto sm:ml-0">
                                <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                                    <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="chevron-down"></i> </span>
                                </button>
                                <div class="dropdown-menu w-40">
                                    <ul class="dropdown-content">
                                        <li>
                                            <a href="javascript:;" class="dropdown-item"  data-tw-toggle="modal" data-tw-target="#enrollment_settings"> <i data-lucide="printer" class="w-4 h-4 mr-2"></i> Settings </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
            </div> --}}
            <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                @if( auth()->user()->role === 'Admin')

                @endif
                        <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#report_list_modal" class="btn btn-primary shadow-md mr-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="file-text" data-lucide="file-text" class="lucide lucide-file-text w-4 h-4 mr-2"><path d="M14.5 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V7.5L14.5 2z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><line x1="10" y1="9" x2="8" y2="9"></line></svg> Export </a>
                        <div class="dropdown ml-auto sm:ml-0">
                            <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                                <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span>
                            </button>
                            <div class="dropdown-menu w-40">
                                <ul class="dropdown-content">
                                    <li>
                                        <a href="javascript:;" class="dropdown-item"  data-tw-toggle="modal" data-tw-target="#enrollment_settings"> <i data-lucide="printer" class="w-4 h-4 mr-2"></i> Settings </a>
                                    </li>
                                    <li>
                                        <a href="" class="dropdown-item"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Reload Details </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
            </div>
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">

            <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
               <div class="w-48 relative text-slate-500">
                    <input
                        type="text"
                        id="filter-search"
                        name="search_subject_code"
                        class="form-control w-48 box pr-10"
                        placeholder="Name..."
                    />
                    <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                </div>
            </div>

            <div class="hidden md:block mx-auto text-slate-500" id="pagination-summary"></div>
            <div class="flex w-full sm:w-auto">
                
                <div id="programmatically-dropdown" class="btn dropdown inline-block ml-auto" data-tw-placement="bottom">
                        <a href="javascript:;" class="dropdown-toggle flex items-center ml-auto text-primary" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="edit" class="w-4 h-4 mr-2"></i> Filter Search </a>
                        <div class="inbox-filter__dropdown-menu dropdown-menu pt-2">
                            <div class="dropdown-content">
                                <div class="grid grid-cols-12 gap-4 gap-y-3 p-3">
                                    <div class="col-span-6">
                                        <label for="input-filter-6" class="form-label text-xs">School Year</label>
                                        <select id="input-filter-6-school-year" class="form-select flex-1">
                                            <option value="">School Year</option>
                                           @forelse (load_enroll_list_school_year() as $school_year)
                                                <option value="{{ $school_year }}">{{ $school_year }}</option>
                                            @empty

                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="col-span-6">
                                        <label for="input-filter-6" class="form-label text-xs">Semester</label>
                                        <select id="input-filter-6-semester" class="form-select flex-1">
                                            <option value="">Semester</option>
                                            @forelse (load_enroll_list_school_sem() as $school_sem)
                                                <option value="{{ $school_sem }}">{{ $school_sem }}</option>
                                            @empty

                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="col-span-6">
                                        <label for="input-filter-6" class="form-label text-xs">Year Level</label>
                                        <select id="input-filter-6-year-level" class="form-select flex-1">
                                            <option value="">Year Level</option>
                                            @forelse (load_enroll_list_year_level() as $yearlevel)
                                                <option value="{{ $yearlevel }}">{{ $yearlevel }}</option>
                                            @empty

                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="col-span-6">
                                        <label for="input-filter-6-section" class="form-label text-xs">Course/Program</label>
                                        <select id="input-filter-6-course-program" class="form-select flex-1">
                                            <option value="">Course/Program</option>
                                            @forelse (load_enroll_list_program() as $program)
                                                <option value="{{ $program }}">{{ $program }}</option>
                                            @empty

                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="col-span-12">
                                        <label for="input-filter-6-section" class="form-label text-xs">Status</label>
                                        <select name="input-filter-6-status" id="input-filter-6-status" class="form-select flex-1">
                                            <option value="">All</option>
                                            <option value="0">Pending</option>
                                            <option value="1">Approved</option>
                                        </select>
                                    </div>
                                    <div class="col-span-12 flex items-center mt-3">
                                        <button id="load-button" class="btn btn-primary w-32 ml-2">Load</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2" id="enrollment-list-table">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">#</th>
                        <th class="whitespace-nowrap">Student ID</th>
                        <th class="whitespace-nowrap">Full Name</th>
                        <th class="whitespace-nowrap">Student Major</th>
                        <th class="whitespace-nowrap">Year Level</th>
                        <th class="whitespace-nowrap">Contact Number</th>
                        <th class="whitespace-nowrap">Status</th>
                        <th class="whitespace-nowrap">Clearance</th>
                    </tr>
                </thead>
                <tbody >

                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
            <nav class="w-full sm:w-auto sm:mr-auto">
                <ul class="pagination">
                    <!-- Pagination links will be added here dynamically -->
                </ul>
            </nav>
            <select id="filter-size" class="w-20 form-select box mt-3 sm:mt-0">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="35">35</option>
                <option value="50">50</option>
                <option value="999999">All</option>
            </select>
        </div>
        <!-- END: Pagination -->



    @if( auth()->user()->role === 'Admin')
        @include('student.enroll.modals.enrollment_settings')
        @include('student.enroll.modals.report_list')
    @endif

@endsection

@section('scripts')
     @livewireScripts
    @powerGridScripts
    <script src="{{ asset('/js/enroll/enrolled.js') }}"></script>
@endsection
