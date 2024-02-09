<div class="top-bar">
    <!-- BEGIN: Breadcrumb -->
    <nav aria-label="breadcrumb" class="-intro-x mr-auto hidden sm:flex">
        <ol class="breadcrumb">

{{--            <li class="breadcrumb-item"><a href="../#">Application</a></li>--}}
{{--            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>--}}

            @yield('breadcrumb')

        </ol>
    </nav>
    <!-- END: Breadcrumb -->




    <!-- BEGIN: Search -->
    <div class="intro-x relative mr-3 sm:mr-6">

        @if(auth()->guard('employee_guard')->check())
            <div style="visibility: hidden" class="search hidden sm:block">
                <input type="text" class="search__input form-control border-transparent" placeholder="Search...">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="search" data-lucide="search" class="lucide lucide-search search__icon dark:text-slate-500"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </div>
        @endif

        <div id="append_global_notification">

        </div>
        {{-- <div id="adminNotification-with-avatar-content" class="toastify-content hidden flex">


        </div> --}}

        <!--BEGIN: Event Notif -->
        <div id="append_notif" class="append_notif">

        </div>
        <!--END: Event Notif -->

    </div>
    <!-- END: Search -->



    @if (Auth::check())
        <div class="intro-x dropdown mr-auto sm:mr-6">
            <div class="font-medium "><span class="text-secondary text-s"></span>
                <span class="text-primary">{{getUserLogin()}}</span>
                <span class="text-primary mr-2">
                    @if(getRole()!=='(Admin)')
                        {{getYearlevel()}}
                    @endif
                </span>
                <span class="text-secondary text-xs">{{getRole()}}</span> </div>
        </div>

    @else
        <div class="intro-x dropdown mr-auto sm:mr-6">
            <div class="font-medium "><span class="text-secondary text-s"></span>
                <span class="text-primary">{{getUserLogin()}}</span>
            </div>
        </div>
    @endif



   @if (Auth::check())

            <!-- BEGIN: Notifications -->
                <div id="__notification" class="intro-x dropdown mr-auto sm:mr-6 __notification">

                <div class="__notification_bell_div">
                    @if(chekNotif()->count() >= 1)
                        <div class="__notificationBell dropdown-toggle notification notification--bullet cursor-pointer" role="button" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-bell notification__icon text-primary"></i> </div>
                    @elseif(chekNotif()->count() == 0)
                        <div class="__notificationBell dropdown-toggle notification cursor-pointer" role="button" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-bell notification__icon dark:text-slate-500"></i> </div>
                    @endif
                </div>
                <div class="notification-content pt-2 dropdown-menu ">
                    <div class="notification-content__box dropdown-content overflow-y-auto h-half-screen">
                    <div class="grid grid-cols-2">

                        @if(chekNotif()->count() >= 1)
                            <div class="notification-content__title">Notifications</div>
{{--                            <a id="clear_all_notif" href="javascript:;" class="ml-auto text-sm text-slate-500 whitespace-nowrap">Clear all</a>--}}
                        @elseif(chekNotif()->count() == 0)
                            <div class="notification-content__title">No Notifications yet</div>
                        @endif
                    </div>


                    <!-- BEGIN: Document Notifications -->
                    <div class="load_document_notifications">
                    </div>

                    <!-- BEGIN: Applicants Notifications -->
                    <div class="load_panel_notif">
                    </div>

                    <!-- END:   Applicants Notifications -->
                    <!-- END:   Document Notifications -->
                    <div class="__notification_div">
                    </div>

                    <!-- BEGIN: AMANTE  NOTIFY APPLICANT Notifications -->
                    <div class="__hired_notif_div">

                    </div>

                    <div class="_seleted_notification">

                    </div>

                    </div>
                </div>

            </div>
            <!-- END: Notifications -->
    @endif



    <!-- BEGIN: Account Menu -->
    <div class="intro-x dropdown w-8 h-8">
        <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in" role="button" aria-expanded="false" data-tw-toggle="dropdown">
            {!!GLOBAL_GENERATE_TOPBAR()!!}
        </div>
        <div class="dropdown-menu w-56">
            <ul class="dropdown-content bg-primary text-white">

                @if (Auth::check())
                    @if(getLoggedStudent_Name())
                       <li class="p-2">
                            <div class="font-medium">{{ getLoggedStudent_Name() }}</div>
                            <div class="text-xs text-white/70 mt-0.5 dark:text-slate-500">{{ getLoggedStudent_ID()->studid }}</div>
                        </li>
                    @else
                        <li class="p-2">
                            <div class="font-medium">No Student Data</div>
                            <div class="text-xs text-white/70 mt-0.5 dark:text-slate-500">No Student Data</div>
                        </li>
                    @endif

                    @if(!Auth::user()->email_verified_at == '')
                        <hr class="dropdown-divider border-white/[0.08]">

                        <li>
                            <a href="{{ route('profile') }}" class="dropdown-item hover:bg-white/5"> <i data-lucide="user" class="w-4 h-4 mr-2"></i> My Profile </a>
                        </li>
                    @endif

                @elseif(auth()->guard('enrollees_guard')->check())

                    @if(getLoggedEnrollees())
                        <li class="p-2">
                            <div class="font-medium">{{ getLoggedEnrollees() }}</div>
                            <div class="text-xs text-white/70 mt-0.5 dark:text-slate-500">{{ getLoggedEnrollees_ID()->pre_enrollee_id }}</div>
                        </li>
                    @else
                        <li class="p-2">
                            <div class="font-medium">No Student Data</div>
                            <div class="text-xs text-white/70 mt-0.5 dark:text-slate-500">No Student Data</div>
                        </li>
                    @endif

                    @if(!auth()->guard('enrollees_guard')->user()->email_verified_at == '')

                        <hr class="dropdown-divider border-white/[0.08]">
                        <li>
                            <a href="{{ route('asis_profile') }}" class="dropdown-item hover:bg-white/5"> <i data-lucide="user" class="w-4 h-4 mr-2"></i> My Profile </a>
                        </li>

                    @endif
                @elseif(auth()->guard('employee_guard')->check())

                    @if(getLoggedEmployees())
                        <li class="p-2">
                            <div class="font-medium">{{ getLoggedEmployees() }}</div>
                            <div class="text-xs text-white/70 mt-0.5 dark:text-slate-500">{{ getLoggedEmployees_ID()->employee }}</div>
                        </li>
                    @else
                        <li class="p-2">
                            <div class="font-medium">No Student Data</div>
                            <div class="text-xs text-white/70 mt-0.5 dark:text-slate-500">No Student Data</div>
                        </li>
                    @endif

                    @if(!auth()->guard('employee_guard')->user()->email_verified_at == '')

                        <hr class="dropdown-divider border-white/[0.08]">
                        <li>
                            <a href="{{ route('asis_profile') }}" class="dropdown-item hover:bg-white/5"> <i data-lucide="user" class="w-4 h-4 mr-2"></i> My Profile </a>
                        </li>

                    @endif
                @else

                    <li>
                        <a href="/login" class="dropdown-item hover:bg-white/5"> <i data-lucide="toggle-left" class="w-4 h-4 mr-2"></i> Login </a>
                    </li>
               @endif

                @if (Auth::check() || auth()->guard('enrollees_guard')->check() || auth()->guard('employee_guard')->check())
                    <li>
                        <hr class="dropdown-divider border-white/[0.08]">
                    </li>
                    <li>
                        <a  href="{{ route('logout') }}" class="dropdown-item hover:bg-white/5"> <i data-lucide="toggle-right" class="w-4 h-4 mr-2"></i> Logout </a>
                    </li>
                @else

                @endif

            </ul>
        </div>
    </div>
    <!-- END: Account Menu -->

    <!--BEGIN: Event Notif -->
    <!--END: Event Notif -->

