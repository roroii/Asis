@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('Overview') }}
@endsection

@section('content')



    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 2xl:col-span-9">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: General Report -->
                <div class="col-span-12 mt-8">
                    <div class="intro-y flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            General Report
                        </h2>
                        <a href="" class="ml-auto flex items-center text-primary"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="refresh-ccw" data-lucide="refresh-ccw" class="lucide lucide-refresh-ccw w-4 h-4 mr-3"><path d="M3 2v6h6"></path><path d="M21 12A9 9 0 006 5.3L3 8"></path><path d="M21 22v-6h-6"></path><path d="M3 12a9 9 0 0015 6.7l3-2.7"></path></svg> Reload Data </a>
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-5">

                        <div class="col-span-12 sm:col-span-6 xl:col-span-6 intro-y">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="shopping-cart" data-lucide="shopping-cart" class="lucide lucide-shopping-cart report-box__icon text-primary"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"></path></svg>
                                        <div class="ml-auto">
                                            <div class="report-box__indicator bg-primary cursor-pointer">  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="chevron-up" data-lucide="chevron-up" class="lucide lucide-chevron-up w-4 h-4 ml-0.5"><polyline points="18 15 12 9 6 15"></polyline></svg> </div>
                                        </div>
                                    </div>

                                    @if($Clearance_request_count != 0)
                                        <div class="text-3xl font-medium leading-8 mt-6 clearance_count_request_div">{{ $Clearance_request_count }}</div>
                                    @else
                                        <div class="text-3xl font-medium leading-8 mt-6">0</div>
                                    @endif
                                    <div class="text-base text-slate-500 mt-1">Clearance Request(s)</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-span-12 sm:col-span-6 xl:col-span-6 intro-y completed_clearance_box">
                            <div class="report-box zoom-in">
                                <div class="box p-5">
                                    <div class="flex">
                                        <i data-lucide="clipboard-check" class="w-8 h-8 text-success"></i>
                                        <div class="ml-auto">
                                            <div class="report-box__indicator bg-success tooltip cursor-pointer">  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="chevron-down" data-lucide="chevron-down" class="lucide lucide-chevron-down w-4 h-4 ml-0.5"><polyline points="6 9 12 15 18 9"></polyline></svg> </div>
                                        </div>
                                    </div>
                                    @if($Clearance_completed_count != 0)
                                        <div class="text-3xl font-medium leading-8 mt-6 ">{{ $Clearance_completed_count }}</div>
                                    @else
                                        <div class="text-3xl font-medium leading-8 mt-6">0</div>
                                    @endif
                                    <div class="text-base text-slate-500 mt-1">Completed Clearance</div>
                                </div>
                            </div>
                        </div>

