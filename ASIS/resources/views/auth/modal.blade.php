<!--  BEGIN:: FIND ACCOUNT MODAL  -->
<div id="find_my_account_mdl" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto modal_title">Add Active Email</h2>
            </div>

            <div class="modal-body p-0">

                <input id="input_students_id" class="hidden">

                <div class="p-5">
                    <div class="bg-warning/20 dark:bg-darkmode-600 border border-warning dark:border-0 rounded-md relative p-5">
                        <i data-lucide="lightbulb" class="w-12 h-12 text-warning/80 absolute top-0 right-0 mt-5 mr-3"></i>
                        <h2 class="text-lg font-medium">
                            Additional Information!
                        </h2>

                        @if(GLOBAL_STUDENTS_ACCOUNT_ATTEMPT_VERIFIER() === '1')
                            <div class="mt-5 font-medium">NOTE!</div>
                            <div class="leading-relaxed text-xs mt-1 text-slate-600 dark:text-slate-500">
                                <div>You are obliged to input your Birthdate <span class="font-medium">{{ GLOBAL_STUDENTS_ATTEMPT_ACCOUNT() }} times </span> only, for security purposes!</div>
                            </div>
                        @endif

                        <div class="mt-5 font-medium">First</div>
                        <div class="leading-relaxed text-xs mt-1 text-slate-600 dark:text-slate-500">
                            <div>Provide your Birthdate, to proceed for the second step!</div>
                        </div>
                        <div class="mt-5 font-medium">Second</div>
                        <div class="leading-relaxed text-xs mt-1 text-slate-600 dark:text-slate-500">
                            <div>Provide your <span class="font-medium">ACTIVE Email</span>, so that we can send you a verification link!</div>
                        </div>
                    </div>
                </div>

<!--                <div class="px-5 mb-5 grid grid-cols-12 gap-6">

                    <div class="input-form col-span-12 lg:col-span-12 input_group_bdate">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Your Birthdate @if(GLOBAL_STUDENTS_ACCOUNT_ATTEMPT_VERIFIER() === '1') <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Attempts (<span class="label_attempts"></span>/{{ GLOBAL_STUDENTS_ATTEMPT_ACCOUNT() }})</span> @endif  </label>

                        <input id="input_attempt_count" class="hidden">

                        <div class="input-group mt-2">
                            <div class="input-group-text"><i data-lucide="calendar" class="w-4 h-4"></i></div>
                            <input type="text" id="auth_bday" class="form-control pl-12 auth_bday" data-single-mode="true">
                            <a href="javascript:;" class="input-group-text btn_search_my_bdate">
                                <i data-lucide="search" class="w-4 h-4 fa-beat"></i>
                            </a>
                        </div>

                    </div>

                    <div id="email_div"  class="input-form col-span-12 lg:col-span-12">

                    </div>

                </div>-->

                <div class="intro-y py-2">
                    <div class="flex justify-center">
                        <button class="btn_selected_div intro-y w-10 h-10 rounded-full btn btn-primary mx-2 ">1</button>
                        <button class="btn_selected_div intro-y w-10 h-10 rounded-full btn bg-slate-100 dark:bg-darkmode-400 dark:border-darkmode-400 text-slate-500 mx-2">2</button>
                    </div>
                    <div class="mt-5">
                        <div class="font-medium text-center text-lg">Setup Your Account</div>
                        <div class="text-slate-500 text-center mt-2 label_instructions"></div>
                    </div>

                    <div class="p-5 b_date_alert_div hidden">
                        <div class="alert alert-outline-pending alert-dismissible show flex items-center mb-2" role="alert"> <i data-lucide="alert-circle" class="w-8 h-8 mr-2"></i> If your Birthdate didn't match, Please proceed to Admission or ICTC Office!  <button type="button" class="btn-close" data-tw-dismiss="alert" aria-label="Close"> <i data-lucide="x" class="w-4 h-4"></i> </button> </div>
                    </div>

                    <div class="sm:px-1 pt-5 pb-5 border-t border-slate-200/60 dark:border-darkmode-400">

                        <div class="input-form col-span-12 lg:col-span-12 input_group_bdate">
                            <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row"> Your Birthdate @if(GLOBAL_STUDENTS_ACCOUNT_ATTEMPT_VERIFIER() === '1') <span class="sm:ml-auto mt-1 sm:mt-0 text-xs text-slate-500">Attempts (<span class="label_attempts"></span>/{{ GLOBAL_STUDENTS_ATTEMPT_ACCOUNT() }})</span> @endif  </label>

                            <input id="input_attempt_count" class="hidden">

                            <div class="input-group mt-2">
                                <div class="input-group-text"><i data-lucide="calendar" class="w-4 h-4"></i></div>
                                <input type="text" id="auth_bday" class="form-control pl-12 auth_bday" data-single-mode="true">
                                <a href="javascript:;" class="input-group-text btn_search_my_bdate">
                                    <i data-lucide="search" class="w-4 h-4 fa-beat"></i>
                                </a>
                            </div>

                        </div>

                        <div id="email_div"  class="input-form col-span-12 lg:col-span-12">

                        </div>
                    </div>
                </div>

            </div>


            <div class="modal-footer modal_footer_div">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Close</button>
            </div>
        </div>
    </div>
</div>
<!--  END:: FIND ACCOUNT MODAL  -->
