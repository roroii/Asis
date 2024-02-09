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
                <form method="POST" action="{{ route('find_account') }}">
                    @csrf
                    <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                        Find My Account
                    </h2>
                    <div class="intro-x mt-8">

                        @if(Session::has('success'))
                            <div class="alert alert-outline-success alert-dismissible show flex items-center bg-success/20 dark:bg-darkmode-400 dark:border-darkmode-400 mt-5" role="alert">
                                <span><i data-lucide="check-square" class="w-6 h-6 mr-3"></i></span>
                                <span class="text-slate-800 dark:text-slate-500">{{ Session::get('success') }}<a class="text-primary font-medium"></a></span>
                                <button type="button" class="btn-close dark:text-white" data-tw-dismiss="alert" aria-label="Close"> <i data-lucide="x" class="w-4 h-4"></i> </button>
                            </div>
                        @endif

                        @if(Session::has('error'))
                                <div class="alert alert-outline-warning alert-dismissible show flex items-center bg-warning/20 dark:bg-darkmode-400 dark:border-darkmode-400 mt-5" role="alert">
                                    <span><i data-lucide="alert-triangle" class="w-6 h-6 mr-3"></i></span>
                                    <span class="text-slate-800 dark:text-slate-500">{{ Session::get('error') }}<a class="text-primary font-medium"></a></span>
                                    <button type="button" class="btn-close dark:text-white" data-tw-dismiss="alert" aria-label="Close"> <i data-lucide="x" class="w-4 h-4"></i> </button>
                                </div>
                        @endif

                        @if(Session::has('has_email'))
                                @if(Session::get('has_email') == false)
                                <div class="alert alert-outline-warning alert-dismissible show flex items-center bg-warning/20 dark:bg-darkmode-400 dark:border-darkmode-400 mt-5" role="alert">
                                    <span><i data-lucide="alert-triangle" class="w-6 h-6 mr-3"></i></span>
                                    <span class="text-slate-800 dark:text-slate-500">But Email not found! <a class="text-primary font-medium"></a></span>
                                    <button type="button" class="btn-close dark:text-white fa-beat btn_add_email" data-student-id="{{ Session::get('student_id') }}"> <div class="py-1 px-2 rounded-full text-xs bg-primary text-white cursor-pointer font-medium">  Add Email </div> </button>
                                </div>
                                @endif
                        @endif


                        @if(Session::get('has_email') == true)
                            <div class="intro-y col-span-12 md:col-span-6 mt-5">
                                <div class="box">
                                    <div class="flex flex-col lg:flex-row items-center p-5">

                                        <div class="lg:ml-2 text-center lg:text-left mt-3 mr-5 lg:mt-0">
                                            <a href="" class="font-medium">{{ Session::get('full_name') }}</a>
                                            <div class="mt-0.5">
                                                <a href="/find/my/account" class="text-primary dark:text-slate-200">Not you?</a>
                                            </div>
                                        </div>
                                        <div class="flex mt-4 lg:mt-0">
                                            <a href="{{ route('password.request') }}" class="btn btn-primary py-1 px-2 mr-2">Forgot password</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else

                                <input name="student_id_email" value="{{ old('student_id_email') }}" required autocomplete="student_id_email" type="text" class="intro-x login__input form-control py-3 px-4 block mt-4 student_id_email" placeholder="Student ID/Email">

                        @endif

                    </div>

                    <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">

                        @if(Session::get('has_email') == null)
                            <button type="submit" class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">Find Now</button>
                        @else

                        @endif
                    </div>
                </form>
                <div class="intro-x mt-10 xl:mt-24 text-slate-600 dark:text-slate-500 text-center xl:text-left">Already have an account? <a class="text-primary dark:text-slate-200" href="/login">Login Here</a> </div>
            </div>
        </div>
        @include('auth.modal')
    </div>
</div>
@include('_partials.scripts')

{{--<script src="{{BASEPATH()}}/js/onelogin.js{{GET_RES_TIMESTAMP(0)}}"></script>--}}
{{--<script src="{{BASEPATH()}}/js/login.js{{GET_RES_TIMESTAMP(0)}}"></script>--}}

<script src="{{BASEPATH()}}/js/auth/find_account.js{{GET_RES_TIMESTAMP()}}"></script>

</body>
</html>


