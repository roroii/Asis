@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('Enrollee_Schedule') }}
@endsection

@section('content')

    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Calendar
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-5 mt-5">

        <!-- BEGIN: LEFT PANEL -->
        <div class="col-span-12 lg:col-span-4 2xl:col-span-3">
            <div class="box p-5 rounded-md">
                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                    <div class="font-medium text-base truncate">Appointment Schedule:</div>
                </div>
                <div class="flex items-center"> <i data-lucide="calendar" class="w-4 h-4 text-slate-500 mr-2"></i> Date: <input class="hidden scheduled_date_value"> <input class="hidden scheduled_date_text"> <input class="hidden scheduled_date_id"> <span class="scheduled_date text-slate-600 text-xs ml-2"></span> </div>
                <div class="flex items-center mt-3"> <i data-lucide="home" class="w-4 h-4 text-slate-500 mr-2"></i> Campus: <span class="scheduled_campus text-slate-600 text-xs ml-2"></span> </div>
                <div class="flex items-center mt-3"> <i data-lucide="globe" class="w-4 h-4 text-slate-500 mr-2"></i>Address:<span class="campus_address text-slate-600 text-xs ml-2"></span> </div>
                <div class="flex items-center border-t border-slate-200/60 dark:border-darkmode-400 pt-5 mt-5 font-medium">
                    <button id="btn_submit_appointment" type="button" class="btn btn-primary border-dashed  w-full py-1 px-2"> <i data-lucide="send" class="w-4 h-4 mr-2"> </i> Submit Appointment</button>
                </div>
            </div>

            <!-- BEGIN: NOTE: -->
            <div class="mt-10 bg-warning/20 dark:bg-darkmode-600 border border-warning dark:border-0 rounded-md relative p-5">
                <i data-lucide="lightbulb" class="w-12 h-12 text-warning/80 absolute top-0 right-0 mt-5 mr-3"></i>
                <h2 class="text-lg font-medium">
                    NOTE:
                </h2>
{{--                <div class="mt-5 font-medium">Price</div>--}}
                <div class="leading-relaxed text-xs mt-2 text-slate-600 dark:text-slate-500 mt-10">
                    <div>To set your appointment schedule, please click on the AM or PM button.</div>

                </div>
            </div>
            <!-- END: NOTE: -->
        </div>
        <!-- END: LEFT PANEL -->


        <!-- BEGIN: Calendar Content -->
        <div class="col-span-12 xl:col-span-8 2xl:col-span-9">
            <div class="box p-5">
                <div class="full-calendar " id="enrollees_calendar"></div>
            </div>
        </div>
        <!-- END: Calendar Content -->

        @include('pre_enrollees.Schedule.modal')
    </div>

@endsection
@section('scripts')


    <!--    FULL CALENDAR   -->
    <!--    FULL CALENDAR   -->
    <script src="{{BASEPATH()}}/js/schedule/fullcalendar/dist/index.global.js{{GET_RES_TIMESTAMP()}}"></script>
    <script src="{{BASEPATH()}}/js/schedule/enrollee_calendar/enrollee_fullCalendar.js{{GET_RES_TIMESTAMP()}}"></script>

@endsection
