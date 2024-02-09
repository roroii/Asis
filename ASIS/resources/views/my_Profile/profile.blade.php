@extends('layouts.app')

@section('breadcrumb')
    {{ Breadcrumbs::render('My Profile') }}
@endsection

@section('content')

    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            My Profile
        </h2>
    </div>
    <!-- BEGIN: Profile Info -->
    <div class="intro-y box px-5 pt-5 mt-5">
        <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
            <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">

                <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                    <div id="profile_pic_div" class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">

                    </div>
                </div>
                <div id="profile_name" class="ml-5"></div>
            </div>

{{--            <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">--}}
{{--                <div class="font-medium text-center lg:text-left lg:mt-3">Contact Details</div>--}}
{{--                <div class="flex flex-col justify-center items-center lg:items-start mt-4">--}}

{{--                    <div class="truncate sm:whitespace-normal flex items-center"> <i class="fa-regular fa-envelope w-4 h-4 mr-2"></i> <span class="profile_student_email"></span> </div>--}}
{{--                    <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i class="fa-solid fa-mobile-screen w-4 h-4 mr-2"></i> <span class="profile_student_contact"></span> </div>--}}

{{--                </div>--}}
{{--            </div>--}}

        </div>

        <!-- BEGIN: Tab Pane -->
            <ul class="nav nav-link-tabs flex-col sm:flex-row justify-center lg:justify-start text-center" role="tablist" >

                <li id="profile-tab" class="nav-item" role="presentation">
                    <a href="javascript:;" class="nav-link py-4 flex items-center active" data-tw-target="#personal_info_tab" aria-controls="personal_info_tab" aria-selected="true" role="tab" > <i class="w-4 h-4 mr-2" data-lucide="user"></i> Personal Information </a>
                </li>

                <li id="account-tab" class="nav-item" role="presentation">
                    <a href="javascript:;" class="nav-link py-4 flex items-center" data-tw-target="#account_settings" aria-selected="true"  role="tab" > <i class="w-4 h-4 mr-2" data-lucide="settings"></i> Account Settings </a>
                </li>


{{--            <li id="e_signature_tab" class="nav-item" role="presentation">--}}
{{--                <a href="javascript:;" class="nav-link py-4 flex items-center" data-tw-target="#e_signature_settings" aria-selected="false" role="tab" > <i class="fa-solid fa-signature w-4 h-4 mr-2"></i> Electronic Signature </a>--}}
{{--            </li>--}}

        </ul>
        <!-- END: Tab Pane -->

    </div>

    @if(Session::has('message'))
        <div class="intro-y col-span-11 alert alert-danger alert-dismissible show flex items-center mb-6 mt-6" role="alert">
            <span><i data-lucide="info" class="w-4 h-4 mr-2"></i></span>
            <span> {{ Session::get('message') }} </span>
            <button type="button" class="btn-close text-white" data-tw-dismiss="alert" aria-label="Close"> <i data-lucide="x" class="w-4 h-4"></i> </button>
        </div>

        {{ Session::forget('message') }}
    @endif

    <!-- END: Profile Info -->

    <div class="tab-content mt-5">

        <!-- BEGIN: Personal Information -->

        <div id="personal_info_tab" class="tab-pane active" role="tabpanel" aria-labelledby="profile-tab">
            <div class="grid grid-cols-12 gap-6">
                <div class="intro-y box col-span-12 lg:col-span-12">
                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto">
                            Personal Information
                        </h2>
                        @if (Auth::guard('enrollees_guard')->check())
                            <a id="btn_save_profile_information" href="javascript:;" class="btn btn-primary  mr-2 mb-2"> <i data-lucide="save" class="w-4 h-4 mr-2"></i> Update Information </a>
                        @endif
                    </div>
                    <div class="p-5 grid grid-cols-12 gap-6">
                        @php
                            $disabled = Auth::guard('enrollees_guard')->check() ? '' : 'disabled';
                        @endphp

                        <div class="input-form col-span-12 lg:col-span-3">
                            <label for="validation-form-2" class="form-label w-full flex flex-col sm:flex-row"> First Name </label>
                            <input type="text" name="profile_firstname" class="form-control profile_firstname" placeholder="First Name" required autocomplete="off" {{ $disabled }}>
                        </div>

                        <div class="input-form col-span-12 lg:col-span-3">
                            <label for="validation-form-2" class="form-label w-full flex flex-col sm:flex-row"> Middle Name </label>
                            <input type="text" name="profile_midname" class="form-control profile_midname" placeholder="Middle Name" required autocomplete="off" {{ $disabled }}>
                        </div>

                        <div class="input-form col-span-12 lg:col-span-3">
                            <label for="validation-form-2" class="form-label w-full flex flex-col sm:flex-row"> Last Name </label>
                            <input type="text" name="profile_lastname" class="form-control profile_lastname" placeholder="Last Name" required autocomplete="off" {{ $disabled }}>
                        </div>

                        <div class="input-form col-span-12 lg:col-span-3">
                            <label for="validation-form-2" class="form-label w-full flex flex-col sm:flex-row"> Extension </label>
                            <input type="text" name="profile_ext" class="form-control profile_ext" placeholder="jr., sr.," required autocomplete="off" {{ $disabled }}>
                        </div>

                    </div>
                </div>

                @if (Auth::guard('enrollees_guard')->check())

                    <!-- BEGIN: Residential Address -->
                    <div class="intro-y box col-span-12 lg:col-span-6">
                        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                            <h2 class="font-medium text-base mr-auto">
                                Residential Address
                            </h2>
                        </div>
                        <div class="p-5 grid grid-cols-12 gap-6">

                            <input class="hidden res_address_type" value="RESIDENTIAL">

                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Province </label>
                                <select class="select2 w-full ref_province">
                                    <option></option>
                                    @forelse (get_province('') as $province)
                                        <option value="{{ $province->provCode }}">{{ $province->provDesc }}</option>
                                    @empty

                                    @endforelse
                                </select>
                            </div>

                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> City/Municipality </label>
                                <select class="select2 w-full ref_city_mun">
                                    <option></option>
                                    @forelse (get_mun('') as $mun)
                                        <option value="{{ $mun->citymunCode }}">{{ $mun->citymunDesc }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>

                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Barangay </label>
                                <select class="select2 w-full ref_brgy">
                                    <option></option>
                                </select>
                            </div>

                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Subdivision/Village  <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Please put 'N/A' if not applicable</span> </label>
                                <input id="res_sub" type="text" style="text-transform:uppercase" name="res_sub" class="form-control" placeholder="Subdivision/Village" minlength="2" autocomplete="off">
                            </div>

                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Street <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Please put 'N/A' if not applicable</span> </label>
                                <input id="res_street" type="text" style="text-transform:uppercase" name="profile_street" class="form-control" placeholder="Street" minlength="2" autocomplete="off">
                            </div>

                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> House/Block/Lot No. <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Please put 'N/A' if not applicable</span> </label>
                                <input id="res_house_block" type="text" style="text-transform:uppercase" name="profile_mid_name" class="form-control" placeholder="House/Block/Lot No." minlength="2" autocomplete="off">
                            </div>

                            <div class="input-form col-span-12 lg:col-span-12">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> ZIP Code</label>
                                <input id="res_zip_code" type="number" name="res_zip_code" class="form-control" placeholder="ZIP Code" minlength="2" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <!-- END: Residential Address -->

                    <!-- BEGIN: Permanent Address -->
                    <div class="intro-y box col-span-12 lg:col-span-6">
                        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                            <h2 class="font-medium text-base mr-auto">
                                Permanent Address
                            </h2>
                        </div>
                        <div class="p-5 grid grid-cols-12 gap-6">
                            <input class="hidden per_address_type" value="PERMANENT">

                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Province </label>
                                <select class="select2 w-full per_province">
                                    <option></option>
                                    @forelse (get_province('') as $province)
                                        <option value="{{ $province->provCode }}">{{ $province->provDesc }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>

                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> City/Municipality </label>
                                <select class="select2 w-full per_city_mun">
                                    <option></option>
                                    @forelse (get_mun('') as $mun)
                                        <option value="{{ $mun->citymunCode }}">{{ $mun->citymunDesc }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>

                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Barangay </label>
                                <select class="select2 w-full per_brgy">
                                    <option></option>
                                </select>
                            </div>

                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Subdivision/Village <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Please put 'N/A' if not applicable</span> </label>
                                <input id="per_sub" type="text" style="text-transform:uppercase" name="per_sub" class="form-control" placeholder="Subdivision/Village" minlength="2" autocomplete="off">
                            </div>

                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Street <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Please put 'N/A' if not applicable</span> </label>
                                <input id="per_street" type="text" style="text-transform:uppercase" name="per_street" class="form-control" placeholder="Street" minlength="2" autocomplete="off">
                            </div>

                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> House/Block/Lot No. <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Please put 'N/A' if not applicable</span> </label>
                                <input id="per_house_block" type="text" style="text-transform:uppercase" name="per_house_block" class="form-control" placeholder="House/Block/Lot No." minlength="2" autocomplete="off">
                            </div>

                            <div class="input-form col-span-12 lg:col-span-12">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> ZIP Code</label>
                                <input id="per_zip_code" type="number" name="per_zip_code" class="form-control" placeholder="ZIP Code" minlength="2" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <!-- END: Permanent Address -->
                @endif
            </div>

        </div>

        <!-- BEGIN: Account Settings -->
        <div id="account_settings" class="tab-pane" role="tabpanel" aria-labelledby="profile-tab">
            <div class="grid grid-cols-12 gap-6">
                <div class="intro-y box col-span-12 lg:col-span-12">
                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto">
                            Account Settings
                        </h2>
                        <a id="btn_save_account_settings" href="javascript:;" class="btn btn-primary  mr-2 mb-2"> <i data-lucide="save" class="w-4 h-4 mr-2"></i> Update Account </a>
                    </div>
                    <div class="p-5 grid grid-cols-12 gap-6">
                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-2" class="form-label w-full flex flex-col sm:flex-row"> Email </label>
                            <input disabled id="account_email" type="email" name="account_email" class="form-control" placeholder="juan.delacruz@gmail.com" required autocomplete="off">
                        </div>
                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-3" class="form-label w-full flex flex-col sm:flex-row"> Password <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 8 characters</span> </label>


                            <div class="input-group mt-2">
                                <input id="account_password" type="password" name="account_password" class="form-control" placeholder="Password" minlength="4" required>
                                <div id="input-group-price" class="input-group-text"><input id="btn_show_pass" class="form-check-input" type="checkbox" value=""></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Account Settings -->

        <!-- BEGIN: Account Settings -->
{{--        <div id="account_settings" class="tab-pane" role="tabpanel" aria-labelledby="account_settings">--}}
{{--            <div class="grid grid-cols-12 gap-6">--}}
{{--                <div class="intro-y box col-span-12 lg:col-span-12">--}}
{{--                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">--}}
{{--                        <h2 class="font-medium text-base mr-auto">--}}
{{--                            Account Settings--}}
{{--                        </h2>--}}
{{--                        <a id="btn_save_account_settings" href="javascript:;" class="btn btn-primary  mr-2 mb-2"> <i data-lucide="save" class="w-4 h-4 mr-2"></i> Update Account </a>--}}
{{--                    </div>--}}
{{--                    <div class="p-5 grid grid-cols-12 gap-6">--}}
{{--                        <div class="input-form col-span-12 lg:col-span-6">--}}
{{--                            <label for="validation-form-2" class="form-label w-full flex flex-col sm:flex-row"> Email <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, email address format</span> </label>--}}
{{--                            <input disabled id="account_email" type="email" name="account_email" class="form-control" placeholder="example@gmail.com" required autocomplete="off">--}}
{{--                        </div>--}}
{{--                        <div class="input-form col-span-12 lg:col-span-6">--}}
{{--                            <label for="validation-form-3" class="form-label w-full flex flex-col sm:flex-row"> Password <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 4 characters</span> </label>--}}


{{--                            <div class="input-group mt-2">--}}
{{--                                <input id="account_password" type="password" name="account_pass" class="form-control" placeholder="Password" minlength="4" required>--}}
{{--                                <div id="input-group-price" class="input-group-text"><input id="btn_show_pass" class="form-check-input" type="checkbox" value=""></div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <!-- END: Account Settings -->

        <!-- BEGIN: Electronic Signatures Settings -->
        <div id="e_signature_settings" class="tab-pane" role="tabpanel" aria-labelledby="account_settings">
            <div class="grid grid-cols-12 gap-6">
                <div class="intro-y box col-span-12 lg:col-span-12">
                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto">
                            Electronic Signature
                        </h2>
                    </div>
                    <div class="p-5 grid grid-cols-12 gap-6">
                        <input id="old_e_signature" name="old_e_signature" type="file"  class="hidden">

                        <div class="input-form col-span-12 lg:col-span-6">
                            <div class="intro-y col-span-12 md:col-span-6 xl:col-span-4 box">
                                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 px-5 py-4">
                                    <div class="ml-3 mr-auto">
                                        <a id="e_signature_label" href="javascript:;" class="font-medium"></a>
                                        <div id="e_signature_status" class="flex text-slate-500 truncate text-xs mt-0.5"> Uploaded </a> <span class="mx-1">•</span> 21 seconds ago </div>
                                    </div>
                                    <div id="e_signature_dd_div" class="dropdown ml-3">
                                        <a href="javascript:;" class="dropdown-toggle w-5 h-5 text-slate-500" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-vertical" class="w-4 h-4"></i> </a>
                                        <div class="dropdown-menu w-40">
                                            <ul class="dropdown-content">

                                                <li id="btn_add_update_signature">

                                                </li>

                                                <li id="li_delete_e_signature">
                                                    <a id="btn_delete_e_signature" href="javascript:;" class="dropdown-item"> <i class="fa-solid fa-trash text-danger w-4 h-4 mr-2"></i> Delete </a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-5">
                                    <div class="h-75 2xl:h-56 image-fit">
                                        <img id="profile_e_signature" alt="Electronic Signature" class="rounded-md" src="">
                                    </div>
                                </div>

                                <div class="flex items-center px-5 py-3 border-t border-slate-200/60 dark:border-darkmode-400">
                                    <div class="intro-x flex mr-2">

                                    </div>

{{--                                    <a href="javascript:;" class="intro-x w-8 h-8 flex items-center justify-center rounded-full text-primary bg-primary/10 dark:bg-darkmode-300 dark:text-slate-300 ml-auto tooltip" title="Share E - Signature"> <i data-lucide="share-2" class="w-3 h-3"></i> </a>--}}
{{--                                    <a id="btn_download_e_sig" href="javascript:;" class="intro-x w-8 h-8 flex items-center justify-center rounded-full bg-primary text-white ml-2 tooltip" title="Download E - Signature"> <i data-lucide="share" class="w-3 h-3"></i> </a>--}}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Electronic Signatures Settings -->

        <!-- END: BUTTON SAVE PDS-->
    </div>


{{--        <div class="cursor-pointer shadow-md fixed bottom-0 right-0 box flex items-center justify-center z-50 mb-10 mr-10 btn_save_PDS_div">--}}
{{--            <div class="flex items-center px-5 py-8 sm:py-3 border-t border-slate-200/60 dark:border-darkmode-400">--}}
{{--                <a href="javascript:;" id="save_PDS_to_db" class="ml-auto btn btn-primary truncate flex items-center"> <i class="w-4 h-4 mr-2" data-lucide="save"></i> Save </a>--}}
{{--            </div>--}}
{{--        </div>--}}

    @include('my_Profile.modal.profile_picture')
    @include('my_Profile.modal.educational_bg_modal')
    @include('my_Profile.modal.add_civil_service_modal')
    @include('my_Profile.modal.add_work_exp_modal')
    @include('my_Profile.modal.add_voluntary_work_modal')
    @include('my_Profile.modal.add_LD_modal')
    @include('my_Profile.modal.add_other_info_modal')
    @include('my_Profile.modal.add_references_modal')
@endsection

@section('scripts')

    @if (Auth::check())
        <script src="{{ asset('/js/my_profile/profile.js') }}"></script>
    @endif
{{--    <script src="{{ asset('/js/my_profile/ref_address.js') }}"></script>--}}
{{--    <script src="{{ asset('/js/my_profile/update_profile_picture_pond.js') }}"></script>--}}

{{--    <script src="{{ asset('/js/my_profile/new_profile_uploader.js') }}"></script>--}}


    <script src="{{BASEPATH()}}/js/ASIS_js/Profile/profile.js{{GET_RES_TIMESTAMP()}}"></script>
@endsection
