<!DOCTYPE html>

<html lang="en" class="light">
<!-- BEGIN: Head -->
<head>
    @include('_partials.head')
</head>

<body class="login">
<div class="container sm:px-10">
    <div class="block xl:grid grid-cols-2 gap-4">

        <!-- BEGIN: RIGHT SIDE IMAGE -->
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
        <!-- END: RIGHT SIDE IMAGE -->


        <!-- BEGIN: RESET PASSWORD Form -->
        <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0" >
            <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">

                <form method="POST" action="{{ route('password.email') }}" id="passwordResetForm">
                    @csrf
                    <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                        Reset Password
                    </h2>

                    <div class="intro-x mt-5">

                        @if (session('status'))

                            <div class="alert alert-outline-warning alert-dismissible show flex items-center bg-warning/20 dark:bg-darkmode-400 dark:border-darkmode-400 mt-5" role="alert">
                                <span><i data-lucide="alert-triangle" class="w-6 h-6 mr-3"></i></span>
                                <span class="text-slate-800 dark:text-slate-500">{{ session('status') }}<a class="text-primary font-medium"></a></span>
                                <button type="button" class="btn-close dark:text-white" data-tw-dismiss="alert" aria-label="Close"> <i data-lucide="x" class="w-4 h-4"></i> </button>
                            </div>
                        @endif

                        <div class="col-span-12 mt-4 intro-y">
                            @if(Session::has('students'))
                                <input id="email" type="email" class="intro-x login__input form-control py-3 px-4 block mt-4 @error('email') is-invalid @enderror" name="email" value="{{ $readableString_email ?? old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                            @elseif(session('status'))
                                <input id="email" type="email" class="intro-x login__input form-control py-3 px-4 block mt-4 @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                            @else
                                <input id="email" type="email" class="intro-x login__input form-control py-3 px-4 block mt-4 @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                            @endif
                        </div>

                        @error('email')
                        <div class="alert alert-outline-warning alert-dismissible show flex items-center bg-warning/20 dark:bg-darkmode-400 dark:border-darkmode-400 mt-5" role="alert">
                            <span><i data-lucide="alert-triangle" class="w-6 h-6 mr-3"></i></span>
                            <span class="text-slate-800 dark:text-slate-500">{{ $message }}<a class="text-primary font-medium"></a></span>
                            <button type="button" class="btn-close dark:text-white" data-tw-dismiss="alert" aria-label="Close"> <i data-lucide="x" class="w-4 h-4"></i> </button>
                        </div>
                        @enderror

                    </div>

                    <div class="intro-x mt-8 xl:mt-8 text-center xl:text-left">
                        <button type="submit" class="btn btn-primary py-3 px-4 w-full xl:mr-3 align-top btn_send_reset_link">Send Password Reset Link</button>
                        <a href="/" class="btn btn-outline-secondary py-3 px-4 w-full  mt-3  align-top">Sign In</a>
                    </div>

                </form>
            </div>
        </div>
        <!-- END: RESET PASSWORD Form -->
    </div>

</div>

<!--<script src="{{BASEPATH()}}/assets/jquery/jquery-3.6.1.min.js{{GET_RES_TIMESTAMP()}}"></script>
<script src="{{BASEPATH()}}/js/auth/reset_password.js{{GET_RES_TIMESTAMP()}}"></script>-->

</body>
</html>



