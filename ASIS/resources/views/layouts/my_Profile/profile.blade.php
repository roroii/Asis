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
            <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
{{--                <div class="font-medium text-center lg:text-left lg:mt-3">Contact Details</div>--}}
{{--                <div class="flex flex-col justify-center items-center lg:items-start mt-4">--}}
{{--                    <div class="truncate sm:whitespace-normal flex items-center"> <i data-lucide="mail" class="w-4 h-4 mr-2"></i> denzelwashington@left4code.com </div>--}}
{{--                    <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-lucide="instagram" class="w-4 h-4 mr-2"></i> Instagram Denzel Washington </div>--}}
{{--                    <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-lucide="twitter" class="w-4 h-4 mr-2"></i> Twitter Denzel Washington </div>--}}
{{--                </div>--}}
            </div>

        </div>
        <ul class="nav nav-link-tabs flex-col sm:flex-row justify-center lg:justify-start text-center" role="tablist" >

            <li id="profile-tab" class="nav-item" role="presentation">
                <a href="javascript:;" class="nav-link py-4 flex items-center active" data-tw-target="#personal_info_tab" aria-controls="personal_info_tab" aria-selected="true" role="tab" > <i class="w-4 h-4 mr-2" data-lucide="user"></i> Personal Information </a>
            </li>

            <li id="account-tab" class="nav-item" role="presentation">
                <a href="javascript:;" class="nav-link py-4 flex items-center" data-tw-target="#account_settings" aria-selected="false" role="tab" > <i class="w-4 h-4 mr-2" data-lucide="settings"></i> Account Settings </a>
            </li>

            <li id="e_signature_tab" class="nav-item" role="presentation">
                <a href="javascript:;" class="nav-link py-4 flex items-center" data-tw-target="#e_signature_settings" aria-selected="false" role="tab" > <i class="fa-solid fa-signature w-4 h-4 mr-2"></i> Electronic Signature </a>
            </li>

        </ul>
    </div>

    <!-- END: Profile Info -->

    <div class="tab-content mt-5">

        <!-- BEGIN: Personal Information -->
        <div id="personal_info_tab" class="tab-pane active" role="tabpanel" aria-labelledby="profile-tab">
            <div class="grid grid-cols-12 gap-6">

                <!-- BEGIN: Personal Information -->
                <div class="intro-y box col-span-12 lg:col-span-12">
                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto">
                            I. Personal Information
                        </h2>
                        <a id="btn_print_PDS" target="_blank" href="/my/print/pds/{{Crypt::encrypt(Auth::user()->employee)}}" class="btn btn-primary w-32 mr-2 mb-2"> <i data-lucide="printer" class="w-4 h-4 mr-2"></i> Print PDS </a>
                    </div>

                    <div class="p-5 grid grid-cols-12 gap-6">
                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Surname </label>
                            <input id="profile_last_name" style="text-transform: uppercase;" type="text" name="profile_last_name" class="form-control" placeholder="Surname" minlength="2" required autocomplete="off">
                        </div>
                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> First Name </label>
                            <input id="profile_first_name" style="text-transform: uppercase;" type="text" name="profile_first_name" class="form-control" placeholder="First Name" minlength="2" required autocomplete="off">
                        </div>
                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Middle Name </label>
                            <input id="profile_mid_name" style="text-transform: uppercase;" type="text" name="profile_mid_name" class="form-control" placeholder="Middle Name" minlength="2" required autocomplete="off">
                        </div>
                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Name Extension <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">(JR., SR)</span> </label>
                            <input id="profile_name_extension" style="text-transform: uppercase;" type="text" name="profile_mid_name" class="form-control" placeholder="Name Extension" minlength="2" required autocomplete="off">
                        </div>
                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Date of Birth  </label>
                            <input id="profile_date_birth" type="date" class="form-control">
                        </div>
                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Place of Birth  </label>
                            <input id="profile_place_birth" type="text" style="text-transform: uppercase;" name="profile_mid_name" class="form-control" placeholder="Place of Birth" minlength="2" required autocomplete="off">
                        </div>
                        <div class="input-form col-span-12 lg:col-span-6">

                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Sex  </label>
                            <select class="select2 w-full" id="application_gender">
                                <option></option>
                                @forelse (get_gender('') as $gender)
                                    <option value="{{ $gender->gender }}">{{ $gender->gender }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>

                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Citizenship  </label>
                            <div class="form-check pl-5 mt-5">

                                <input id="citizen_filipino" class="form-check-input" type="radio" name="vertical_radio_button" value="Filipino"> <label class="form-check-label" for="radio-switch-1">Filipino</label>

                                <div class="ml-8">
                                    <input id="citizen_dual" class="form-check-input" type="radio" name="vertical_radio_button" value="DUAL_CITIZENSHIP"> <label class="form-check-label" for="radio-switch-1">Dual Citizenship</label>
                                </div>

                            </div>
                            <div id="if_dual_citizen" class="hidden">
                                <div class="form-check pl-5 mt-5">
                                    <div class="pl-17 ml-8">
                                        <input id="by_birth" class="form-check-input" type="checkbox" name="by_birth" value="BY_BIRTH"> <label class="form-check-label" for="radio-switch-2">By Birth</label>
                                        <input id="by_naturalization" class="form-check-input ml-5" type="checkbox" name="by_naturalization" value="BY_NATURALIZATION"> <label class="form-check-label" for="radio-switch-2">By Naturalization</label>
                                    </div>
                                </div>
                                <div class="input-form col-span-12 lg:col-span-6 mt-5">
                                    <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> If holder of dual citizenship, please indicate the details.  </label>
                                    <div class="form-check">
                                        <select class="select2 w-full" style="width: 100%" id="citizenship_country">
                                            <option></option>
                                            @forelse (get_country('') as $country)
                                                <option value="{{ $country->nicename }}">{{ $country->nicename }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Civil Status </label>
                            <select class="select2 w-full" style="width: 100%" id="profile_civil_status">
                                <option></option>
                                @forelse (get_civil_status('') as $status)
                                    <option value="{{ $status->civil_status }}">{{ $status->civil_status }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>

                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Height (m) </label>
                            <input id="profile_height" type="number" name="profile_height" class="form-control" placeholder="Height" minlength="2" required autocomplete="off">
                        </div>
                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Weight (kg) </label>
                            <input id="profile_weight" type="number" name="profile_weight" class="form-control" placeholder="Weight" minlength="2" required autocomplete="off">
                        </div>
                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Blood Type </label>
                            <input id="profile_blood_type" style="text-transform: uppercase;" type="text" name="profile_blood_type" class="form-control" placeholder="Blood Type" minlength="2" required autocomplete="off">
                        </div>
                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> GSIS ID NO. </label>
                            <input id="profile_gsis"style="text-transform: uppercase;" type="tel" name="profile_gsis" class="form-control" placeholder="GSIS ID NO." minlength="11" required autocomplete="off">
                        </div>
                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> PAG-IBIG ID NO. </label>
                            <input id="profile_pagibig" style="text-transform: uppercase;" type="tel" name="profile_pagibig" class="form-control" placeholder="PAG-IBIG ID NO." minlength="11" required autocomplete="off">
                        </div>
                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> PHILHEALTH NO. </label>
                            <input id="profile_philhealth"style="text-transform: uppercase;" type="tel" name="profile_philhealth" class="form-control" placeholder="PHILHEALTH NO." minlength="11" required autocomplete="off">
                        </div>
                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> TIN NO. </label>
                            <input id="profile_tin" type="tel" style="text-transform: uppercase;" name="profile_tin" class="form-control" placeholder="TIN NO." minlength="11" required autocomplete="off">
                        </div>
                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> AGENCY EMPLOYEE NO. </label>
                            <input id="profile_agency"style="text-transform: uppercase;" type="tel" name="profile_agency" class="form-control" placeholder="AGENCY EMPLOYEE NO." minlength="11" required autocomplete="off">
                        </div>
                        <div class="hidden input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Age </label>
                            <input id="profile_age" type="number" name="profile_age" class="form-control" placeholder="Age" minlength="2" required autocomplete="off">
                        </div>
                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Telephone Number </label>
                            <input id="profile_tel_number" type="tel" style="text-transform: uppercase;" name="profile_phone_number" class="form-control" placeholder="Telephone Number" minlength="11" required autocomplete="off">
                        </div>
                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Mobile Number </label>
                            <input id="profile_mobile_number" style="text-transform: uppercase;" type="tel" name="profile_phone_number" class="form-control" placeholder="Mobile Number" minlength="11" required autocomplete="off">
                        </div>
                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Email Address <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">(if any)</span> </label>
                            <input id="profile_email"  type="email" name="profile_email" class="form-control" placeholder="Email Address" minlength="11" required autocomplete="off">
                        </div>
                    </div>
                </div>
                <!-- END: Personal Information -->

                <!-- BEGIN: Residential Address -->
                <div class="intro-y box col-span-12 lg:col-span-6">
                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto">
                            Residential Address
                        </h2>
                        <a href="javascript:;" id="btn_same_address" class="ml-auto text-primary truncate flex items-center">
                            The same permanent address<i data-lucide="chevrons-right" class="w-4 h-4 ml-2"></i>
                        </a>
                    </div>
                    <div class="p-5 grid grid-cols-12 gap-6">
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
                                </select>
                        </div>

                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Barangay </label>
                            <select class="select2 w-full ref_brgy">
                                <option></option>
                            </select>
                        </div>

                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Subdivision/Village </label>
                            <input id="res_sub" type="text" style="text-transform:uppercase" name="res_sub" class="form-control" placeholder="Subdivision/Village" minlength="2" autocomplete="off">
                        </div>

                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Street </label>
                            <input id="res_street" type="text" style="text-transform:uppercase" name="profile_street" class="form-control" placeholder="Street" minlength="2" autocomplete="off">
                        </div>

                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> House/Block/Lot No. </label>
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
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Subdivision/Village </label>
                            <input id="per_sub" type="text" style="text-transform:uppercase" name="per_sub" class="form-control" placeholder="Subdivision/Village" minlength="2" autocomplete="off">
                        </div>

                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Street </label>
                            <input id="per_street" type="text" style="text-transform:uppercase" name="per_street" class="form-control" placeholder="Street" minlength="2" autocomplete="off">
                        </div>

                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> House/Block/Lot No. </label>
                            <input id="per_house_block" type="text" style="text-transform:uppercase" name="per_house_block" class="form-control" placeholder="House/Block/Lot No." minlength="2" autocomplete="off">
                        </div>

                        <div class="input-form col-span-12 lg:col-span-12">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> ZIP Code</label>
                            <input id="per_zip_code" type="number" name="per_zip_code" class="form-control" placeholder="ZIP Code" minlength="2" autocomplete="off" required>
                        </div>
                    </div>
                </div>
                <!-- END: Permanent Address -->

                <!-- BEGIN: Family Background -->
                <div class="intro-y box col-span-12 lg:col-span-12">
                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto">
                            II. Family Background
                        </h2>
                    </div>
                    <div id="family_bg_div"  class="p-5 grid grid-cols-12 gap-6">

                        <div class="grid col-span-6 lg:col-span-12 gap-4">
                            <!-- BEGIN: Spouse's INFO -->
                            <div class="input-form col-span-6 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Spouse's Surname </label>
                                <input id="fam_spouse_surname" style="text-transform:uppercase" type="text" name="fam_spouse_surname" class="form-control" placeholder="Spouse's Surname" minlength="2" autocomplete="off">
                            </div>
                            <div class="input-form col-span-12 lg:col-span-3">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> First Name </label>
                                <input id="fam_spouse_first_name" style="text-transform:uppercase" type="text" name="fam_spouse_first_name" class="form-control" placeholder="First Name" minlength="2" autocomplete="off">
                            </div>
                            <div class="input-form col-span-6 lg:col-span-3">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Name Extension <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">(JR, SR)</span> </label>
                                <input id="fam_spouse_name_ext" style="text-transform:uppercase" type="text" name="fam_father_name_ext" class="form-control" placeholder="Name Extension" minlength="2" autocomplete="off">
                            </div>
                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Middle Name </label>
                                <input id="fam_spouse_mid_name" style="text-transform:uppercase" type="text" name="fam_spouse_mid_name" class="form-control" placeholder="Middle Name" minlength="2" autocomplete="off">
                            </div>
                            <!-- END: Spouse's INFO -->
                        </div>

                        <div class="grid col-span-6 lg:col-span-12 gap-4">
                            <!-- BEGIN: Fathers INFO -->
                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Fathers Surname </label>
                                <input id="fam_father_surname" style="text-transform:uppercase" type="text" name="fam_father_surname" class="form-control" placeholder="Surname" minlength="2" autocomplete="off">
                            </div>
                            <div class="input-form col-span-6 lg:col-span-3">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> First Name </label>
                                <input id="fam_father_first_name" style="text-transform:uppercase" type="text" name="fam_father_first_name" class="form-control" placeholder="First Name" minlength="2" autocomplete="off">
                            </div>
                            <div class="input-form col-span-6 lg:col-span-3">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Name Extension <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">(JR, SR)</span> </label>
                                <input id="fam_father_name_ext" style="text-transform:uppercase" type="text" name="fam_father_name_ext" class="form-control" placeholder="Name Extension" minlength="2" autocomplete="off">
                            </div>
                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Middle Name </label>
                                <input id="fam_father_mid_name" style="text-transform:uppercase" type="text" name="fam_father_mid_name" class="form-control" placeholder="Middle Name" minlength="2" autocomplete="off">
                            </div>
                            <!-- END: Fathers INFO -->
                        </div>

                        <div class="grid col-span-6 lg:col-span-12 gap-4">
                            <!-- CONTINUATION: Spouse's INFO -->
                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Occupation </label>
                                <input id="spouse_occupation" style="text-transform:uppercase" type="text" name="fam_occupation" class="form-control" placeholder="Occupation" minlength="2" autocomplete="off">
                            </div>
                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Employer/Business Name </label>
                                <input id="occupation_employer" style="text-transform:uppercase" type="text" name="occupation_employer" class="form-control" placeholder="Employer/Business Name" minlength="2" autocomplete="off">
                            </div>
                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Business Address </label>
                                <input id="occupation_address" style="text-transform:uppercase" type="text" name="occupation_address" class="form-control" placeholder="Business Address" minlength="2" autocomplete="off">
                            </div>
                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Telephone No. </label>
                                <input id="occupation_tel_no" style="text-transform:uppercase" type="text" name="occupation_tel_no" class="form-control" placeholder="Telephone No." minlength="2" autocomplete="off">
                            </div>
                            <!-- CONTINUATION: Spouse's INFO -->
                        </div>

                        <div class="grid col-span-6 lg:col-span-12 gap-4">
                            <!-- BEGIN: Mothers INFO -->
                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Mother's Maiden Name </label>
                                <input id="fam_mother_maiden_name" style="text-transform:uppercase" type="text" name="fam_mother_maiden_name" class="form-control" placeholder="Mother's Maiden Name" minlength="2" autocomplete="off">
                            </div>
                            <div class="input-form col-span-6 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Surname </label>
                                <input id="fam_mother_surname" style="text-transform:uppercase" type="text" name="fam_mother_surname" class="form-control" placeholder="Surname" minlength="2" autocomplete="off">
                            </div>
                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> First Name </label>
                                <input id="fam_mother_first_name"style="text-transform:uppercase" type="text" name="fam_father_first_name" class="form-control" placeholder="First Name" minlength="2" autocomplete="off">
                            </div>
                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Middle Name </label>
                                <input id="fam_mother_mid_name" style="text-transform:uppercase" type="text" name="fam_father_mid_name" class="form-control" placeholder="Middle Name" minlength="2" autocomplete="off">
                            </div>
                            <!-- END: Mothers INFO -->
                        </div>

                    </div>

                    <div class="flex items-center px-5 pt-5 mt-5 border-t border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto">
                            NAME of CHILDREN <span class="sm:ml-auto sm:mt-0 text-xs text-slate-500">(Write full name and list all)</span>
                        </h2>
                        <a href="javascript:;" id="add_child_list" class="ml-auto text-primary truncate flex items-center"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="plus" data-lucide="plus" class="lucide lucide-plus w-4 h-4 mr-1"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Add </a>

                    </div>

                    <div class="intro-y box p-5">
                        <div class="overflow-x-auto scrollbar-hidden">
                            <table id="table_name_of_child" class="table table-bordered">
                                <thead >
                                <tr>

                                    <th >Name of Children</th>
                                    <th >Date of Birth</th>
                                    <th class="flex justify-center">Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>
                <!-- END: Family Background -->

                <!-- BEGIN: Educational Background -->
                <div class="intro-y box col-span-12 lg:col-span-12">
                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto">
                            III. Educational Background
                        </h2>
                        <a href="javascript:;" id="btn_toggle_add_educ_bg_modal" class="ml-auto text-primary truncate flex items-center"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="plus" data-lucide="plus" class="lucide lucide-plus w-4 h-4 mr-1"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Add </a>
{{--                        <a href="javascript:;" id="sample_save_educ_bg" class="ml-auto text-primary truncate flex items-center"> <i data-lucide="send" class="w-4 h-4 mr-2"></i> Save </a>--}}

                    </div>
                    <div class="intro-y box p-5">
                        <div class="overflow-x-auto scrollbar-hidden">
                            <table id="dt__educational_bg_new" class="table table-bordered pb-10">
                                <thead >
                                <tr>
                                    <th rowspan="2">Level</th>
                                    <th rowspan="2" class="text-center">Name of School <div class="leading-relaxed text-slate-500 text-xs mt-2">(Write in full)</div></th>
                                    <th rowspan="2" class="text-center">Basic Education/Degree/Course <div class="leading-relaxed text-slate-500 text-xs mt-2">(Write in full)</div></th>
                                    <th colspan="2" class="text-center">Period of Attendance</th>
                                    <th rowspan="2" class="text-center">Highest Level/Units Earned <div class="leading-relaxed text-slate-500 text-xs mt-2">(if not graduated)</div></th>
                                    <th rowspan="2" class="text-center">Year Graduated</th>
                                    <th rowspan="2" class="text-center">Scholarship/Academic Honors Received</th>
                                    <th rowspan="2" class="text-center">Action</th>
                                </tr>
                                <tr>

                                    <td class="text-center">From</td>
                                    <td class="text-center">To</td>

                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END: Educational Background -->


                <!-- BEGIN: Civil Service Eligibility -->
                <div class="intro-y box col-span-12 lg:col-span-12">
                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto">
                            IV. Civil Service Eligibility
                        </h2>
                        <a href="javascript:;" id="add_civil_service" class="ml-auto text-primary truncate flex items-center"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="plus" data-lucide="plus" class="lucide lucide-plus w-4 h-4 mr-1"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Add </a>
                    </div>
                    <div class="intro-y box p-5">
                        <div class="overflow-x-auto scrollbar-hidden">
                            <table id="dt__civil_service"  class="table table-bordered sig_modal_table pb-10">
                                <thead>
                                <tr>
                                    <th rowspan="2" class="text-center">Career Service/ RA 1080 (BOARD/ BAR) Under Special Laws/ CES/ CSEE Barangay Eligibility / Driver's License</th>
                                    <th rowspan="2" class="text-center">Rating <div class="leading-relaxed text-slate-500 text-xs mt-2">(if applicable)</div></th>
                                    <th rowspan="2" class="text-center">Date of Examination / Conferment </th>
                                    <th rowspan="2" class="text-center">Place of Examination / Conferment</th>
                                    <th colspan="2" class="text-center">License (if applicable)</th>
                                    <th rowspan="2" class="text-center">Action</th>
                                </tr>

                                <tr>

                                    <td class="text-center">Number</td>
                                    <td class="text-center">Date of Validity</td>

                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END: Civil Service Eligibility -->

                <!-- BEGIN: Work Experience -->
                <div class="intro-y box col-span-12 lg:col-span-12">
                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto">
                            V. Work Experience
                        </h2>
                        <a href="javascript:;" id="add_work_exp" class="ml-auto text-primary truncate flex items-center"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="plus" data-lucide="plus" class="lucide lucide-plus w-4 h-4 mr-1"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Add </a>
                    </div>
                    <div class="intro-y box p-5">
                        <div class="overflow-x-auto scrollbar-hidden">
                            <table id="dt__work_exp" class="table table-bordered sig_modal_table pb-10">
                                <thead>
                                <tr>
                                    <th colspan="2" class="text-center">Inclusive Dates</th>
                                    <th rowspan="2" class="text-center">Position Title <div class="leading-relaxed text-slate-500 text-xs mt-2">(Write in full/Do not abbreviate)</div></th>
                                    <th rowspan="2" class="text-center">Department / Agency / Office / Company <div class="leading-relaxed text-slate-500 text-xs mt-2">(Write in full/Do not abbreviate)</div> </th>
                                    <th rowspan="2" class="text-center">Monthly Salary </th>
                                    <th rowspan="2" class="text-center">Salary/Job/Pay Grade <div class="leading-relaxed text-slate-500 text-xs mt-2">(if applicable) & STEP (Format "00-0") / INCREMENT</div> </th>
                                    <th rowspan="2" class="text-center">Status of Appointment </th>
                                    <th rowspan="2" class="text-center">Government Service <div class="leading-relaxed text-slate-500 text-xs mt-2">(Y/N)</div> </th>
                                    <th rowspan="2" class="text-center">Action</th>

                                </tr>
                                <tr>

                                    <td class="text-center">From</td>
                                    <td class="text-center">To</td>

                                </tr>

                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END: Work Experience -->

                <!-- BEGIN: Voluntary Work or Involvement in Civic/Non-Government/People/Voluntary Organizations -->
                <div class="intro-y box col-span-12 lg:col-span-12">
                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto">
                            VI. Voluntary Work or Involvement in Civic / Non-Government / People / Voluntary Organization/s
                        </h2>
                        <a href="javascript:;" id="add_voluntary_work" class="ml-auto text-primary truncate flex items-center"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="plus" data-lucide="plus" class="lucide lucide-plus w-4 h-4 mr-1"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Add </a>
                    </div>
                    <div class="intro-y box p-5">
                        <div class="overflow-x-auto scrollbar-hidden">
                            <table id="dt__voluntary" class="table table-bordered sig_modal_table pb-10">
                                <thead>
                                <tr>
                                    <th rowspan="2" class="text-center">Name & Address of Organization <div class="leading-relaxed text-slate-500 text-xs mt-2">(Write in full)</div> </th>
                                    <th colspan="2" class="text-center">Inclusive Dates <div class="leading-relaxed text-slate-500 text-xs mt-2">(mm/dd/yyyy)</div> </th>
                                    <th rowspan="2" class="text-center">Number of Hours </th>
                                    <th rowspan="2" class="text-center">Position / Nature of Work </th>
                                    <th rowspan="2" class="text-center">Action</th>

                                </tr>
                                <tr>

                                    <td class="text-center">From</td>
                                    <td class="text-center">To</td>

                                </tr>

                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END: Voluntary Work or Involvement in Civic/Non-Government/People/Voluntary Organizations -->

                <!-- BEGIN: LEARNING AND DEVELOPMENT (L&D) INTERVENTIONS/TRAINING PROGRAMS ATTENDED -->
                <div class="intro-y box col-span-12 lg:col-span-12">
                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto">
                            VII. Learning and Development (L&D) Interventions/Training Programs Attended
                        </h2>
                        <a href="javascript:;" id="add_ld" class="ml-auto text-primary truncate flex items-center"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="plus" data-lucide="plus" class="lucide lucide-plus w-4 h-4 mr-1"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Add </a>
                    </div>
                    <div class="intro-y box p-5">
                        <div class="overflow-x-auto scrollbar-hidden">
                            <table id="dt__LD" class="table table-bordered sig_modal_table pb-10">
                                <thead>
                                <tr>

                                    <th rowspan="2" class="text-center">Title of Learning and Development Interventions / Training Programs <div class="leading-relaxed text-slate-500 text-xs mt-2">(Write in full)</div> </th>
                                    <th colspan="2" class="text-center">Inclusive Dates of Attendance <div class="leading-relaxed text-slate-500 text-xs mt-2">(mm/dd/yyyy)</div> </th>
                                    <th rowspan="2" class="text-center">Number of Hours </th>
                                    <th rowspan="2" class="text-center">Type of LD <div class="leading-relaxed text-slate-500 text-xs mt-2">(Managerial/Supervisory/Technical/etc)</div> </th>
                                    <th rowspan="2" class="text-center">Conducted / Sponsored By <div class="leading-relaxed text-slate-500 text-xs mt-2">(Write in full)</div> </th>
                                    <th rowspan="2" class="text-center">Action</th>

                                </tr>

                                <tr>

                                    <td class="text-center">From</td>
                                    <td class="text-center">To</td>

                                </tr>

                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END: LEARNING AND DEVELOPMENT (L&D) INTERVENTIONS/TRAINING PROGRAMS ATTENDED -->

                <!-- BEGIN: VIII.  OTHER INFORMATION -->
                <div class="intro-y box col-span-12 lg:col-span-12">
                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto">
                            VIII.  Other Information
                        </h2>
                        <a href="javascript:;" id="add_other_info" class="ml-auto text-primary truncate flex items-center"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="plus" data-lucide="plus" class="lucide lucide-plus w-4 h-4 mr-1"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Add </a>

                    </div>

                    <!-- BEGIN: VIII.  Special Skills -->
                    <div class="intro-y box p-5">
                        <div class="overflow-x-auto scrollbar-hidden">
                            <table id="dt__special_skill" class="table table-bordered sig_modal_table pb-10">
                                <thead >
                                <tr>

                                    <th rowspan="2" class="text-center">Special Skills and Hobbies </th>
                                    <th rowspan="2" class="text-center">Non-Academic Distinctions / Recognition <div class="leading-relaxed text-slate-500 text-xs mt-2">(Write in full)</div> </th>
                                    <th rowspan="2" class="text-center">Membership in Association / Organization <div class="leading-relaxed text-slate-500 text-xs mt-2">(Write in full)</div> </th>
                                    <th rowspan="2" class="text-center">Action</th>

                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END: VIII.  Special Skills -->

                    <!-- BEGIN: IV Last Part Of PDS -->
                    <div class="intro-y box p-5">

                        <!-- BEGIN: Number 34 -->
                        <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md overflow-x-auto scrollbar-hidden">
                            <div class="p-5">
                                <div class="font-medium">34. Are you related by consanguinity or affinity to the appointing or recommending authority, or to the chief of bureau or office or to the person who has immediate supervision over you in the Office, Bureau or Department where you will be appointed,</div>

                                <div class="ml-5">
                                    <div class="font-medium mt-5">A. Within the third degree?</div>
                                    <div class="mt-5">
                                        <input id="btn_34_a_yes" class="form-check-input" type="checkbox" name="btn_34_a_yes" value="YES"> <label class="form-check-label" for="radio-switch-2">YES</label>
                                        <input id="btn_34_a_no" class="form-check-input ml-5" type="checkbox" name="NO" value="by-naturalization"> <label class="form-check-label" for="radio-switch-2">NO</label>

                                    </div>

                                    <div class="font-medium mt-5">B. Within the fourth degree (for Local Government Unit - Career Employees)?</div>
                                    <div class="mt-5">
                                        <input id="btn_34_b_yes" class="form-check-input" type="checkbox" name="btn_34_b_yes" value="YES"> <label class="form-check-label" for="radio-switch-2">YES</label>
                                        <input id="btn_34_b_no" class="form-check-input ml-5" type="checkbox" name="btn_34_b_no" value="NO"> <label class="form-check-label" for="radio-switch-2">NO</label>

                                    </div>
                                    <div id="others_34_b_yes_div" class="mt-5">
                                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> if YES, give details </label>
                                        <input id="others_34_b_yes" style="width: 50%" type="tel" name="others_34_b_yes" class="form-control" placeholder="Write full details" minlength="11" required autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Number 34 -->

                        <!-- BEGIN: Number 35 -->
                        <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md overflow-x-auto scrollbar-hidden mt-5">
                            <div class="p-5">
                                <div class="font-medium">35. A. Have you ever been found guilty of any administrative offense?</div>

                                <div class="ml-5">
                                    <div class="mt-5">
                                        <input id="btn_35_a_yes" class="form-check-input" type="checkbox" name="btn_35_a_yes" value="by-birth"> <label class="form-check-label" for="radio-switch-2">YES</label>
                                        <input id="btn_35_a_no" class="form-check-input ml-5" type="checkbox" name="btn_35_a_no" value="by-naturalization"> <label class="form-check-label" for="radio-switch-2">NO</label>

                                    </div>
                                    <div id="others_35_a_yes_div" class="mt-5">
                                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> if YES, give details </label>
                                        <input id="others_35_a_yes" style="width: 50%" type="tel" name="others_35_a_yes" class="form-control" placeholder="Write full details" minlength="11" required autocomplete="off">
                                    </div>

                                    <div class="font-medium mt-5">B. Have you been criminally charged before any court? </div>
                                    <div class="mt-5">
                                        <input id="btn_35_b_yes" class="form-check-input" type="checkbox" name="btn_35_b_yes" value="by-birth"> <label class="form-check-label" for="radio-switch-2">YES</label>
                                        <input id="btn_35_b_no" class="form-check-input ml-5" type="checkbox" name="btn_35_b_no" value="by-naturalization"> <label class="form-check-label" for="radio-switch-2">NO</label>

                                    </div>
                                    <div id="others_35_b_yes_div" class="grid grid-cols-12 gap-6 mt-5">
                                        <div class="input-form col-span-12 lg:col-span-12">
                                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> if YES, give details </label>
                                            <input id="others_35_b_yes" style="width: 50%" type="text" name="others_35_b_yes" class="form-control" placeholder="Write full details" minlength="11" required autocomplete="off">
                                        </div>

                                        <div class="input-form col-span-12 lg:col-span-6">
                                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Status of Case/s </label>
                                            <input id="others_35_b_status_case" type="text" name="others_35_b_status_case" class="form-control" placeholder="Status of Case/s" minlength="11" required autocomplete="off">
                                        </div>

                                        <div class="input-form col-span-12 lg:col-span-6">
                                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Date Filed </label>
                                            <input id="others_35_b_date_filed" type="date" name="others_35_b_date_filed" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Number 35 -->

                        <!-- BEGIN: Number 36 -->
                        <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md overflow-x-auto scrollbar-hidden mt-5">
                            <div class="p-5">
                                <div class="font-medium">36. Have you ever been convicted of any crime or violation of any law, decree, ordinance or regulation by any court or tribunal?</div>

                                <div class="ml-5">
                                    <div class="mt-5">
                                        <input id="btn_36_yes" class="form-check-input" type="checkbox" name="btn_36_yes" value="by-birth"> <label class="form-check-label" for="radio-switch-2">YES</label>
                                        <input id="btn_36_no" class="form-check-input ml-5" type="checkbox" name="btn_36_no" value="by-naturalization"> <label class="form-check-label" for="radio-switch-2">NO</label>

                                    </div>
                                    <div id="others_36_yes_div" class="mt-5">
                                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> if YES, give details </label>
                                        <input id="others_36_yes" style="width: 50%" type="text" name="others_36_yes" class="form-control" placeholder="Write full details" minlength="11" required autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Number 36 -->

                        <!-- BEGIN: Number 37 -->
                        <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md overflow-x-auto scrollbar-hidden mt-5">
                            <div class="p-5">
                                <div class="font-medium">37. Have you ever been separated from the service in any of the following modes: resignation, retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or phased out (abolition) in the public or private sector?</div>

                                <div class="ml-5">
                                    <div class="mt-5">
                                        <input id="btn_37_yes" class="form-check-input" type="checkbox" name="btn_37_yes" value="by-birth"> <label class="form-check-label" for="radio-switch-2">YES</label>
                                        <input id="btn_37_no" class="form-check-input ml-5" type="checkbox" name="btn_37_no" value="by-naturalization"> <label class="form-check-label" for="radio-switch-2">NO</label>

                                    </div>
                                    <div id="others_37_yes_div" class="mt-5">
                                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> if YES, give details </label>
                                        <input id="others_37_yes" style="width: 50%" type="tel" name="others_37_yes" class="form-control" placeholder="Write full details" minlength="11" required autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Number 37 -->

                        <!-- BEGIN: Number 38 -->
                        <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md overflow-x-auto scrollbar-hidden mt-5">
                            <div class="p-5">
                                <div class="font-medium">38. A. Have you ever been a candidate in a national or local election held within the last year (except Barangay election)?</div>

                                <div class="ml-5">
                                    <div class="mt-5">
                                        <input id="btn_38_a_yes" class="form-check-input" type="checkbox" name="btn_35_a_yes" value="by-birth"> <label class="form-check-label" for="radio-switch-2">YES</label>
                                        <input id="btn_38_a_no" class="form-check-input ml-5" type="checkbox" name="btn_35_a_no" value="by-naturalization"> <label class="form-check-label" for="radio-switch-2">NO</label>

                                    </div>
                                    <div id="others_38_a_yes_div" class="mt-5">
                                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> if YES, give details </label>
                                        <input id="others_38_a_yes" style="width: 50%" type="tel" name="others_38_a_yes" class="form-control" placeholder="Write full details" minlength="11" required autocomplete="off">
                                    </div>

                                    <div class="font-medium mt-5">B. Have you resigned from the government service during the three (3)-month period before the last election to promote/actively campaign for a national or local candidate?</div>
                                    <div class="mt-5">
                                        <input id="btn_38_b_yes" class="form-check-input" type="checkbox" name="btn_38_b_yes" value="by-birth"> <label class="form-check-label" for="radio-switch-2">YES</label>
                                        <input id="btn_38_b_no" class="form-check-input ml-5" type="checkbox" name="btn_38_b_no" value="by-naturalization"> <label class="form-check-label" for="radio-switch-2">NO</label>
                                    </div>

                                    <div id="others_38_b_yes_div" class="mt-5">
                                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> if YES, give details </label>
                                        <input id="others_38_b_yes" type="tel" style="width: 50%" name="others_38_b_yes" class="form-control" placeholder="Write full details" minlength="11" required autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Number 35 -->

                        <!-- BEGIN: Number 39 -->
                        <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md overflow-x-auto scrollbar-hidden mt-5">
                            <div class="p-5">
                                <div class="font-medium">39. Have you acquired the status of an immigrant or permanent resident of another country?</div>

                                <div class="ml-5">
                                    <div class="mt-5">
                                        <input id="btn_39_yes" class="form-check-input" type="checkbox" name="btn_39_yes" value="by-birth"> <label class="form-check-label" for="radio-switch-2">YES</label>
                                        <input id="btn_39_no"  class="form-check-input ml-5" type="checkbox" name="btn_39_no" value="by-naturalization"> <label class="form-check-label" for="radio-switch-2">NO</label>

                                    </div>
                                    <div id="others_39_yes_div" class="mt-5">
                                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> if YES, give details (country) </label>
                                        <select class="select2 w-full" style="width: 50%" id="others_39_yes">
                                            <option></option>
                                            @forelse (get_country('') as $country)
                                                <option value="{{ $country->nicename }}">{{ $country->nicename }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Number 39 -->

                        <!-- BEGIN: Number 40 -->
                        <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md overflow-x-auto scrollbar-hidden mt-5">
                            <div class="p-5">
                                <div class="font-medium">40. Pursuant to: (a) Indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons (RA 7277); and (c) Solo Parents Welfare Act of 2000 (RA 8972), please answer the following items:</div>

                                <div class="ml-5">
                                    <div class="font-medium mt-5">A. Are you a member of any indigenous group?</div>
                                    <div class="mt-5">
                                        <input id="btn_40_a_yes" class="form-check-input" type="checkbox" name="btn_40_a_yes" value="by-birth"> <label class="form-check-label" for="radio-switch-2">YES</label>
                                        <input id="btn_40_a_no" class="form-check-input ml-5" type="checkbox" name="btn_40_a_no" value="by-naturalization"> <label class="form-check-label" for="radio-switch-2">NO</label>

                                    </div>
                                    <div id="others_40_a_yes_div" class="mt-5">
                                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> if YES, please specify: </label>
                                        <input id="others_40_a_yes" style="width: 50%" type="tel" name="others_40_a_yes" class="form-control" placeholder="Write full details" minlength="11" required autocomplete="off">
                                    </div>

                                    <div class="font-medium mt-5">B. Are you a person with disability?</div>
                                    <div class="mt-5">
                                        <input id="btn_40_b_yes" class="form-check-input" type="checkbox" name="btn_40_b_yes" value="by-birth"> <label class="form-check-label" for="radio-switch-2">YES</label>
                                        <input id="btn_40_b_no" class="form-check-input ml-5" type="checkbox" name="btn_40_b_no" value="by-naturalization"> <label class="form-check-label" for="radio-switch-2">NO</label>
                                    </div>
                                    <div id="others_40_b_yes_div" class="mt-5">
                                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> if YES, please specify ID No: </label>
                                        <input id="others_40_b_yes" style="width: 50%" type="tel" name="others_40_b_yes" class="form-control" placeholder="Write full details" minlength="11" required autocomplete="off">
                                    </div>

                                    <div class="font-medium mt-5">C. Are you a solo parent?</div>
                                    <div class="mt-5">
                                        <input id="btn_40_c_yes" class="form-check-input" type="checkbox" name="btn_40_b_yes" value="by-birth"> <label class="form-check-label" for="radio-switch-2">YES</label>
                                        <input id="btn_40_c_no" class="form-check-input ml-5" type="checkbox" name="btn_40_b_no" value="by-naturalization"> <label class="form-check-label" for="radio-switch-2">NO</label>
                                    </div>
                                    <div id="others_40_c_yes_div" class="mt-5">
                                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> if YES, please specify ID No: </label>
                                        <input id="others_40_c_yes" style="width: 50%" type="tel" name="others_40_c_yes" class="form-control" placeholder="Write full details" minlength="11" required autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Number 40 -->

                        <!-- BEGIN: REFERENCES -->
                        <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md overflow-x-auto scrollbar-hidden mt-5">
                            <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                                <h2 class="font-medium text-base mr-auto">
                                    References (Person not related by consanguinity or affinity to applicant /appointee)
                                </h2>
                                <a href="javascript:;" id="add_references" class="ml-auto text-primary truncate flex items-center"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="plus" data-lucide="plus" class="lucide lucide-plus w-4 h-4 mr-1"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Add </a>

                            </div>
                            <div class="intro-y box p-5">
                                <div class="overflow-x-auto scrollbar-hidden">
                                    <table id="dt__reference" class="table table-bordered pb-10">
                                        <thead >
                                        <tr>

                                            <th rowspan="2" class="text-center">Name </th>
                                            <th rowspan="2" class="text-center">Address</th>
                                            <th rowspan="2" class="text-center">Tel. No</th>
                                            <th rowspan="2" class="text-center">Action</th>

                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- END: REFERENCES -->

                        <!-- BEGIN: GOVERNMENT IDS -->
                        <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md overflow-x-auto scrollbar-hidden mt-5">
                            <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                                <h2 class="font-medium text-base mr-auto">
                                    Government Issued ID (i.e.Passport, GSIS, SSS, PRC, Driver's License, etc.) PLEASE INDICATE ID Number and Date of Issuance
                                </h2>
                            </div>
                            <div class="intro-y box col-span-12 lg:col-span-12">
                                <div class="p-5 grid grid-cols-12 gap-6">
                                    <div class="grid col-span-6 lg:col-span-12 gap-4">

                                        <div class="input-form col-span-6 lg:col-span-6">
                                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Government Issued ID </label>
                                            <select class="select2 w-full" style="width: 100%" id="government_ids">
                                                <option></option>
                                                <option value="PASSPORT">PASSPORT</option>
                                                <option value="GSIS">GSIS</option>
                                                <option value="SSS">SSS</option>
                                                <option value="PRC">PRC</option>
                                                <option value="DRIVER'S LICENSE">DRIVER'S LICENSE</option>
                                                <option value="OTHERS">OTHERS"</option>
                                            </select>
                                        </div>
                                        <div class="input-form col-span-12 lg:col-span-3">
                                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> ID/License/Passport No. </label>
                                            <input id="government_license_no" style="text-transform:uppercase" type="text" name="fam_spouse_first_name" class="form-control" placeholder="ID/License/Passport No." minlength="2" autocomplete="off">
                                        </div>
                                        <div class="input-form col-span-6 lg:col-span-3">
                                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Date/Place of Issuance <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">(JR, SR)</span> </label>
                                            <input id="government_license_issuance" style="text-transform:uppercase" type="text" name="fam_father_name_ext" class="form-control" placeholder="Date/Place of Issuance:" minlength="2" autocomplete="off">
                                        </div>
                                        <!-- END: Spouse's INFO -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: GOVERNMENT IDS -->


                    </div>
                    <!-- END IV Last Part Of PDS -->
                </div>
                <!-- END: VIII.  OTHER INFORMATION -->
            </div>
        </div>

        <!-- BEGIN: Account Settings -->
        <div id="account_settings" class="tab-pane" role="tabpanel" aria-labelledby="account_settings">
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
                            <label for="validation-form-2" class="form-label w-full flex flex-col sm:flex-row"> Email <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, email address format</span> </label>
                            <input id="account_email" type="email" name="account_email" class="form-control" placeholder="example@gmail.com" required autocomplete="off">
                        </div>
                        <div class="input-form col-span-12 lg:col-span-6">
                            <label for="validation-form-3" class="form-label w-full flex flex-col sm:flex-row"> Password <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Required, at least 4 characters</span> </label>


                            <div class="input-group mt-2">
                                <input id="account_password" type="password" name="account_pass" class="form-control" placeholder="Password" minlength="4" required>
                                <div id="input-group-price" class="input-group-text"><input id="btn_show_pass" class="form-check-input" type="checkbox" value=""></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
{{--                                        <div id="e_signature_status" class="flex text-slate-500 truncate text-xs mt-0.5"> Uploaded </a> <span class="mx-1">•</span> 21 seconds ago </div>--}}
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

{{--                                <div class="flex items-center px-5 py-3 border-t border-slate-200/60 dark:border-darkmode-400">--}}
{{--                                    <div class="intro-x flex mr-2">--}}

{{--                                    </div>--}}

{{--                                    <a href="javascript:;" class="intro-x w-8 h-8 flex items-center justify-center rounded-full text-primary bg-primary/10 dark:bg-darkmode-300 dark:text-slate-300 ml-auto tooltip" title="Share E - Signature"> <i data-lucide="share-2" class="w-3 h-3"></i> </a>--}}
{{--                                    <a id="btn_download_e_sig" href="javascript:;" class="intro-x w-8 h-8 flex items-center justify-center rounded-full bg-primary text-white ml-2 tooltip" title="Download E - Signature"> <i data-lucide="share" class="w-3 h-3"></i> </a>--}}
{{--                                </div>--}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Electronic Signatures Settings -->

        <!-- END: BUTTON SAVE PDS-->
    </div>


        <div class="cursor-pointer shadow-md fixed bottom-0 right-0 box flex items-center justify-center z-50 mb-10 mr-10 btn_save_PDS_div">
            <div class="flex items-center px-5 py-8 sm:py-3 border-t border-slate-200/60 dark:border-darkmode-400">
                <a href="javascript:;" id="save_PDS_to_db" class="ml-auto btn btn-primary truncate flex items-center"> <i class="w-4 h-4 mr-2" data-lucide="save"></i> Save </a>
            </div>
        </div>

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
    <script src="{{ asset('/js/my_profile/profile.js') }}"></script>
    <script src="{{ asset('/js/my_profile/ref_address.js') }}"></script>
    <script src="{{ asset('/js/my_profile/update_profile_picture_pond.js') }}"></script>

    <script src="{{ asset('/js/my_profile/new_profile_uploader.js') }}"></script>
@endsection
