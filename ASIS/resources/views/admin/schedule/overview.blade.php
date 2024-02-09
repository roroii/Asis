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


        <!-- BEGIN: Calendar Content -->
        <div class="col-span-12 xl:col-span-8 2xl:col-span-9">
            <div class="box p-5">
                <div class="full-calendar " id="admin_calendar"></div>
            </div>
        </div>
        <!-- END: Calendar Content -->


        <!-- BEGIN: Calendar Side Menu -->
        <div class="col-span-12 xl:col-span-4 2xl:col-span-3">
            <div class="box p-5 intro-y">
                <!-- BEGIN: Transactions -->
                <div class="col-span-12 md:col-span-6 xl:col-span-4 2xl:col-span-12">
                    <div class="intro-y block sm:flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            Recent Activities
                        </h2>

                        <div class="sm:ml-auto mt-3 sm:mt-0 relative text-slate-500">
                            <i data-lucide="search" class="w-4 h-4 z-10 absolute my-auto inset-y-0 ml-3 left-0"></i>
                            <input type="text" class="form-control sm:w-40 box pl-10 input_search_name" placeholder="Filter by name">
                        </div>

                    </div>

                    <div class="mt-5 p-3 overflow-y-auto h-70-vh-screen transaction_list_div ">
                        {{--                        <a href="" class="intro-x w-full block text-center rounded-md py-3 border border-dotted border-slate-400 dark:border-darkmode-300 text-slate-500">View More</a>--}}
                    </div>
                </div>
                <!-- END: Transactions -->
            </div>


        </div>
        <!-- END: Calendar Side Menu -->

        @include('pre_enrollees.Schedule.modal')
    </div>

@endsection
@section('scripts')


    <!--    FULL CALENDAR   -->
    <script src="{{BASEPATH()}}/js/schedule/fullcalendar/dist/index.global.js{{GET_RES_TIMESTAMP()}}"></script>
    <script src="{{BASEPATH()}}/js/schedule/fullcalendar/fullcalendar.js{{GET_RES_TIMESTAMP()}}"></script>
    <script src="{{BASEPATH()}}/js/schedule/enrollees_schedule.js{{GET_RES_TIMESTAMP()}}"></script>

@endsection
