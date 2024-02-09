@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('Application') }}
@endsection

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Job Opportunities List
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6">
        <!-- BEGIN: FAQ Menu -->
        <div class="intro-y col-span-12 lg:col-span-4 xl:col-span-3">
            <div class="box mt-5">
{{--                <button id="test_btn" class="btn btn-primary"> Test </button>--}}
                <div id="available_pos_div"  class="px-4 pb-3 pt-5 overflow-y-auto h-half-screen available_pos_div">

                </div>
            </div>
        </div>
        <!-- END: FAQ Menu -->
        <!-- BEGIN: FAQ Content -->
        <div id="job_list_desc_div" class="intro-y col-span-12 lg:col-span-8 xl:col-span-9">
            <div class="intro-y box lg:mt-5">
                <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 id="job_title" class="font-medium text-base mr-auto">
                    </h2>

                    <div id="btn_apply_div">

                    </div>

                </div>

                <div class="intro-y p-5">
                    <div style="border-radius: 0.40rem; border-width: 1px;border-color: rgb(var(--color-slate-200) / 0.6);"  class="overflow-x-auto scrollbar-hidden">
                        <table id="table_job_list" class="my-table">
                            <tbody>
                            </tbody>

                        </table>
                    </div>
                </div>

                <div id="faq-accordion-1" class="accordion accordion-boxed px-5 pb-5">

{{--                    <div class="accordion-item">--}}
{{--                        <div id="faq-accordion-content-2" class="accordion-header">--}}
{{--                            <button class="accordion-button collapsed" type="button" data-tw-toggle="collapse" data-tw-target="#faq-accordion-collapse-2" aria-expanded="false" aria-controls="faq-accordion-collapse-2"> Understanding IP Addresses, Subnets, and CIDR Notation </button>--}}
{{--                        </div>--}}
{{--                        <div id="faq-accordion-collapse-2" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-2" data-tw-parent="#faq-accordion-1">--}}
{{--                            <div class="accordion-body text-slate-600 dark:text-slate-500 leading-relaxed"> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="accordion-item">--}}
{{--                        <div id="faq-accordion-content-3" class="accordion-header">--}}
{{--                            <button class="accordion-button collapsed" type="button" data-tw-toggle="collapse" data-tw-target="#faq-accordion-collapse-3" aria-expanded="false" aria-controls="faq-accordion-collapse-3"> How To Troubleshoot Common HTTP Error Codes </button>--}}
{{--                        </div>--}}
{{--                        <div id="faq-accordion-collapse-3" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-3" data-tw-parent="#faq-accordion-1">--}}
{{--                            <div class="accordion-body text-slate-600 dark:text-slate-500 leading-relaxed"> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="accordion-item">--}}
{{--                        <div id="faq-accordion-content-4" class="accordion-header">--}}
{{--                            <button class="accordion-button collapsed" type="button" data-tw-toggle="collapse" data-tw-target="#faq-accordion-collapse-4" aria-expanded="false" aria-controls="faq-accordion-collapse-4"> An Introduction to Securing your Linux VPS </button>--}}
{{--                        </div>--}}
{{--                        <div id="faq-accordion-collapse-4" class="accordion-collapse collapse" aria-labelledby="faq-accordion-content-4" data-tw-parent="#faq-accordion-1">--}}
{{--                            <div class="accordion-body text-slate-600 dark:text-slate-500 leading-relaxed"> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>

            </div>

        </div>
        <!-- END: FAQ Content -->
        @include('application.modal.attach_resume_modal')
        @include('application.modal.information_modal')
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('/js/application/job_application.js') }}"></script>
    <script src="{{ asset('/js/application/attachments_pond.js') }}"></script>
    <script src="{{ asset('/js/application/resume_pond.js') }}"></script>
{{--    <script src="{{ asset('/js/application/diploma_pond.js') }}"></script>--}}
{{--    <script src="{{ asset('/js/application/certificates_pond.js') }}"></script>--}}
{{--    <script src="{{ asset('/js/application/profile_picture_pond.js') }}"></script>--}}
@endsection
