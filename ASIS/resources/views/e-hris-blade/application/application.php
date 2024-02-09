<!--@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('Application') }}
@endsection

@section('content')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Application Form
        </h2>
    </div>
    <form class="grid grid-cols-12 gap-6 mt-5" id="form_application" method="post" enctype="multipart/form-data">
        @csrf
        {{--         Profile Informations       --}}
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Form Validation -->
            <div class="intro-y box h-full">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Profile Information
                    </h2>
                </div>
                <div class="p-5">
                    <div class="preview">
                        <!-- BEGIN: Validation Form -->
                        <div class="input-form">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Last Name <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 2 characters</span> </label>
                            <input id="profile_last_name" type="text" name="profile_last_name" class="form-control" placeholder="Last Name" minlength="2" required autocomplete="off">
                        </div>
                        <div class="input-form mt-3">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> First Name <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 2 characters</span> </label>
                            <input id="profile_first_name" type="text" name="profile_first_name" class="form-control" placeholder="First Name" minlength="2" required autocomplete="off">
                        </div>
                        <div class="input-form mt-3">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Middle Name <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 2 characters</span> </label>
                            <input id="profile_mid_name" type="text" name="profile_mid_name" class="form-control" placeholder="Middle Name" minlength="2" required autocomplete="off">
                        </div>
                        <div class="input-form mt-3">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Citizenship <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span> </label>
                            <input id="profile_citizenship" type="text" name="profile_citizenship" class="form-control" placeholder="Citizenship" minlength="2" required autocomplete="off">
                        </div>
                        <div class="input-form mt-3">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Sex <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span> </label>
                            <select class="select2 w-full" id="application_gender">
                                <option></option>
                                @forelse (get_gender('') as $gender)
                                    <option value="{{ $gender->id }}">{{ $gender->gender }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div class="input-form mt-3">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Date of Birth <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span> </label>
                            <div class="relative w-auto mx-auto">
                                <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                                    <i data-lucide="calendar" class="w-4 h-4"></i>
                                </div> <input id="profile_date_birth" type="text" class="form-control pl-12 ">
                            </div>
                        </div>
                        <div class="input-form mt-3">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Age <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 2 characters</span> </label>
                            <input id="profile_age" type="number" name="profile_age" class="form-control" placeholder="Age" minlength="2" required autocomplete="off">
                        </div>
                        <div class="input-form mt-3">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Phone Number <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 11 characters</span> </label>
                            <input id="profile_phone_number" type="tel" name="profile_phone_number" class="form-control" placeholder="Phone Number" minlength="11" required autocomplete="off">
                        </div>
                        <div class="input-form mt-3">
                            <label for="validation-form-2" class="form-label w-full flex flex-col sm:flex-row"> Email <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, email address format</span> </label>
                            <input id="profile_email" type="email" name="profile_email" class="form-control" placeholder="example@gmail.com" required autocomplete="off">
                        </div>
{{--                        <div class="input-form mt-3">--}}
{{--                            <label for="validation-form-2" class="form-label w-full flex flex-col sm:flex-row"> Username <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, email address format</span> </label>--}}
{{--                            <input id="profile_username" type="text" name="profile_username" class="form-control" placeholder="Username" required>--}}
{{--                        </div>--}}
{{--                        <div class="input-form mt-3">--}}
{{--                            <label for="validation-form-3" class="form-label w-full flex flex-col sm:flex-row"> Password <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 4 characters</span> </label>--}}
{{--                            <input id="profile_pass" type="password" name="profile_pass" class="form-control" placeholder="Password" minlength="4" required>--}}
{{--                        </div>--}}
                        <!-- END: Validation Form -->
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Address
                    </h2>
                </div>
                <div class="p-5">
                    <div class="preview">
                        <!-- BEGIN: Validation Form -->
                        <div class="input-form">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Country <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span> </label>
                            <select class="select2 w-full" id="profile_country">
                                <option></option>
                                @forelse (get_country('') as $country)
                                    <option value="{{ $country->id }}">{{ $country->nicename }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>

                        <div class="input-form mt-3">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Region <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span> </label>
                            <select class="select2 w-full" id="profile_region">
                                <option></option>
                                @forelse (get_region('') as $region)
                                    <option value="{{ $region->regCode }}">{{ $region->regDesc }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>

                        <div class="input-form mt-3">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Province <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span> </label>
                            <select class="select2 w-full" id="profile_province">
                                <option></option>
                                @forelse (get_province('') as $province)
                                    <option value="{{ $province->provCode }}">{{ $province->provDesc }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>

                        <div class="input-form mt-3">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Municipality <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span> </label>
                            <select class="select2 w-full" id="profile_municipality">
                                <option></option>
{{--                                @forelse (get_mun('') as $mun)--}}
{{--                                    <option value="{{ $mun->citymunCode }}">{{ $mun->citymunDesc }}</option>--}}
{{--                                @empty--}}
{{--                                @endforelse--}}
                            </select>
                        </div>

                        <div class="input-form mt-3">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Barangay <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span> </label>
                            <select class="select2 w-full" id="profile_brgy">
                                <option></option>
{{--                                @forelse (get_brgy('') as $brgy)--}}
{{--                                    <option value="{{ $brgy->brgyCode }}">{{ $brgy->brgyDesc }}</option>--}}
{{--                                @empty--}}
{{--                                @endforelse--}}
                            </select>
                        </div>
                        <!-- END: Validation Form -->
                    </div>
                </div>
            </div>
            <!-- END: Form Validation -->
        </div>

        {{-- Academic Background --}}
        <div class="intro-y col-span-12 lg:col-span-6">
            <!-- BEGIN: Form Validation -->
            <div class="intro-y box h-full">
                    {{--    Academic Background      --}}
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Academic Background
                    </h2>
                </div>
                <div class="p-5">
                    <div class="preview">
                        <!-- BEGIN: Validation Form -->
                        <div class="input-form">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Elementary <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span> </label>
                            <input id="profile_elementary" type="text" name="profile_first_name" class="form-control" placeholder="Elementary" minlength="2" required autocomplete="off">
                        </div>
                        <div class="input-form mt-3">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> High School <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required</span> </label>
                            <input id="profile_high_school" type="text" name="profile_first_name" class="form-control" placeholder="High School" minlength="2" required autocomplete="off">
                        </div>
                        <div class="input-form mt-3">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> TechVoc <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">N/A if not applicable</span> </label>
                            <input id="profile_techvoc" type="text" name="profile_first_name" class="form-control" placeholder="Technical Vocational" minlength="2" required autocomplete="off">
                        </div>
                        <div class="input-form mt-3">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> College <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">N/A if not applicable</span> </label>
                            <input id="profile_college" type="text" name="profile_first_name" class="form-control" placeholder="College" minlength="2" required autocomplete="off">
                        </div>
                        <div class="input-form mt-3">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Master <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">N/A if not applicable</span> </label>
                            <input id="profile_master" type="text" name="profile_first_name" class="form-control" placeholder="College/University" minlength="2" required autocomplete="off">
                        </div>
                        <div class="input-form mt-3">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Doctorate <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">N/A if not applicable</span> </label>
                            <input id="profile_doctorate" type="text" name="profile_first_name" class="form-control" placeholder="College/University" minlength="2" required autocomplete="off">
                        </div>
                        <!-- END: Validation Form -->
                    </div>
                </div>

                {{--    File Attachments     --}}
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        File Attachments
                    </h2>
                </div>
                <div class="p-5">
                    <div class="preview">
                        <!-- BEGIN: Validation Form -->
                        <div class="input-form">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Transcript of Record <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Maximum of 5 MB</span> </label>
                            <input id="transcript_of_records"
                                   type="file"
                                   class="filepond mt-1"
                                   name="transcript_of_records[]"
                                   multiple
                                    >
                        </div>

                        <div class="input-form mt-3">
                            <label for="validation-form-2" class="form-label w-full flex flex-col sm:flex-row"> Diploma <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Maximum of 5 MB</span> </label>
                            <input id="diploma"
                                   type="file"
                                   class="filepond mt-1"
                                   name="diploma[]"
                                   multiple >
                        </div>

                        <div class="input-form mt-3">
                            <label for="validation-form-2" class="form-label w-full flex flex-col sm:flex-row"> Certificates <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Maximum of 5 MB</span> </label>
                            <input id="certificates"
                                   type="file"
                                   class="filepond mt-1"
                                   name="certificates[]"
                                   multiple >
                        </div>

                        <div class="input-form mt-3">
                            <label for="validation-form-2" class="form-label w-full flex flex-col sm:flex-row"> Profile Picture <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Maximum of 5 MB</span> </label>
                            <input id="profile_pic"
                                   type="file"
                                   class="filepond mt-1"
                                   name="profile_pic[]"
                                    >
                        </div>
                        <!-- END: Validation Form -->
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Select Job Position
                    </h2>
                </div>

                <div class="p-5">
                    <div class="preview">
                        <!-- BEGIN: Validation Form -->
                        <div class="input-form">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Available Job Position <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 1 position</span> </label>
                            <select class="select2-multiple w-full" multiple="multiple" id="application_pos">

                            </select>
                        </div>
                        <!-- END: Validation Form -->
                    </div>
                </div>
                <div style="text-align: right" class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400"></div>
                <div class="p-5 flex justify-end">
                    <button id="submit_application" type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
            </div>
            <!-- END: Form Validation -->
        </div>
    </form>
    <!-- END: Wizard Layout -->
@endsection
@section('scripts')
    <script src="{{ asset('/js/application/application.js') }}"></script>
    <script src="{{ asset('/js/application/TOR_pond.js') }}"></script>
    <script src="{{ asset('/js/application/diploma_pond.js') }}"></script>
    <script src="{{ asset('/js/application/certificates_pond.js') }}"></script>
    <script src="{{ asset('/js/application/profile_picture_pond.js') }}"></script>
@endsection
-->
