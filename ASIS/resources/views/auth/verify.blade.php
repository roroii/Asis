@extends('layouts.app')

@section('content')

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 2xl:col-span-9">

            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: Notification -->
                <div class="col-span-12 mt-6 intro-y">

                    @if (session('resent'))

                        <div class="alert alert-outline-success alert-dismissible show flex items-center bg-success/20 dark:bg-darkmode-400 dark:border-darkmode-400 mt-5" role="alert">
                            <span class="text-slate-800 dark:text-slate-500">{{ __('A fresh verification link has been sent to your email address.') }}<a class="text-primary font-medium"></a></span>
                            <button type="button" class="btn-close text-dark " data-tw-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="x" data-lucide="x" class="lucide lucide-x w-4 h-4"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg> </button>
                        </div>

                    @else

                        <div class="alert alert-outline-primary alert-dismissible show flex items-center bg-primary/20 dark:bg-darkmode-400 dark:border-darkmode-400 mt-5" role="alert">
                            <span class="text-slate-800 dark:text-slate-500">{{ __('Verify Your Email Address') }}<a class="text-primary font-medium"></a></span>
                            <button type="button" class="btn-close text-dark " data-tw-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="x" data-lucide="x" class="lucide lucide-x w-4 h-4"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg> </button>
                        </div>
                    @endif
                </div>


                <!-- BEGIN: Ads 2 -->
                <div class="col-span-12 mt-2 intro-y">

                    <div class="box p-8 relative overflow-hidden intro-y">

                        <div class="leading-[2.15rem] w-full text-primary dark:text-white text-xl -mt-3">Email Verification!</div>
                        <div class="leading-[2.15rem] w-full text-primary dark:text-white text-xl mt-2"><span class="font-medium">Hello! </span> <span class="font-medium">{{ Session::get('students_full_name') }}</span> </div>
                        <div class="w-full leading-relaxed text-slate-500 mt-2" style="width: 35rem">You registered an account on <span class="font-medium">{{ $agency_name->value }}</span>, before being able to use your account you need to verify that this is your email address please check your email for a verification link.</div>

                        <div class="w-full leading-relaxed text-slate-500 mt-2" style="width: 35rem"> If you have not received the email, kindly click the button below to request another one.</div>


                        <form class="relative mt-4 cursor-pointer" method="POST" action="{{ route('verification.resend') }}">
                            @csrf

                            <div class="relative mt-6 cursor-pointer tooltip" title="Personal Email or Institutional Email" style="width: 20rem">
                                <input disabled type="text" class="form-control" name="email" value="{{ Session::get('students_email') }}" placeholder="firstname.lastname@gmail.com">
                                <i data-lucide="mail" class="absolute right-0 top-0 bottom-0 my-auto mr-4 w-4 h-4" ></i>
                            </div>

                            <button type="submit" class="btn btn-outline-primary mt-4">  <i data-lucide="send" class="w-4 h-4 block mr-2"></i>  click here to request another</button>
                        </form>

                        <img class="hidden sm:block absolute top-0 right-0 w-1/2" style="margin-right: -5.7rem; margin-top: -5rem" alt="Phone Illustration Email" src="{{ asset('dist/images/phone-illustration-email.png') }}">
                    </div>
                </div>
                <!-- END: Ads 2 -->

            </div>
        </div>


        <!-- BEGIN: RIGHT SIDE PANE ADDITIONAL INFORMATION -->
        <div class="intro-y col-span-3 hidden 2xl:block">
            <div class="pt-10 sticky top-0">
                <div class="mt-4 bg-warning/20 dark:bg-darkmode-600 border border-warning dark:border-0 rounded-md relative p-5">
                    <i data-lucide="lightbulb" class="w-12 h-12 text-warning/80 absolute top-0 right-0 mt-5 mr-3"></i>
                    <h2 class="text-lg font-medium">
                        Additional Information
                    </h2>
                    <div class="mt-5 font-medium">Email Verification,</div>
                    <div class="leading-relaxed text-xs mt-2 text-slate-600 dark:text-slate-500">
                        <div>Requiring users to go through account confirmation helps reduce the number of unverified spam accounts.</div>
                        <div class="mt-2">Furthermore, verification is helpful for users themselves because it reduces the risk of them creating an account using an incorrect or old email address they no longer have access.</div>
                    </div>
                </div>

            </div>
        </div>
        <!-- END: RIGHT SIDE PANE ADDITIONAL INFORMATION -->

    </div>
@endsection

@section('scripts')

    <script src="{{BASEPATH()}}/js/auth/auth_js.js{{GET_RES_TIMESTAMP()}}"></script>

@endsection
