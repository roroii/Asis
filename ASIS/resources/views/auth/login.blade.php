<!DOCTYPE html>

<html lang="en" class="light">
<!-- BEGIN: Head -->
<head>
    @include('_partials.head')
</head>

<body class="login">
    <div class="container sm:px-10">
        <div class="block xl:grid grid-cols-2 gap-4">
            <!-- BEGIN: Login Info -->
            <div class="hidden xl:flex flex-col min-h-screen">
                <a href="" class="-intro-x flex items-center">
                    <img alt="" height="200" width="200" src="{{ GLOBAL_LOGIN_LOGO() }}">
                    <span class="text-white text-lg ml-3"> </span>
                </a>
                <div style="margin-rigth: 30%" class="my-auto text-center">

                   <img style="margin-left: 15%" alt="Agency Logo" class="-intro-x w-1/2" src="{{ GLOBAL_LOGIN_LOGO_1() }}">

                   <div  class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                       {{-- <span width="50"  style="margin-right: 20%; white-space: pre-wrap;" >Republic of the Philippines</span> --}}
                       {{-- <br> --}}
                       <span width="50" style="margin-right: 20%; white-space: pre-wrap;"> <a href="{{ GLOBAL_AGENCY_WEBSITE() }}" target="_blank">{{ GLOBAL_AGENCY_NAME() }}</span></a>
                   </div>


               </div>
            </div>
            <!-- END: Login Info -->

            <!-- BEGIN: Image for Mobile -->
            <div class="sm:hidden w-full items-center">
                <img height="200" width="200" src="{{ GLOBAL_LOGIN_LOGO_1() }}" class="mx-auto" alt="Mobile Image">
                <div style="text-align: center" class="items-center text-white font-medium text-2xl w-full mx-auto">
                    <span style="white-space: pre-wrap;" class="w-full mx-auto" >{{ GLOBAL_AGENCY_NAME() }}</span>
                </div>
            </div>
            <!-- END: Image for Mobile -->

            <!-- BEGIN: Login Form -->
            <form class=" xl:h-auto flex py-5 xl:py-0" method="POST" action="{{ route('student_login') }}" id="logForm">

                @csrf
                <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                    <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                        Sign In
                    </h2>




                    @if(Session::has('message'))
                    <div class="alert alert-outline-danger alert-dismissible show flex items-center bg-danger/20 dark:bg-darkmode-400 dark:border-darkmode-400 mt-5" role="alert">
                        <span><i data-lucide="alert-triangle" class="w-6 h-6 mr-3"></i></span>
                        <span class="text-slate-800 dark:text-slate-500">{{ Session::get('message') }}<a class="text-primary font-medium"></a></span>
                        <button type="button" class="btn-close dark:text-white" data-tw-dismiss="alert" aria-label="Close"> <i data-lucide="x" class="w-4 h-4"></i> </button>
                    </div>
                    {{ Session::forget('message') }}
                    @endif

                    {{-- {{ dd( Session::get('message')) }} --}}
                    <div class="intro-x mt-8">

                        <input type="hidden" id="loginTypeInput" value="{{ old('login_type') }}">

                        <select name="login_type" class="intro-x login__input form-control py-3 px-4 block login_type" aria-label=".form-select-lg example">
                            <option value="STUDENT" >Student</option>
                            <option value="GUEST"   >Incoming Student</option>
                            <option value="EMPLOYEE">Employee</option>
                        </select>

                        <input id="email" type="text" class="intro-x login__input form-control mt-6 py-3 px-4 block @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="username" autofocus placeholder="firstname.lastname@dssc.edu.ph">

                        @error('email')
                        <span class="invalid-feedback mt-5" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