</div>

<!-- BEGIN: Applicants Notification Content -->
<div id="applicants_notification_mdl" data-tw-backdrop="static"  class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="intro-y col-span-12 md:col-span-6 lg:col-span-4">
                    <div class="box">
                        <div class="flex items-start px-5 pt-5">
                            <div class="w-full flex flex-col lg:flex-row items-center">
                                <div class="w-16 h-16 image-fit">
                                    <img id="mdl_notif_profile_pic" alt="Profile Picture" class="rounded-full" src="">
                                </div>
                                <div class="lg:ml-4 text-center lg:text-left mt-3 lg:mt-0">
                                    <div class="flex items-center justify-center lg:justify-start">                 <span class="font-medium" id="mdl_notif_full_name"></span> </div>
                                    <div class="flex items-center justify-center lg:justify-start">                 <span class="font-medium" id="mdl_notif_desig_pos"></span> </div>
                                    <div class="flex items-center justify-center lg:justify-start text-slate-500 "><span id="mdl_notif_email"></span> </div>
                                </div>
                            </div>
                            <div class="absolute right-0 top-0 mr-5 mt-3 dropdown">
                                <a class="w-5 h-5 block close_applicants_notif_mdl" href="javascript:;" data-tw-dismiss="modal"> <i data-lucide="x" class="w-5 h-5 text-slate-500"></i> </a>
                            </div>
                        </div>

                        <div class="text-center lg:text-left p-5 font-medium">
                            <div class="position_div">Position: <span class="ml-2" id="mdl_notif_position"></span> </div>
                        </div>

                        <div class="text-center text-justify p-5 border-t border-slate-200/60 dark:border-darkmode-400">
                            <div id="mdl_notif_content"></div>
                        </div>
                    </div>
                </div>
                <div class="p-5 text-center border-t border-slate-200/60 dark:border-darkmode-400">  </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Applicants Notification Content -->

