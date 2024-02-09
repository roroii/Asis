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
        <!-- BEGIN: Login Form -->
        <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
            <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-darkmode-600 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                        Sign Up
                    </h2>
                    <div class="intro-x mt-8">

                        @if(Session::has('message'))
                            <div class="alert alert-outline-warning alert-dismissible show flex items-center bg-warning/20 dark:bg-darkmode-400 dark:border-darkmode-400 mt-5" role="alert">
                                <span><i data-lucide="alert-triangle" class="w-6 h-6 mr-3"></i></span>
                                <span class="text-slate-800 dark:text-slate-500">{{ Session::get('message') }}<a class="text-primary font-medium"></a></span>
                                <button type="button" class="btn-close dark:text-white" data-tw-dismiss="alert" aria-label="Close"> <i data-lucide="x" class="w-4 h-4"></i> </button>
                            </div>
                        @endif

                        <input id="firstname" name="firstname" value="{{ old('firstname') }}" required autocomplete="first_name" type="text" class="intro-x login__input form-control py-3 px-4 block mt-4" placeholder="First Name">

                        @error('firstname')
                        <div class="alert alert-outline-warning alert-dismissible show flex items-center bg-warning/20 dark:bg-darkmode-400 dark:border-darkmode-400 mt-5" role="alert">
                            <span><i data-lucide="alert-triangle" class="w-6 h-6 mr-3"></i></span>
                            <span class="text-slate-800 dark:text-slate-500">{{ $message }}<a class="text-primary font-medium"></a></span>
                            <button type="button" class="btn-close dark:text-white" data-tw-dismiss="alert" aria-label="Close"> <i data-lucide="x" class="w-4 h-4"></i> </button>
                        </div>
                        @enderror

                        <input id="middlename" name="middlename" value="{{ old('middlename') }}" required autocomplete="mid_name" type="text" class="intro-x login__input form-control py-3 px-4 block mt-4" placeholder="Middle Name">

                        @error('middlename')
                        <div class="alert alert-outline-warning alert-dismissible show flex items-center bg-warning/20 dark:bg-darkmode-400 dark:border-darkmode-400 mt-5" role="alert">
                            <span><i data-lucide="alert-triangle" class="w-6 h-6 mr-3"></i></span>
                            <span class="text-slate-800 dark:text-slate-500">{{ $message }}<a class="text-primary font-medium"></a></span>
                            <button type="button" class="btn-close dark:text-white" data-tw-dismiss="alert" aria-label="Close"> <i data-lucide="x" class="w-4 h-4"></i> </button>
                        </div>
                        @enderror

                        <input id="lastname" name="lastname" value="{{ old('lastname') }}" required autocomplete="last_name" type="text" class="intro-x login__input form-control py-3 px-4 block mt-4" placeholder="Last Name">

                        @error('lastname')
                        <div class="alert alert-outline-warning alert-dismissible show flex items-center bg-warning/20 dark:bg-darkmode-400 dark:border-darkmode-400 mt-5" role="alert">
                            <span><i data-lucide="alert-triangle" class="w-6 h-6 mr-3"></i></span>
                            <span class="text-slate-800 dark:text-slate-500">{{ $message }}<a class="text-primary font-medium"></a></span>
                            <button type="button" class="btn-close dark:text-white" data-tw-dismiss="alert" aria-label="Close"> <i data-lucide="x" class="w-4 h-4"></i> </button>
                        </div>
                        @enderror


                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" class="intro-x login__input form-control py-3 px-4 block mt-4" placeholder="Email">

                        @error('email')
                        <div class="alert alert-outline-warning alert-dismissible show flex items-center bg-warning/20 dark:bg-darkmode-400 dark:border-darkmode-400 mt-5" role="alert">
                            <span><i data-lucide="alert-triangle" class="w-6 h-6 mr-3"></i></span>
                            <span class="text-slate-800 dark:text-slate-500">{{ $message }}<a class="text-primary font-medium"></a></span>
                            <button type="button" class="btn-close dark:text-white" data-tw-dismiss="alert" aria-label="Close"> <i data-lucide="x" class="w-4 h-4"></i> </button>
                        </div>
                        @enderror


                        <div class="login__input relative mt-6 form-control cursor-pointer">
                            <input id="password" type="password" class="login__input form-control py-3 px-4 block @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                            <i style="right: 15px" class="hidden fa-regular fa-eye absolute top-0 bottom-0 my-auto w-4 h-4 see_password"></i>
                            <i style="right: 15px" class="fa-regular fa-eye-slash absolute top-0 bottom-0 my-auto w-4 h-4 un_see_password"></i>
                        </div>


                        <div class="login__input relative mt-6 form-control cursor-pointer">
                            <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password" class="login__input form-control py-3 px-4 block @error('password') is-invalid @enderror" placeholder="Password Confirmation">
                            <i style="right: 15px" class="hidden fa-regular fa-eye absolute top-0 bottom-0 my-auto w-4 h-4 confirm_see_password"></i>
                            <i style="right: 15px" class="fa-regular fa-eye-slash absolute top-0 bottom-0 my-auto w-4 h-4 confirm_un_see_password"></i>
                        </div>

                        @error('password')
                        <div class="alert alert-outline-warning alert-dismissible show flex items-center bg-warning/20 dark:bg-darkmode-400 dark:border-darkmode-400 mt-5" role="alert">
                            <span><i data-lucide="alert-triangle" class="w-6 h-6 mr-3"></i></span>
                            <span class="text-slate-800 dark:text-slate-500">{{ $message }}<a class="text-primary font-medium"></a></span>
                            <button type="button" class="btn-close dark:text-white" data-tw-dismiss="alert" aria-label="Close"> <i data-lucide="x" class="w-4 h-4"></i> </button>
                        </div>
                        @enderror
                    </div>
                    <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                        <button type="submit" class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Register</button>
                    </div>


                </form>
                <div class="intro-x mt-10 xl:mt-24 text-slate-600 dark:text-slate-500 text-center xl:text-left">Already have an account? <a class="text-primary dark:text-slate-200" href="/login">Login Here</a> </div>
            </div>
        </div>
    </div>
</div>
@include('_partials.scripts')

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="{{BASEPATH()}}/js/auth/register.js{{GET_RES_TIMESTAMP()}}"></script>

</body>
</html>


