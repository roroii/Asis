@extends('layouts.app')
@section('breadcrumb')
    {{ Breadcrumbs::render('Dashboard') }}
@endsection

@section('content')

<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 2xl:col-span-9 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center">
            <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                <button id="btn_hiringopen_modal" class="btn btn-primary shadow-md mr-2"  data-tw-toggle="modal" data-tw-target="#create_survey_modal">Create Survey</button>
            </div>
        </div>
        <div class="grid grid-cols-12 gap-6 box p-5 rounded-md mt-2">
            <!-- BEGIN: Weekly Top Products -->
            <div class="col-span-12 mt-6">
                <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                    <table id="survey_satisfaction_dt" class="table table-report bordered table-hover dt-responsive nowrap">
                        <thead class="">
                            <tr>
                                <th class="text-center whitespace-nowrap">Rating Range</th>
                                <th class="text-center whitespace-nowrap">Adjectival</th>
                                <th class="text-center whitespace-nowrap">Activate</th>
                                <th class="text-center whitespace-nowrap">Active</th>
                                <th class="text-center whitespace-nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END: Weekly Top Products -->
        </div>
    </div>
    <div class="col-span-12 2xl:col-span-3">
        <div class="2xl:border-l -mb-10 pb-10">
            <div class="2xl:pl-6 grid grid-cols-12 gap-x-6 2xl:gap-x-0 gap-y-6">
                <!-- BEGIN: Important Notes -->
                <div class="col-span-12 md:col-span-6 xl:col-span-12 mt-3 2xl:mt-8">
                    <div class="intro-x flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-auto">
                            Important Notes
                        </h2>
                        <button data-carousel="important-notes" data-target="prev" class="tiny-slider-navigator btn px-2 border-slate-300 text-slate-600 dark:text-slate-300 mr-2"> <i data-lucide="chevron-left" class="w-4 h-4"></i> </button>
                        <button data-carousel="important-notes" data-target="next" class="tiny-slider-navigator btn px-2 border-slate-300 text-slate-600 dark:text-slate-300 mr-2"> <i data-lucide="chevron-right" class="w-4 h-4"></i> </button>
                    </div>
                    <div class="mt-5 intro-x">
                        <div class="box rounded-md zoom-in">
                            <div class="tiny-slider" id="important-notes">
                                <div class="p-5">
                                    <div class="text-base font-medium truncate">Lorem Ipsum is simply dummy text</div>
                                    <div class="text-slate-400 mt-1">20 Hours ago</div>
                                    <div class="text-slate-500 text-justify mt-1">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</div>
                                    <div class="font-medium flex mt-5">
                                        <button type="button" class="btn btn-secondary py-1 px-2">View Notes</button>
                                        <button type="button" class="btn btn-outline-secondary py-1 px-2 ml-auto ml-auto">Dismiss</button>
                                    </div>
                                </div>
                                <div class="p-5">
                                    <div class="text-base font-medium truncate">Lorem Ipsum is simply dummy text</div>
                                    <div class="text-slate-400 mt-1">20 Hours ago</div>
                                    <div class="text-slate-500 text-justify mt-1">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</div>
                                    <div class="font-medium flex mt-5">
                                        <button type="button" class="btn btn-secondary py-1 px-2">View Notes</button>
                                        <button type="button" class="btn btn-outline-secondary py-1 px-2 ml-auto ml-auto">Dismiss</button>
                                    </div>
                                </div>
                                <div class="p-5">
                                    <div class="text-base font-medium truncate">Lorem Ipsum is simply dummy text</div>
                                    <div class="text-slate-400 mt-1">20 Hours ago</div>
                                    <div class="text-slate-500 text-justify mt-1">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</div>
                                    <div class="font-medium flex mt-5">
                                        <button type="button" class="btn btn-secondary py-1 px-2">View Notes</button>
                                        <button type="button" class="btn btn-outline-secondary py-1 px-2 ml-auto ml-auto">Dismiss</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Important Notes -->
                 <!-- BEGIN: Transactions -->
                 <div class="col-span-12 md:col-span-6 xl:col-span-4 2xl:col-span-12 mt-3">
                    <div class="intro-x flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            Recent Task
                        </h2>
                    </div>
                    <div class="mt-5">
                        <div class="intro-x">
                            <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                    <img alt="Midone - HTML Admin Template" src="dist/images/profile-3.jpg">
                                </div>
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">Angelina Jolie</div>
                                    <div class="text-slate-500 text-xs mt-0.5">15 November 2022</div>
                                </div>
                                <div class="text-danger">-$79</div>
                            </div>
                        </div>
                        <div class="intro-x">
                            <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                    <img alt="Midone - HTML Admin Template" src="dist/images/profile-7.jpg">
                                </div>
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">Brad Pitt</div>
                                    <div class="text-slate-500 text-xs mt-0.5">27 April 2020</div>
                                </div>
                                <div class="text-danger">-$94</div>
                            </div>
                        </div>
                        <div class="intro-x">
                            <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                    <img alt="Midone - HTML Admin Template" src="dist/images/profile-9.jpg">
                                </div>
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">Kevin Spacey</div>
                                    <div class="text-slate-500 text-xs mt-0.5">6 December 2020</div>
                                </div>
                                <div class="text-success">+$89</div>
                            </div>
                        </div>
                        <div class="intro-x">
                            <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                    <img alt="Midone - HTML Admin Template" src="dist/images/profile-7.jpg">
                                </div>
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">Tom Cruise</div>
                                    <div class="text-slate-500 text-xs mt-0.5">22 November 2020</div>
                                </div>
                                <div class="text-danger">-$27</div>
                            </div>
                        </div>
                        <div class="intro-x">
                            <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                    <img alt="Midone - HTML Admin Template" src="dist/images/profile-11.jpg">
                                </div>
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">Brad Pitt</div>
                                    <div class="text-slate-500 text-xs mt-0.5">11 July 2020</div>
                                </div>
                                <div class="text-danger">-$47</div>
                            </div>
                        </div>
                        <div class="intro-x">
                            <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                    <img alt="Midone - HTML Admin Template" src="dist/images/profile-11.jpg">
                                </div>
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">Brad Pitt</div>
                                    <div class="text-slate-500 text-xs mt-0.5">11 July 2020</div>
                                </div>
                                <div class="text-danger">-$47</div>
                            </div>
                        </div>
                        <div class="intro-x">
                            <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                    <img alt="Midone - HTML Admin Template" src="dist/images/profile-11.jpg">
                                </div>
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">Brad Pitt</div>
                                    <div class="text-slate-500 text-xs mt-0.5">11 July 2020</div>
                                </div>
                                <div class="text-danger">-$47</div>
                            </div>
                        </div>
                        <div class="intro-x">
                            <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                    <img alt="Midone - HTML Admin Template" src="dist/images/profile-11.jpg">
                                </div>
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">Brad Pitt</div>
                                    <div class="text-slate-500 text-xs mt-0.5">11 July 2020</div>
                                </div>
                                <div class="text-danger">-$47</div>
                            </div>
                        </div>
                        <div class="intro-x">
                            <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                    <img alt="Midone - HTML Admin Template" src="dist/images/profile-11.jpg">
                                </div>
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">Brad Pitt</div>
                                    <div class="text-slate-500 text-xs mt-0.5">11 July 2020</div>
                                </div>
                                <div class="text-danger">-$47</div>
                            </div>
                        </div>
                        <a href="" class="intro-x w-full block text-center rounded-md py-3 border border-dotted border-slate-400 dark:border-darkmode-300 text-slate-500">View More</a>
                    </div>
                </div>
                <!-- END: Transactions -->

            </div>
        </div>
    </div>
    </div>
</div>
</div>
<!-- END: Content -->
</div>

@include('employee_ratings.survey_training.survey_modal.create_survey_modal')
@include('employee_ratings.modal.delete_spms_modal')

@endsection
@section('scripts')
<script src="{{ asset('js/employee_rating_js/survey_training_satisfaction.js') }}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/classic/ckeditor.js"></script>
@endsection