<!-- BEGIN: Modal Content on the position hiring  -->
<div id="notif_click_info" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-body p-0">
                 <div class="text-center">
                    <div class="intro-y col-span-12 md:col-span-6 lg:col-span-4">
                            <div class="flex items-start px-5 pt-5">
                                <div class="w-full flex flex-col lg:flex-row items-center">
                                    <div  class="w-16 h-16 image-fit">
                                        <img  id="notif_image" alt="Midone - HTML Admin Template" class="rounded-full" src="">
                                    </div>
                                    <div class="lg:ml-4 text-center lg:text-left mt-3 lg:mt-0">
                                        <a id="notif_name_id" href="" class="font-medium"></a>
                                        <div class="text-slate-500 text-xs mt-0.5"><i class="fa fa-briefcase text-dark w-3 h-3"></i> <span id="position_notif" class="ml-1 font-medium "></span></div>
                                        <div class="text-slate-500 text-xs mt-0.5"><i class="fa fa-envelope text-dark w-3 h-3"></i><span id="email" class="ml-2 font-medium "></span></div>
                                    </div>
                                    <div id="notif_time" class="text-xs text-slate-400 ml-auto whitespace-nowrap"></div>
                                </div>
                            </div>
                            <div class="w-full border-t border-slate-200/60 dark:border-darkmode-400 mt-2"></div>
                            <div class="text-center lg:text-left p-5">
                                <div id="notif_info_content" class="ml-2 font-medium mt-1"></div>
                            </div>
                            <div class="text-center lg:text-right p-5">
                                <div class="absolute top-0 right-0"><button id="notif_cancel"><i class="fa fa-circle-xmark w-5 h-5 text-danger mr-2 mt-1"></i></button></div>
                            </div>
                    </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
<!-- END: Modal Content of the position hiring -->

<!-- KANG ROY NI-->
<!-- BEGIN:  Modal Content on the hired applicant  -->
<div id="notif_hired_Applicant" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="text-center">
                   <div class="intro-y col-span-12 md:col-span-6 lg:col-span-4">
                           <div class="flex items-start px-5 pt-5">
                               <div class="w-full flex flex-col lg:flex-row items-center">
                                   <div  class="w-16 h-16 image-fit">
                                       <img  id="sender_image" alt="Midone - HTML Admin Template" class="rounded-full" src="">
                                   </div>
                                   <div class="lg:ml-4 text-center lg:text-left mt-3 lg:mt-0">
                                       <a id="sender_name" href="" class="font-medium"></a>
                                       <div class="text-slate-500 text-xs mt-0.5"><i class="fa fa-briefcase text-dark w-3 h-3"></i> <span id="sender_position" class="ml-1 font-medium "></span></div>
                                       <div class="text-slate-500 text-xs mt-0.5"><i class="fa fa-envelope text-dark w-3 h-3"></i><span id="sender_email" class="ml-2 font-medium "></span></div>
                                   </div>
                                   <div id="time_sent" class="text-xs text-slate-400 ml-auto whitespace-nowrap"></div>
                               </div>
                           </div>
                           <div class="w-full border-t border-slate-200/60 dark:border-darkmode-400 mt-2"></div>
                           <div class="text-center lg:text-left p-5">
                               <div id="notif_content" class="ml-2 font-medium mt-1"></div>
                           </div>
                           <div class="text-center lg:text-right p-5">
                               <div class="absolute top-0 right-0 closeHired_modal"><a  href="javascript:;" data-tw-dismiss="modal"><i data-lucide="x" class="w-5 h-5 text-slate-500"></i></a></div>
                           </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Modal Content of the hired applicant -->
<!-- NUMANA KANG ROY NI-->

