@extends('layouts.app')
@section('breadcrumb')
    {{ Breadcrumbs::render('Dashboard') }}
@endsection
@section('content')

    @if(Session::has('message'))
        <div class="intro-y col-span-11 alert alert-danger alert-dismissible show flex items-center mb-6 mt-6" role="alert">
            <span><i data-lucide="info" class="w-4 h-4 mr-2"></i></span>
            <span> {{ Session::get('message') }} </span>
            <button type="button" class="btn-close text-white" data-tw-dismiss="alert" aria-label="Close"> <i data-lucide="x" class="w-4 h-4"></i> </button>
        </div>

        {{ Session::forget('message') }}

    @elseif($message)
        <div class="intro-y col-span-11 alert alert-danger alert-dismissible show flex items-center mb-6 mt-6" role="alert">
            <span><i data-lucide="info" class="w-4 h-4 mr-2"></i></span>
            <span> {{ $message }} </span>
            <button type="button" class="btn-close text-white" data-tw-dismiss="alert" aria-label="Close"> <i data-lucide="x" class="w-4 h-4"></i> </button>
        </div>
    @else
        <div class="intro-y col-span-11 alert alert-primary alert-dismissible show flex items-center mb-6" role="alert">
            <span><i data-lucide="info" class="w-4 h-4 mr-2"></i></span>
            <span> WELCOME FUTURE STUDENTS OF DAVAO DEL SUR STATE COLLEGE!! </span>
            <button type="button" class="btn-close text-white" data-tw-dismiss="alert" aria-label="Close"> <i data-lucide="x" class="w-4 h-4"></i> </button>
        </div>
    @endif


    @if(!$isAccountVerified)
    <div class="flex items-center mt-8">
        <h2 class="intro-y text-lg font-medium mr-auto">
            Account Setup
        </h2>
    </div>
    <!-- BEGIN: Wizard Layout -->
    <div class="intro-y box py-10 sm:py-20 mt-5">
        <div class="flex justify-center">
            <button class="intro-y w-10 h-10 rounded-full btn btn-primary mx-2 btn_selected_div">1</button>
            <button class="intro-y w-10 h-10 rounded-full btn bg-slate-100     btn_selected_div dark:bg-darkmode-400 dark:border-darkmode-400 text-slate-500 mx-2">2</button>
            <button class="intro-y w-10 h-10 rounded-full btn bg-slate-100     btn_selected_div dark:bg-darkmode-400 dark:border-darkmode-400 text-slate-500 mx-2">3</button>
        </div>
        <div class="px-5 mt-10">
            <div class="font-medium text-center text-lg">Setup Your Account</div>
            <div class="text-slate-500 text-center mt-2">For a smooth enrollment process and to unlock the full potential of our student portal, kindly provide precise and up-to-date personal information. <br> Your accurate details ensure a tailored and efficient experience throughout your academic journey.</div>
        </div>

        <div class="px-5 sm:px-20 mt-10 pt-10 border-t border-slate-200/60 dark:border-darkmode-400">

            <div class="font-medium text-base Setup_label">Personal Information</div>

            <!-- BEGIN::  PERSONAL INFORMATION  -->
            <div id="personalInfoDiv" class="grid grid-cols-12 gap-4 gap-y-5 mt-5 ">

                <div class="intro-y col-span-12 sm:col-span-6">
                    <label for="validation-form-2" class="form-label w-full flex flex-col sm:flex-row"> First Name <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 2 characters</span>  </label>
                    <input type="text" name="profile_firstname" class="form-control profile_firstname" placeholder="First Name" required autocomplete="off">
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <label for="validation-form-2" class="form-label w-full flex flex-col sm:flex-row"> Middle Name <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 2 characters</span> </label>
                    <input type="text" name="profile_midname" class="form-control profile_midname" placeholder="Middle Name" required autocomplete="off">
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <label for="validation-form-2" class="form-label w-full flex flex-col sm:flex-row"> Last Name <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 2 characters</span> </label>
                    <input type="text" name="profile_lastname" class="form-control profile_lastname" placeholder="Last Name" required autocomplete="off">
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <label for="validation-form-2" class="form-label w-full flex flex-col sm:flex-row"> Suffix <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Please put 'N/A' if not applicable</span> </label>
                    <input type="text" name="profile_ext" class="form-control profile_ext" placeholder="jr., sr.," required autocomplete="off">
                </div>

            </div>
            <!-- END::  PERSONAL INFORMATION  -->


            <!-- BEGIN::  RESIDENTIAL ADDRESS  -->
            <div id="residentialAddressDiv" class="grid grid-cols-12 gap-4 gap-y-5 mt-5">

                <input class="hidden res_address_type" value="RESIDENTIAL">
                <div class="intro-y col-span-12 sm:col-span-6">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Province <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required *</span> </label>
                    <select class="select2 w-full ref_province">
                        <option></option>
                        @forelse (get_province('') as $province)
                            <option value="{{ $province->provCode }}">{{ $province->provDesc }}</option>
                        @empty

                        @endforelse
                    </select>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> City/Municipality <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required *</span> </label>
                    <select class="select2 w-full ref_city_mun">
                        <option></option>
                        @forelse (get_mun('') as $mun)
                            <option value="{{ $mun->citymunCode }}">{{ $mun->citymunDesc }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Barangay <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required *</span> </label>
                    <select class="select2 w-full ref_brgy">
                        <option></option>
                    </select>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Subdivision/Village  <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Please put 'N/A' if not applicable</span> </label>
                    <input id="res_sub" type="text" style="text-transform:uppercase" name="res_sub" class="form-control" placeholder="Subdivision/Village" minlength="2" autocomplete="off">
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Street <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Please put 'N/A' if not applicable</span> </label>
                    <input id="res_street" type="text" style="text-transform:uppercase" name="profile_street" class="form-control" placeholder="Street" minlength="2" autocomplete="off">
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> House/Block/Lot No. <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Please put 'N/A' if not applicable</span> </label>
                    <input id="res_house_block" type="text" style="text-transform:uppercase" name="profile_mid_name" class="form-control" placeholder="House/Block/Lot No." minlength="2" autocomplete="off">
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> ZIP Code <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required *</span> </label>
                    <input id="res_zip_code" type="number" name="res_zip_code" class="form-control" placeholder="ZIP Code" minlength="2" autocomplete="off" required>
                </div>

            </div>
            <!-- END::  RESIDENTIAL ADDRESS  -->



            <!-- BEGIN::  PERMANENT ADDRESS  -->
            <div id="permanentAddressDiv" class="grid grid-cols-12 gap-4 gap-y-5 mt-5">

                <input class="hidden per_address_type" value="PERMANENT">
                <div class="intro-y col-span-12 sm:col-span-6">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Province <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required *</span> </label>
                    <select class="select2 w-full per_province">
                        <option></option>
                        @forelse (get_province('') as $province)
                            <option value="{{ $province->provCode }}">{{ $province->provDesc }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> City/Municipality <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required *</span> </label>
                    <select class="select2 w-full per_city_mun">
                        <option></option>
                        @forelse (get_mun('') as $mun)
                            <option value="{{ $mun->citymunCode }}">{{ $mun->citymunDesc }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Barangay <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required *</span> </label>
                    <select class="select2 w-full per_brgy">
                        <option></option>
                    </select>
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Subdivision/Village <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Please put 'N/A' if not applicable</span> </label>
                    <input id="per_sub" type="text" style="text-transform:uppercase" name="per_sub" class="form-control" placeholder="Subdivision/Village" minlength="2" autocomplete="off">
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Street <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Please put 'N/A' if not applicable</span> </label>
                    <input id="per_street" type="text" style="text-transform:uppercase" name="per_street" class="form-control" placeholder="Street" minlength="2" autocomplete="off">
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> House/Block/Lot No. <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Please put 'N/A' if not applicable</span> </label>
                    <input id="per_house_block" type="text" style="text-transform:uppercase" name="per_house_block" class="form-control" placeholder="House/Block/Lot No." minlength="2" autocomplete="off">
                </div>
                <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> ZIP Code <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required *</span> </label>
                    <input id="per_zip_code" type="number" name="per_zip_code" class="form-control" placeholder="ZIP Code" minlength="2" autocomplete="off" required>
                </div>

            </div>
            <!-- END::  PERMANENT ADDRESS  -->

            <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5">
                <button class="btn btn-secondary w-24 btn_previous">Previous</button>
                <button class="btn btn-primary w-24 ml-2 btn_next">Next</button>
            </div>

        </div>
    </div>
    <!-- END: Wizard Layout -->
    @endif

@endsection

@section('scripts')
    <script src="{{BASEPATH()}}/js/ASIS_js/Profile/profile.js{{GET_RES_TIMESTAMP()}}"></script>

@endsection
