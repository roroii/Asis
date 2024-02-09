@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('Clearance Overview') }}
@endsection

@section('content')


    <div class="grid grid-cols-12 gap-6">

        <div class="col-span-12 2xl:col-span-8">
            <div class="grid grid-cols-12 gap-6">

                <!-- BEGIN: STUDENT CLEARANCE -->
                <div class="col-span-12 mt-6">
                    <div class="intro-y block sm:flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            Clearance
                        </h2>
                        <div class="flex items-center sm:ml-auto mt-3 sm:mt-0">
                            <button id="btn_create_clearance" class="ml-3 btn box flex items-center text-slate-600 dark:text-slate-300"
                            >
                                <i data-lucide="plus" class="hidden sm:block w-4 h-4 mr-2"></i> Create Clearance
                            </button>
                        </div>
                    </div>
                    <div class="intro-y overflow-x-auto mt-8 sm:mt-0">
                        <table id="clearance_list_tbl" class="table table-report sm:mt-2">
                            <thead>
                            <tr>
                                <th class="whitespace-nowrap">Clearance Name</th>
                                <th class="whitespace-nowrap">Type</th>
                                <th class="whitespace-nowrap">Course</th>
                                <th class="whitespace-nowrap">School Year - Semester</th>
                                <th class="text-center whitespace-nowrap">SIGNATORIES</th>
                                <th class="text-center whitespace-nowrap">STATUS</th>
                                <th class="text-center whitespace-nowrap">ACTIONS</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                    <!-- BEGIN: Pagination -->
                    <div class="intro-y flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-3">
                        <nav class="w-full sm:w-auto sm:mr-auto">
                            <ul class="pagination">
                                <!-- Pagination links will be added here dynamically -->
                            </ul>
                        </nav>
                        <select id="filter-size_clearance" class="w-20 form-select box mt-3 sm:mt-0">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="35">35</option>
                            <option value="50">50</option>
                            <option value="999999">All</option>
                        </select>
                    </div>
                    <!-- END: Pagination -->


                </div>
                <!-- END: STUDENT CLEARANCE -->

                <!-- BEGIN: CLEARANCE IMPORTANT NOTES-->
                <div class="col-span-12 mt-6">
                    <div class="intro-x flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-auto">
                            Important Notes
                        </h2>
                        <button data-carousel="important-notes" data-target="prev" class="tiny-slider-navigator btn px-2 border-slate-300 text-slate-600 dark:text-slate-300 mr-2"> <i data-lucide="chevron-left" class="w-4 h-4"></i> </button>
                        <button data-carousel="important-notes" data-target="next" class="tiny-slider-navigator btn px-2 border-slate-300 text-slate-600 dark:text-slate-300 mr-2"> <i data-lucide="chevron-right" class="w-4 h-4"></i> </button>

                        <button id="btn_create_notes" class="ml-3 btn box flex items-center text-slate-600 dark:text-slate-300"
                        >
                            <i data-lucide="plus" class="hidden sm:block w-4 h-4 mr-2"></i> Create Note
                        </button>

                    </div>


                    <div class="mt-5 intro-x">
                        <div class="box zoom-in mt-5">
                            <div class="tiny-slider" id="important-notes">

                                @forelse (adminGetMyCreatedClearanceImportantNotes() as $note)
                                    <div class="p-5">
                                        <div class="text-base font-medium truncate">{{ $note->title  }}</div>
                                        <div class="text-xs text-slate-400 mt-1">{{ $note->program  }}</div>
                                        <div class="text-slate-400 mt-1">{{ Carbon\Carbon::parse($note->created_at)->format('d F Y')  }}</div>
                                        <div class="text-slate-500 text-justify mt-3">{{ $note->note  }}</div>
                                        <div class="font-medium flex mt-5">
                                            <button style="visibility: hidden" type="button" class="btn btn-secondary py-1 px-2">View Notes</button>
                                            <button type="button" data-note-id="{{ $note->id }}" class="btn btn-outline-secondary py-1 px-2 ml-auto ml-auto btn_dismiss_notes">Dismiss</button>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-5 overflow-y-auto ">

                                        <div class="text-slate-500 text-justify mt-1">No Notes Found!</div>

                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>


                </div>
                <!-- END: CLEARANCE IMPORTANT NOTES -->


            </div>
        </div>

        <!-- BEGIN: SIDE PANEL -->
        <div class="col-span-12 2xl:col-span-4">
            <div class="2xl:border-l -mb-10 pb-10">
                <div class="2xl:pl-6 grid grid-cols-12 gap-x-6 2xl:gap-x-0 gap-y-6">

                    <!-- BEGIN: FOR SIGNATORY -->
                    <div class="col-span-12 md:col-span-6 xl:col-span-4 2xl:col-span-12 mt-3">
                        <div class="intro-x flex items-center h-10">
                            <h2 class="text-lg font-medium truncate mr-5">
                                For Signatory
                            </h2>

                            <div style="visibility: hidden" class="ml-auto w-56 relative text-slate-500">
                                <input type="text" class="form-control w-56 box pr-10" id="filter-search-students" placeholder="Search...">
                                <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                            </div>
                        </div>

                        <div class="mt-5">

                            <div id="signatory_div" >

                            </div>

                            <a href="javascript:;" class="btn_admin_view_more_signatories btn btn-outline-secondary intro-x w-full block text-center rounded-md py-3 border border-dotted border-slate-400 dark:border-darkmode-300 text-slate-500">View More</a>

                        </div>

                    </div>
                    <!-- END: FOR SIGNATORY -->


                </div>
            </div>
        </div>
        <!-- END: SIDE PANEL -->


    </div>


    @include('admin.ASIS.clearance.modal')

@endsection

@section('scripts')

    {{--    @livewireStyles--}}
    {{--    @livewireScripts--}}
    {{--    @powerGridScripts--}}


    <script src="{{BASEPATH()}}/js/dropdown.js{{GET_RES_TIMESTAMP()}}"></script>
    <script src="{{BASEPATH()}}/js/ASIS_js/student_clearance/admin_clearance.js{{GET_RES_TIMESTAMP()}}"></script>
    <script src="{{BASEPATH()}}/js/ASIS_js/student_clearance/clearance_overview.js{{GET_RES_TIMESTAMP()}}"></script>

@endsection
