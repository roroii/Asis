@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('Clearance') }}
@endsection

@section('content')

    <div class="grid grid-cols-12 gap-6">

        <!-- BEGIN: CLEARANCE LIST TABLE -->
        <div class="col-span-12 2xl:col-span-9">

            <div class="grid grid-cols-12 gap-6">

                <!-- BEGIN: LIST OF MY CLEARANCE -->
                <div class="col-span-12 mt-6">
                    <div class="intro-y block sm:flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            Clearance
                        </h2>
                    </div>
                    <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                        <div class="overflow-x-auto scrollbar-hidden pb-10">
                            <table id="dt_csc_clearance" class="table table-report -mt-2 table-hover">
                                <thead>
                                <tr>
                                    <th class="whitespace-nowrap">Clearance Name</th>
                                    <th class="whitespace-nowrap">Description</th>
                                    <th class="whitespace-nowrap">Status</th>
                                    <th class="whitespace-nowrap">Actions</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END: LIST OF MY CLEARANCE -->

            </div>

        </div>
        <!-- END: CLEARANCE LIST TABLE -->


        <!-- BEGIN: RIGHT SIDE PANE -->
        <div class="col-span-12 2xl:col-span-3">
            <div class="2xl:border-l -mb-10 pb-10">
                <div class="2xl:pl-6 grid grid-cols-12 gap-x-6 2xl:gap-x-0 gap-y-6">

                    <!-- BEGIN: Important Notes -->
                    <div class="col-span-12 md:col-span-6 xl:col-span-12 xl:col-start-1 xl:row-start-1 2xl:col-start-auto 2xl:row-start-auto mt-3">
                        <div class="intro-x flex items-center h-10">
                            <h2 class="text-lg font-medium truncate mr-auto">
                                Important Notes
                            </h2>
                            @if($has_signatories == true || Auth::user()->role_name == 'Admin')
                                <button class="btn px-2 border-slate-300 text-slate-600 dark:text-slate-300 mr-2 tooltip btn_add_important_notes" title="Add Notes"><i class="fa-solid fa-plus text-success w-4 h-4"></i> </button>
{{--                                <a href="javascript:;" class="ml-auto text-primary truncate flex items-center mr-4 btn_add_important_notes"> <i data-lucide="plus" class="w-4 h-4"></i> Add Notes </a>--}}
                            @endif
                            <button data-carousel="important-notes" data-target="prev" class="tiny-slider-navigator btn px-2 border-slate-300 text-slate-600 dark:text-slate-300 mr-2 tooltip" title="Preview"> <i data-lucide="chevron-left" class="w-4 h-4"></i> </button>
                            <button data-carousel="important-notes" data-target="next" class="tiny-slider-navigator btn px-2 border-slate-300 text-slate-600 dark:text-slate-300 mr-2 tooltip" title="Next"> <i data-lucide="chevron-right" class="w-4 h-4"></i> </button>
                        </div>


                        <div class="mt-5 intro-x">
                            <div class="box zoom-in mt-5">
                                <div class="tiny-slider" id="important-notes">

                                    @if(Auth::user()->role_name == 'Admin')
                                        @forelse (Admin_Load_Clearance_Important_notes() as $note)
                                            <div class="p-5 overflow-y-auto">
                                                <input id="document_note_id" name="note_id" type="text" class="form-control" value="{{ $note->id }}" hidden>

                                                <div class="text-slate-600">From: <span>{{ $note->get_Author->firstname }} {{ $note->get_Author->lastname }}</span></div>
                                                    @if($note->Unit_Office_Department_III)
                                                        <div class="text-slate-600">Office: <span>{{ $note->Unit_Office_Department_III->unit_office_dept_name }}</span></div>
                                                        <input class="hidden unit_office_dept_info" value="{{ $note->Unit_Office_Department_III->unit_office_dept_name }}">
                                                    @else
                                                        <div class="text-slate-600"><span>System Administrator</span></div>
                                                        <input class="hidden unit_office_dept_info" value="System Administrator">
                                                    @endif

                                                <div class="text-base font-normal text-justify word-wrap overflow-wrap word-break mt-2">Title: <span class="font-medium">{{ $note->title }}</span></div>
                                                <div class="text-slate-600">To: <span class="font-medium">{{ $note->get_Target_Employee->firstname.' '.$note->get_Target_Employee->lastname }}</span></div>

                                                <div class="text-slate-400 mt-1">{{ $note->updated_at->diffForHumans() }}</div>
                                                <div class="text-slate-500 text-justify mt-1 word-wrap overflow-wrap word-break">{{ $note->desc }}</div>

                                                <div class="font-medium flex mt-5">
                                                    <button type="button" class="btn btn-secondary py-1 px-2 admin_note_box_btn" data-note-content="{{ $note->desc }}" data-author-name="{{ $note->get_Author->firstname }} {{ $note->get_Author->lastname }}">View Notes</button>
                                                    @if ($note->created_by == Auth::user()->employee)
                                                        <button type="button" data-note-id="{{ $note->id }}" class="btn btn-outline-secondary py-1 px-2 ml-auto ml-auto remove_clearance_note">Dismiss</button>
                                                    @elseif (Auth::user()->role_name == 'Admin')
                                                        <button type="button" data-note-id="{{ $note->id }}" class="btn btn-outline-secondary py-1 px-2 ml-auto ml-auto remove_clearance_note">Dismiss</button>
                                                    @endif
                                                </div>

                                            </div>
                                        @empty
                                            <div class="p-5 overflow-y-auto ">

                                                <div class="text-slate-500 text-justify mt-1">No Notes Found!</div>

                                            </div>
                                        @endforelse

                                    @else
                                        @forelse (Load_My_Clearance_Notes() as $note)
                                            <div class="p-5 overflow-y-auto">
                                                <input id="document_note_id" name="note_id" type="text" class="form-control" value="{{ $note->id }}" hidden>

                                                <div class="text-slate-600">From: <span>{{ $note->get_Author->firstname }} {{ $note->get_Author->lastname }}</span></div>

                                                @if($note->Unit_Office_Department_III)
                                                    <div class="text-slate-600">Office: <span>{{ $note->Unit_Office_Department_III->unit_office_dept_name }}</span></div>
                                                    <input class="hidden unit_office_dept_info" value="{{ $note->Unit_Office_Department_III->unit_office_dept_name }}">
                                                @else
                                                    <div class="text-slate-600"><span>System Administrator</span></div>
                                                    <input class="hidden unit_office_dept_info" value="System Administrator">
                                                @endif

                                                <div class="text-base font-normal text-justify word-wrap overflow-wrap word-break mt-2">Title: <span class="font-medium">{{ $note->title }}</span></div>
                                                <div class="text-slate-600">To: <span class="font-medium">{{ $note->get_Target_Employee->firstname.' '.$note->get_Target_Employee->lastname }}</span></div>

                                                <div class="text-slate-400 mt-1">{{ $note->updated_at->diffForHumans() }}</div>
                                                <div class="text-slate-500 text-justify mt-1 word-wrap overflow-wrap word-break">{{ $note->desc }}</div>

                                                <div class="font-medium flex mt-5">
                                                    <button type="button" class="btn btn-secondary py-1 px-2 admin_note_box_btn" data-note-content="{{ $note->desc }}" data-author-name="{{ $note->get_Author->firstname }} {{ $note->get_Author->lastname }}">View Notes</button>
                                                    @if ($note->created_by == Auth::user()->employee)
                                                        <button type="button" data-note-id="{{ $note->id }}" class="btn btn-outline-secondary py-1 px-2 ml-auto ml-auto remove_clearance_note">Dismiss</button>
                                                    @elseif (Auth::user()->role_name == 'Admin')
                                                        <button type="button" data-note-id="{{ $note->id }}" class="btn btn-outline-secondary py-1 px-2 ml-auto ml-auto remove_clearance_note">Dismiss</button>
                                                    @endif
                                                </div>

                                            </div>
                                        @empty
                                            <div class="p-5 overflow-y-auto ">

                                                <div class="text-slate-500 text-justify mt-1">No Notes Found!</div>

                                            </div>
                                        @endforelse
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- END: Important Notes -->

                    <!-- BEGIN: SIGNATORIES -->
                    @if($has_signatories)
                            <div class="col-span-12 md:col-span-6 xl:col-span-4 2xl:col-span-12 mt-3">
                                <div class="intro-x flex items-center h-10">
                                    <h2 class="text-lg font-medium truncate mr-5">
                                        For Signatories
                                    </h2>
                                </div>
                                <div class="overflow-y-auto px-2 mt-5 h-half-screen clearance_signatories_list_div">

                                    <!-- NOTE: HTML DATA ARE LOADED FROM THE JAVASCRIPT NG INA MO -->

                                </div>
                            </div>
                    @endif
                    <!-- END: SIGNATORIES -->

                    <!-- BEGIN: RECENT ACTIVITIES -->
                    <div class="col-span-12 md:col-span-6 xl:col-span-4 2xl:col-span-12 mt-3">
                        <div class="intro-x flex items-center h-10">
                            <h2 class="text-lg font-medium truncate mr-5">
                                Recent Activities
                            </h2>
                        </div>
                        <div class="mt-5 relative before:block before:absolute before:w-px before:h-[85%] before:bg-slate-200 before:dark:bg-darkmode-400 before:ml-5 before:mt-5 recent_activity_list_div">

                            <!-- LOADED FROM JAVASCRIPT NG INA MO!! -->

                        </div>
                    </div>
                    <!-- END: RECENT ACTIVITIES -->

                </div>
            </div>
        </div>
        <!-- END: RIGHT SIDE PANE -->

    </div>


    @include('clearanceSignatories.modal.csc_clearance')

@endsection

@section('scripts')

    <script src="{{BASEPATH()}}/js/clearance/clearance.js{{GET_RES_TIMESTAMP()}}"></script>
    <script src="{{BASEPATH()}}/js/clearance/csc_clearance.js{{GET_RES_TIMESTAMP()}}"></script>
    <script src="{{BASEPATH()}}/js/dropdown.js{{GET_RES_TIMESTAMP()}}"></script>


@endsection