{{--                        <input id="password" type="password" class="intro-x login__input form-control py-3 px-4 block mt-4 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">--}}

                        <div class="login__input relative mt-6 form-control cursor-pointer">
                            <input id="password" type="password" class="login__input form-control py-3 px-4 block @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                            <i style="right: 15px" class="hidden fa-regular fa-eye absolute top-0 bottom-0 my-auto w-4 h-4 see_password"></i>
                            <i style="right: 15px" class="fa-regular fa-eye-slash absolute top-0 bottom-0 my-auto w-4 h-4 un_see_password"></i>
                        </div>


                        @error('password')
                        <span class="invalid-feedback mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror


                    </div>

                    <div class="intro-x flex text-slate-600 dark:text-slate-500 text-xs sm:text-sm mt-4">
                        <div class="flex items-center mr-auto">
                            <input class="form-check-input border mr-2" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            {{ __('Remember Me') }}
                        </div>
                        <a class="forgot_password" href="{{ route('password.request') }}">Forgot Password?</a>
                    </div>


                    <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                        <button id="btn_login_onclick_check" class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">
                            Login
                        </button>

                        <a href="{{ route('register') }}" style="visibility: hidden" class="btn btn-outline-secondary py-3 px-4 w-full xl:w-32 mt-3 xl:mt-0 align-top btn_signup">Sign Up</a>

                    </div>


                    <div id="h_b_l_fp" class="" align="center">

                    </div>
                    <div class="intro-x mt-10 text-slate-600 dark:text-slate-500 text-center xl:text-left find_my_account_div"> Find my account, <a class="text-primary dark:text-slate-200 ml-1" href="{{ route('find_account') }}">Click here</a> </div>
                        <div class="mt-8 text-center"> <em class="mt-1 text-primary block font-normal">Powered by DSSC: ICTC Team</em></div>
                </div>
            </form>
        </div>



        <!-- BEGIN: Modal Content -->
        <div id="mdl__fp_verify" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <!-- BEGIN: Modal Header -->
                    <div class="modal-header">
                        <h2 id="ttl-verify" class="font-bold text-base mr-auto capitalize"></h2>

                    </div> <!-- END: Modal Header -->
                    <!-- BEGIN: Modal Body -->

                    <div class="modal-body px-5 py-10">
                        <div>

                            <div id="fp-verify-features-ui" class="mb-5" align="center">

                            </div>

                            <div id="fp-verify-msg" class="" style="min-width: 20px;" align="center">
                                Put your finger on the fingerprint device.
                            </div>

                        </div>
                    </div>
                        <!-- END: Modal Body -->

                    <!-- BEGIN: Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" href="javascript:;" class="btn btn-outline-secondary w-20 mr-1 b_action" data-type="action" data-target="fp-verify-cancel">Close</button>
                    </div>
                    <!-- END: Modal Footer -->

                </div>
            </div>
        </div>  <!-- END: Modal Content -->

        <!-- BEGIN: Modal Content -->
        <div id="mdl__fp_verify_success" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-body p-0">

                        <div class="p-5 text-center"> <i class="fas fa-check-double w-16 h-16 text-success mx-auto mt-3"></i>
                            <div id="ttl-verify-success" class="text-3xl mt-5 capitalize">Juan Dela Cruz</div>
                            <div id="lbl-verify-success-details" class="text-slate-500 mt-2 capitalize">Time-In</div>
                        </div>
                        <div class="px-5 pb-8 text-center"> <button type="button" href="javascript:;" class="btn btn-outline-secondary w-24 mr-1 b_action" data-type="action" data-target="fp-verify-success-cancel">Close</button> </div>
                    </div>

                </div>
            </div>
        </div>  <!-- END: Modal Content -->

        <!-- BEGIN: Modal Content -->
        <div id="mdl__fp_verify_error" class="modal" tabindex="-1" aria-hidden="true" data-tw-backdrop="static">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-body p-0">

                        <div class="p-5 text-center"> <i class="far fa-times-circle w-16 h-16 text-danger mx-auto mt-3"></i>
                            <div id="ttl-verify-error" class="text-3xl mt-5 capitalize"></div>
                            <div id="lbl-verify-error-details" class="text-slate-500 mt-2 ">Unable to recognize the fingerprint.</div>
                        </div>
                        <div class="px-5 pb-8 text-center"> <button type="button" href="javascript:;" class="btn btn-outline-secondary w-24 mr-1 b_action" data-type="action" data-target="fp-verify-error-cancel">Close</button> </div>
                    </div>

                </div>
            </div>
        </div>  <!-- END: Modal Content -->

    </div>
    @include('_partials.scripts')
    <script>
        var __basepath = "{{url('')}}";
    </script>

<script src="../js/account_mngmnt/login.js"></script>

    <script src="{{BASEPATH()}}/js/bioengine/bioengine.js{{GET_RES_TIMESTAMP()}}"></script>
    <script src="{{BASEPATH()}}/js/onelogin.js{{GET_RES_TIMESTAMP(0)}}"></script>
    <script src="{{BASEPATH()}}/js/login.js{{GET_RES_TIMESTAMP(0)}}"></script>


</body>
</html>


