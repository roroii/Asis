<!-- Add Documents Modal -->
<div id="profile_modal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <!-- BEGIN: Modal Header -->
                <div id="profile_print_modal_title" class="modal-header flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">

                </div>
                <!-- END: Modal Header -->
                <!-- BEGIN: Modal Body -->


                <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                    <!-- BEGIN: Personal Information -->
                    <div class="intro-y col-span-12 lg:col-span-12">
                        <input hidden id="profile_modal_id" type="text" class="form-control" placeholder="id">


                        <div class="p-5 grid grid-cols-12 gap-6">
                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Surname </label>
                                <input id="modal_profile_last_name" type="text" name="modal_profile_last_name" class="form-control" placeholder="Surname" minlength="2" required autocomplete="off">
                            </div>
                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> First Name </label>
                                <input id="modal_profile_first_name" type="text" name="modal_profile_first_name" class="form-control" placeholder="First Name" minlength="2" required autocomplete="off">
                            </div>
                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Middle Name </label>
                                <input id="modal_profile_mid_name" type="text" name="modal_profile_mid_name" class="form-control" placeholder="Middle Name" minlength="2" required autocomplete="off">
                            </div>
                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Name Extension <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">(JR., SR)</span> </label>
                                <input id="modal_profile_name_extension" type="text" name="modal_profile_mid_name" class="form-control" placeholder="Name Extension" minlength="2" required autocomplete="off">
                            </div>
                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Date of Birth  </label>
                                <div class="relative w-auto mx-auto">
                                    <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                                        <i data-lucide="calendar" class="w-4 h-4"></i>
                                    </div> <input id="modal_profile_date_birth" type="date" class="form-control pl-12 ">
                                </div>
                            </div>
                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Place of Birth  </label>
                                <input id="modal_profile_place_birth" type="text" name="modal_profile_mid_name" class="form-control" placeholder="Place of Birth" minlength="2" required autocomplete="off">
                            </div>
                            <div class="input-form col-span-12 lg:col-span-6">

                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Sex  </label>
                                <select class="select2 w-full" id="modal_application_gender">
                                    @forelse (get_gender('') as $gender)
                                        <option value="{{ $gender->gender }}">{{ $gender->gender }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>



                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Civil Status </label>
                                <select class="select2 w-full" style="width: 100%" id="modal_profile_civil_status">
                                    @forelse (get_civil_status('') as $status)
                                        <option value="{{ $status->civil_status}}">{{ $status->civil_status }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>

                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Height (m) </label>
                                <input id="modal_profile_height" type="number" name="modal_profile_height" class="form-control" placeholder="Height" minlength="2" required autocomplete="off">
                            </div>
                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Weight (kg) </label>
                                <input id="modal_profile_weight" type="number" name="modal_profile_weight" class="form-control" placeholder="Weight" minlength="2" required autocomplete="off">
                            </div>
                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Blood Type </label>
                                <input id="modal_profile_blood_type" type="text" name="modal_profile_blood_type" class="form-control" placeholder="Blood Type" minlength="2" required autocomplete="off">
                            </div>
                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> GSIS ID NO. </label>
                                <input id="modal_profile_gsis" type="tel" name="modal_profile_gsis" class="form-control" placeholder="GSIS ID NO." minlength="11" required autocomplete="off">
                            </div>
                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> PAG-IBIG ID NO. </label>
                                <input id="modal_profile_pagibig" type="tel" name="modal_profile_pagibig" class="form-control" placeholder="PAG-IBIG ID NO." minlength="11" required autocomplete="off">
                            </div>
                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> PHILHEALTH NO. </label>
                                <input id="modal_profile_philhealth" type="tel" name="modal_profile_philhealth" class="form-control" placeholder="PHILHEALTH NO." minlength="11" required autocomplete="off">
                            </div>
                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> TIN NO. </label>
                                <input id="modal_profile_tin" type="tel" name="modal_profile_tin" class="form-control" placeholder="TIN NO." minlength="11" required autocomplete="off">
                            </div>
                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> AGENCY EMPLOYEE NO. </label>
                                <input disabled id="modal_profile_agency" type="tel" name="modal_profile_agency" class="form-control" placeholder="AGENCY EMPLOYEE NO." minlength="11" required autocomplete="off">
                            </div>
                            <div class="hidden input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Age </label>
                                <input id="modal_profile_age" type="number" name="modal_profile_age" class="form-control" placeholder="Age" minlength="2" required autocomplete="off">
                            </div>
                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Telephone Number </label>
                                <input id="modal_profile_tel_number" type="tel" name="modal_profile_phone_number" class="form-control" placeholder="Telephone Number" minlength="11" required autocomplete="off">
                            </div>
                            <div class="input-form col-span-12 lg:col-span-6">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Mobile Number </label>
                                <input id="modal_profile_mobile_number" type="tel" name="modal_profile_phone_number" class="form-control" placeholder="Mobile Number" minlength="11" required autocomplete="off">
                            </div>
                            <div class="input-form col-span-12 lg:col-span-12">
                                <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Email Address <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">(if any)</span> </label>
                                <input id="modal_profile_email" type="email" name="modal_profile_email" class="form-control" placeholder="Email Address" minlength="11" required autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <!-- END: Personal Information -->
                </div>

                <!-- END: Modal Body -->

                <!-- BEGIN: Modal Footer -->
                <div class="modal-footer">
                    <button id="cancel_documents_btn" type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                    {{-- <a href="javascript:;" id="load_profile_save" class="btn btn-primary w-20 load_profile_save"> Save </a> --}}
                    <button id="load_profile_save" class="btn btn-primary w-20 load_profile_save">Save</button>
                </div>
                <!-- END: Modal Footer -->
            </div>
        </form>
    </div>
</div>
<!-- END: Modal Content -->
