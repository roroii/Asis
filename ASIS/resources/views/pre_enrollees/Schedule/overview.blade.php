@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('Enrollees_Overview') }}
@endsection

@section('content')

    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Calendar
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-5 mt-5">


        <!-- BEGIN: Calendar Side Menu -->
        <div class="col-span-12 xl:col-span-4 2xl:col-span-3">
            <div class="box p-5 intro-y">
                <button type="button" class="btn btn-primary w-full mt-2 btn_add_enrollees_schedule"> <i class="w-4 h-4 mr-2" data-lucide="edit-3"></i> Add New Schedule </button>

                <div class="border-t border-b border-slate-200/60 dark:border-darkmode-400 mt-6 mb-5 py-3" id="calendar-events">

                    <div class="relative fc-event">
                        <div class="event p-3 -mx-3 cursor-pointer transition duration-300 ease-in-out hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md flex items-center">
                            <div class="w-2 h-2 bg-pending rounded-full mr-3"></div>
                            <div class="pr-10">
                                <div class="event__title truncate">asfasfasg ajsfhajksff</div>
                                <div class="text-slate-500 text-xs mt-0.5"> <span class="event__days">2</span> Days <span class="mx-1">•</span> 10:00 AM </div>
                            </div>
                        </div>
                        <a class="flex items-center absolute top-0 bottom-0 my-auto right-0" href=""> <i data-lucide="edit" class="w-4 h-4 text-slate-500"></i> </a>
                    </div>
                    <div class="relative fc-event">
                        <div class="event p-3 -mx-3 cursor-pointer transition duration-300 ease-in-out hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md flex items-center">
                            <div class="w-2 h-2 bg-warning rounded-full mr-3"></div>
                            <div class="pr-10">
                                <div class="event__title truncate">Vue Fes Japan 2019</div>
                                <div class="text-slate-500 text-xs mt-0.5"> <span class="event__days">3</span> Days <span class="mx-1">•</span> 07:00 AM </div>
                            </div>
                        </div>
                        <a class="flex items-center absolute top-0 bottom-0 my-auto right-0" href=""> <i data-lucide="edit" class="w-4 h-4 text-slate-500"></i> </a>
                    </div>
                    <div class="relative fc-event">
                        <div class="event p-3 -mx-3 cursor-pointer transition duration-300 ease-in-out hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md flex items-center">
                            <div class="w-2 h-2 bg-pending rounded-full mr-3"></div>
                            <div class="pr-10">
                                <div class="event__title truncate">Laracon 2021</div>
                                <div class="text-slate-500 text-xs mt-0.5"> <span class="event__days">4</span> Days <span class="mx-1">•</span> 11:00 AM </div>
                            </div>
                        </div>
                        <a class="flex items-center absolute top-0 bottom-0 my-auto right-0" href=""> <i data-lucide="edit" class="w-4 h-4 text-slate-500"></i> </a>
                    </div>

                    <div class="text-slate-500 p-3 text-center hidden" id="calendar-no-events">No events yet</div>
                </div>

                <div class="form-check form-switch flex">
                    <label class="form-check-label" for="checkbox-events">Remove after drop</label>
                    <input class="show-code form-check-input ml-auto" type="checkbox" id="checkbox-events">
                </div>
            </div>


        </div>
        <!-- END: Calendar Side Menu -->

        <!-- BEGIN: Calendar Content -->
        <div class="col-span-12 xl:col-span-8 2xl:col-span-9">
            <div class="box p-5">
                <div class="full-calendar" id="enrollees_calendar"></div>
            </div>
        </div>
        <!-- END: Calendar Content -->

        @include('pre_enrollees.Schedule.modal')
    </div>

@endsection
@section('scripts')


    <!--    FULL CALENDAR   -->
{{--    <script src="{{BASEPATH()}}/js/schedule/fullcalendar/dist/index.global.js{{GET_RES_TIMESTAMP()}}"></script>--}}
{{--    <script src="{{BASEPATH()}}/js/schedule/fullcalendar/fullcalendar.js{{GET_RES_TIMESTAMP()}}"></script>--}}

{{--    <script src="{{BASEPATH()}}/js/schedule/enrollees_schedule.js{{GET_RES_TIMESTAMP()}}"></script>--}}

    <script src="{{BASEPATH()}}/assets/mycalendar/calendar.js{{GET_RES_TIMESTAMP()}}"></script>

@endsection
