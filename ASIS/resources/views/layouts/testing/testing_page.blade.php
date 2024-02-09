@extends('layouts.app')

@section('breadcrumb')
    {{-- {{ Breadcrumbs::render('Application') }} --}}
@endsection

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Employment Testing
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6">
        <!-- BEGIN: FAQ Menu -->
        <div class="intro-y col-span-12 lg:col-span-4 xl:col-span-3">
            <div class="box mt-5 ">
                <div class="px-4 pb-3 pt-5 rounded-md overflow-y-auto bg-primary text-white font-medium">
                    <h1>Categories</h1>
                </div>

                <div class="px-4 pb-3 pt-5 overflow-y-auto h-half-screen">
                    <a id="t_part" href="javascript:;" class="flex items-center px-3 py-2 rounded-md"> <i class="fa-sharp fa-solid fa-circles-overlap"></i> Test Part </a>
                    <a id="testQ_type" href="javascript:;" class="flex items-center px-3 py-2 mt-2 rounded-md"> <i class="fa-sharp fa-regular fa-text-width"></i> Test Question Types </a>
                    <a id="t_question" href="javascript:;" class="flex items-center px-3 py-2 mt-2 rounded-md"> <i class="fa-sharp fa-light fa-ballot-check"></i> Test Question </a>
                    <a id="t_choice" href="javascript:;" class="flex items-center px-3 py-2 mt-2 rounded-md"> <i class="fa-solid fa-camera-web"></i> Test Choices </a>
                    {{-- <a href="" class="flex items-center px-3 py-2 mt-2 rounded-md"> <i class="w-4 h-4 mr-2" data-lucide="trash"></i> Trash </a> --}}
                </div>
            </div>

        </div>
        <!-- END: FAQ Menu -->
        <!-- BEGIN: FAQ Content -->
        <div class="intro-y col-span-12 lg:col-span-8 xl:col-span-9">
            <div class="intro-y box lg:mt-5">
                <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 id="job_title" class="font-medium text-base mr-auto">

                    </h2>
                    <button id="addTest_part" class="btn btn-primary w-32 mr-2 mb-2"> <i data-lucide="Plus-circle" class="w-4 h-4 mr-2"></i> Add </button>
                </div>

                <div id="test_div" class="accordion accordion-boxed p-5">

                </div>
            </div>

        </div>
        <!-- END: FAQ Content -->
    </div>
    @include('testing.testing_modal.add_edit_part_modal');
@endsection
@section('scripts')
    <script src="{{ asset('/js/testing/testing.js') }}"></script>
{{--    <script src="{{ asset('/js/application/TOR_pond.js') }}"></script>--}}
{{--    <script src="{{ asset('/js/application/diploma_pond.js') }}"></script>--}}
{{--    <script src="{{ asset('/js/application/certificates_pond.js') }}"></script>--}}
{{--    <script src="{{ asset('/js/application/profile_picture_pond.js') }}"></script>--}}
@endsection