{{--                        <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">--}}
{{--                            <div class="report-box zoom-in">--}}
{{--                                <div class="box p-5">--}}
{{--                                    <div class="flex">--}}
{{--                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="monitor" data-lucide="monitor" class="lucide lucide-monitor report-box__icon text-warning"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>--}}
{{--                                        <div class="ml-auto">--}}
{{--                                            <div class="report-box__indicator bg-success tooltip cursor-pointer"> 12% <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="chevron-up" data-lucide="chevron-up" class="lucide lucide-chevron-up w-4 h-4 ml-0.5"><polyline points="18 15 12 9 6 15"></polyline></svg> </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="text-3xl font-medium leading-8 mt-6">15</div>--}}
{{--                                    <div class="text-base text-slate-500 mt-1">Clearance Printed</div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                    </div>
                </div>
                <!-- END: General Report -->

                <!-- BEGIN: Important Notes -->
                <div class="col-span-12 lg:col-span-6 mt-8">
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
                </div>
                <!-- END: Important Notes -->

                <!-- BEGIN: Cleared Employees -->
                <div class="col-span-12 lg:col-span-6 mt-8">
                    <div class="intro-y flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            Cleared Employees
                        </h2>
                    </div>
                    <div class="intro-y box p-5 mt-5">
                        <div class="mt-3">
                            <div class="h-[213px]">
                                <canvas id="report-pie-chart" width="233" height="213" style="display: block; box-sizing: border-box; height: 213px; width: 233px;"></canvas>
                            </div>
                        </div>
                        <div class="w-52 sm:w-auto mx-auto mt-8">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-primary rounded-full mr-3"></div>
                                <span class="truncate">17 - 30 Years old</span> <span class="font-medium ml-auto">62%</span>
                            </div>
                            <div class="flex items-center mt-4">
                                <div class="w-2 h-2 bg-pending rounded-full mr-3"></div>
                                <span class="truncate">31 - 50 Years old</span> <span class="font-medium ml-auto">33%</span>
                            </div>
                            <div class="flex items-center mt-4">
                                <div class="w-2 h-2 bg-warning rounded-full mr-3"></div>
                                <span class="truncate">&gt;= 50 Years old</span> <span class="font-medium ml-auto">10%</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Cleared Employees -->

{{--                <!-- BEGIN: Sales Report -->--}}
{{--                <div class="col-span-12 sm:col-span-6 lg:col-span-3 mt-8">--}}
{{--                    <div class="intro-y flex items-center h-10">--}}
{{--                        <h2 class="text-lg font-medium truncate mr-5">--}}
{{--                            Sales Report--}}
{{--                        </h2>--}}
{{--                        <a href="" class="ml-auto text-primary truncate">Show More</a>--}}
{{--                    </div>--}}
{{--                    <div class="intro-y box p-5 mt-5">--}}
{{--                        <div class="mt-3">--}}
{{--                            <div class="h-[213px]">--}}
{{--                                <canvas id="report-donut-chart" width="233" height="213" style="display: block; box-sizing: border-box; height: 213px; width: 233px;"></canvas>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="w-52 sm:w-auto mx-auto mt-8">--}}
{{--                            <div class="flex items-center">--}}
{{--                                <div class="w-2 h-2 bg-primary rounded-full mr-3"></div>--}}
{{--                                <span class="truncate">17 - 30 Years old</span> <span class="font-medium ml-auto">62%</span>--}}
{{--                            </div>--}}
{{--                            <div class="flex items-center mt-4">--}}
{{--                                <div class="w-2 h-2 bg-pending rounded-full mr-3"></div>--}}
{{--                                <span class="truncate">31 - 50 Years old</span> <span class="font-medium ml-auto">33%</span>--}}
{{--                            </div>--}}
{{--                            <div class="flex items-center mt-4">--}}
{{--                                <div class="w-2 h-2 bg-warning rounded-full mr-3"></div>--}}
{{--                                <span class="truncate">&gt;= 50 Years old</span> <span class="font-medium ml-auto">10%</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <!-- END: Sales Report -->--}}


                <!-- BEGIN: Created Clearance -->

                <div class="col-span-12 mt-6">
                    <div class="intro-y block sm:flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            Clearance Created
                        </h2>
                        <div class="flex items-center sm:ml-auto mt-3 sm:mt-0">

                            {{-- {{ dd(Session::has('get_user_priv')) }} --}}
                            @if(Session::has('get_user_priv'))

                                @if (Session::get('get_user_priv')[0]->create == 1)
                                    <button id="btn_toggle_create_clearance_mdl" class="btn btn-primary items-center">Create Clearance</button>
                                @endif

                            @elseif(Auth::user()->role_name == 'Admin')
                                <button id="btn_toggle_create_clearance_mdl" class="btn btn-primary items-center">Create Clearance</button>
                            @endif
                        </div>
                    </div>
                    <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">

                        <div class="overflow-x-auto scrollbar-hidden pb-10">
                            <table id="dt_created_csc_clearance" class="table table-report -mt-2 table-hover">
                                <thead>
                                <tr>
                                    <th class="whitespace-nowrap">Clearance Name</th>
                                    <th class="whitespace-nowrap">Description</th>
                                    <th class="whitespace-nowrap">Status</th>
                                    <th class="whitespace-nowrap">State</th>
                                    <th class="whitespace-nowrap">Actions</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END: Created Clearance -->

            </div>

        </div>
        <div class="col-span-12 2xl:col-span-3">
            <div class="2xl:border-l -mb-10 pb-10">
                <div class="2xl:pl-6 grid grid-cols-12 gap-x-6 2xl:gap-x-0 gap-y-6">

                    <!-- BEGIN: Request List -->
                    <div class="col-span-12 md:col-span-6 xl:col-span-4 2xl:col-span-12 mt-3">
                        <div class="intro-x flex items-center h-10">
                            <h2 class="text-lg font-medium truncate mr-5">
                                Clearance Requests
                            </h2>
                        </div>


                        <div class="overflow-y-auto h-half-screen p-5 clearance_request_list_div">

                            <!-- NOTE: HTML DATA ARE LOADED FROM THE JAVASCRIPT NG INA MO -->

                        </div>

                    </div>
                    <!-- END: Request List -->



                </div>
            </div>
        </div>
    </div>

    @include('clearanceSignatories.modal.csc_clearance')

@endsection

@section('scripts')

    <script src="{{BASEPATH()}}/js/clearance/clearance.js{{GET_RES_TIMESTAMP()}}"></script>
    <script src="{{BASEPATH()}}/js/clearance/overview.js{{GET_RES_TIMESTAMP()}}"></script>
    <script src="{{BASEPATH()}}/js/clearance/csc_clearance.js{{GET_RES_TIMESTAMP()}}"></script>
    <script src="{{BASEPATH()}}/js/dropdown.js{{GET_RES_TIMESTAMP()}}"></script>


@endsection
