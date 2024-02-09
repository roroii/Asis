<div id="add_civil_service_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Civil Service</h2>
            </div>

            <div class="modal-body p-0">

                <div class="p-5 grid grid-cols-12 gap-6">

                    <input id="cs_eligibility_id" class="hidden">

                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Eligibity Type  </label>
                        <select class="select2 w-full" id="cs_type">
                            @forelse(get_Eligibility_type() as $eligibility)
                                <option value="{{ $eligibility->eligibility_type }}">{{ $eligibility->desc }}</option>
                            @empty
                            @endforelse
{{--                            <option value="Career Service">Career Service</option>--}}
{{--                            <option value="RA 1080 (BOARD/ BAR) UNDER SPECIAL LAWS">RA 1080 (BOARD/ BAR) UNDER SPECIAL LAWS</option>--}}
{{--                            <option value="CES">CES</option>--}}
{{--                            <option value="CSEE">CSEE</option>--}}
{{--                            <option value="BARANGAY ELIGIBILITY">BARANGAY ELIGIBILITY</option>--}}
{{--                            <option value="DRIVERS LICENSE">DRIVERS LICENSE</option>--}}
                        </select>
                    </div>

                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Rating <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">(if Applicable)</span> </label>
                        <input id="cs_rating" type="text" style="text-transform:uppercase"  name="cs_rating" class="form-control" placeholder="Ex: Rating or N/A if not applicable" minlength="2" required autocomplete="off">
                    </div>
                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Date of Examination/Conferment </label>
                        <div class="relative w-auto mx-auto">
                            <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                                <i data-lucide="calendar" class="w-4 h-4"></i>
                            </div> <input id="cs_date_exam" type="text" class="form-control pl-12 ">
                        </div>
                    </div>
                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Place of Exam/Conferment </label>
                        <input id="cs_place_exam" style="text-transform:uppercase"  type="text" name="cs_place_exam" class="form-control" placeholder="Place of Exam/Conferment" minlength="2" required autocomplete="off">
                    </div>
                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> License Number <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">(if Applicable)</span> </label>
                        <input id="cs_license_number" style="text-transform:uppercase"  type="text" name="cs_license_number" class="form-control" placeholder="Ex: License Number or N/A if not applicable" minlength="2" required autocomplete="off">
                    </div>
                    <div class="input-form col-span-12 lg:col-span-6">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Date of Validity <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">(if Applicable)</span> </label>

                        <input id="cs_date_validity" type="text" style="text-transform:uppercase"  name="cs_date_validity" class="form-control" placeholder="mm/dd/yyyy or N/A" minlength="2" required autocomplete="off">

                        {{-- <div class="relative w-auto mx-auto">
                            <div class="absolute rounded-l w-10 h-full flex items-center justify-center bg-slate-100 border text-slate-500 dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                                <i data-lucide="calendar" class="w-4 h-4"></i>
                            </div> <input id="cs_date_validity" type="text" class="form-control pl-12 ">
                        </div> --}}


                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btn_cancel_cs_eligibility" type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                <button id="btn_save_civil_service" type="submit" class="btn btn-primary w-20">Add</button>
                <button id="btn_update_cs" type="submit" class="btn btn-primary w-20 hidden">Update</button>
            </div>
        </div>
    </div>
</div>




<div id="delete_cs_eligibility_mdl" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">

                <input id="mdl_cs_input_id" class="hidden">

                <div class="p-5 text-center"> <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                    <div class="text-3xl mt-5">Are you sure?</div>
                    <div class="text-slate-500 mt-2">Do you really want to delete this data? <br>This process cannot be undone.</div>
                </div>
                <div class="px-5 pb-8 text-center">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                    <button id="btn_delete_my_cs_eligibility" type="button" class="btn btn-danger w-24">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
