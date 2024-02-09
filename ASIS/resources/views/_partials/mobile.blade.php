<!-- BEGIN: Mobile Menu -->
<div class="mobile-menu md:hidden">
    <div class="mobile-menu-bar">


        @if (system_settings())
            @php
                $system_title = system_settings()->where('key','agency_name')->first();
                $system_logo = system_settings()->where('key','agency_logo')->first();
            @endphp

            @if ($system_logo)

                <a href="" class="flex mr-auto">
                    <img alt="Agency Logo" class="w-6" src="{{ asset('uploads/settings/'.$system_logo->image.'') }}">
                </a>

            @else
                <a href="" class="flex mr-auto">
                    <img alt="Agency Logo" class="w-6" src="{{ asset('dist/images/logo.svg') }}">
                </a>
            @endif


        @else
            <a href="" class="flex mr-auto">
                <img alt="Agency Logo" class="w-6" src="{{ asset('dist/images/logo.svg') }}">
            </a>
        @endif


        <a href="javascript:;" class="mobile-menu-toggler"> <i data-lucide="bar-chart-2" class="w-8 h-8 text-white transform -rotate-90"></i> </a>
    </div>

    <div class="scrollable">
        <a href="javascript:;" class="mobile-menu-toggler"> <i data-lucide="x-circle" class="w-8 h-8 text-white transform -rotate-90"></i> </a>
        <ul class="scrollable__content py-2">

            <!-- BEGIN: STUDENTS SIDE BAR -->
            @if(Auth::check())
                @if(!Auth::user()->email_verified_at == '')

                    <!-- BEGIN:: DASHBOARD -->
                    <li>
                        <a href="/home" class="menu menu--{{ (request()->is('dashboard')) ? 'active' : '' }}">
                            <div class="menu__icon"> <i data-lucide="home"></i> </div>
                            <div class="menu__title"> Dashboard </div>
                        </a>
                    </li>
                    <!-- END:: DASHBOARD -->


                    <li class="menu__devider my-6"></li>

                    <!-- BEGIN:: MY GRADES -->
                    <li>
                        <a href="/my-portal" class="menu">
                            <div class="menu__icon"> <i data-lucide="bookmark"></i> </div>
                            <div class="menu__title"> My Grades</div>
                        </a>
                    </li>
                    <!-- END:: MY GRADES -->


                    <!-- BEGIN:: ENROLLMENT -->
                    <li>
                        <a href="/student-enroll" class="menu">
                            <div class="menu__icon"> <i data-lucide="bookmark"></i> </div>
                            <div class="menu__title"> Enrollment </div>
                        </a>
                    </li>
                    <!-- END:: ENROLLMENT -->


                    @if( auth()->user()->role === 'Admin')

                        <!-- BEGIN:: APPLICANT LIST -->
                        <li>
                            <a href="{{ route ('enrolledList')}}" class="menu">
                                <div class="menu__icon"> <i data-lucide="bookmark"></i> </div>
                                <div class="menu__title"> Applicant List </div>
                            </a>
                        </li>
                        <!-- END:: APPLICANT LIST -->


                        <!-- BEGIN:: STUDENTS (e-SMS) -->
                        <li>
                            <a href="{{ route ('student_list')}}" class="menu">
                                <div class="menu__icon"> <i data-lucide="bookmark"></i> </div>
                                <div class="menu__title"> Students (e-SMS) </div>
                            </a>
                        </li>
                        <!-- END:: STUDENTS (e-SMS) -->

                    @endif

                    <!-- BEGIN:: ONLINE REQUEST -->
                    <li>
                        <a href="javascript:;" class="menu menu--{{ (request()->is('application/*')) ? 'active' : '' }}">
                            <div class="menu__icon"> <i data-lucide="bookmark"></i> </div>
                            <div class="menu__title"> Online Request
                                <i data-lucide="chevron-down" class="menu__sub-icon transform rotate-180"></i>
                            </div>
                        </a>
                        <ul class="menu__{{ (request()->is('onlinerequest/dashboard/*')) ? 'sub-open' : '' }}">

                            <li>
                                <a href="{{ route('student_dashboard') }}" class="menu menu--{{ (request()->is('application/form')) ? 'active' : '' }}">
                                    <div class="menu__icon">  <i class="fa-solid fa-user-plus -mt-1"></i> </div>
                                    <div class="menu__title"> My Dashboard </div>
                                </a>
                            </li>

                            @if(Auth::user()->office)
                                <li>
                                    <a href="{{ route('dashboard') }}" class="menu menu--{{ (request()->is('onlinerequest/dashboard/dashboard')) ? 'active' : '' }}">
                                        <div class="menu__icon">  <i class="fa-solid fa-gauge-high"></i> </div>
                                        <div class="menu__title"> Dashboard </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('manage_or') }}" class="menu menu--{{ (request()->is('onlinerequest/dashboard/manage_or')) ? 'active' : '' }}">
                                        <div class="menu__icon">   <i class="fa-solid fa-gear"></i> </div>
                                        <div class="menu__title"> Manage OR </div>
                                    </a>
                                </li>

                            @elseif(Auth::user()->role == 'Admin')

                                <li>
                                    <a href="{{ route('dashboard') }}" class="menu menu--{{ (request()->is('onlinerequest/dashboard/dashboard')) ? 'active' : '' }}">
                                        <div class="menu__icon">   <i class="fa-solid fa-gauge-high"></i> </div>
                                        <div class="menu__title"> Dashboard </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('manage_or') }}" class="menu menu--{{ (request()->is('onlinerequest/dashboard/manage_or')) ? 'active' : '' }}">
                                        <div class="menu__icon">    <i class="fa-solid fa-gear"></i> </div>
                                        <div class="menu__title"> Manage OR </div>
                                    </a>
                                </li>

                            @endif
                        </ul>
                    </li>
                    <!-- END:: ONLINE REQUEST -->


                    <!-- BEGIN:: ELECTIONS -->
                    <li>
                        <a href="javascript:;" class="menu menu--{{ (request()->is('vote/*')) ? 'active' : '' }}">
                            <div class="menu__icon">
                                <i data-lucide="users"></i>
                            </div>
                            <div class="menu__title"> Elections
                                <i data-lucide="chevron-down" class="menu__sub-icon transform rotate-180"></i>
                            </div>
                        </a>
                        <ul class="menu__{{ (request()->is('vote/*')) ? 'sub-open' : '' }}">

                            @if(auth()->user()->role === 'Admin')
                                <li>
                                    <a href="{{ route('votingType') }}" class="menu menu--{{ (request()->is('vote/voting-type')) ? 'active' : '' }}">
                                        <div class="menu__icon">  <i class="fa-solid fa-user-plus -mt-1"></i> </div>
                                        <div class="menu__title"> Voting Type </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('votingPosition') }}" class="menu menu--{{ (request()->is('vote/voting-position')) ? 'active' : '' }}">
                                        <div class="menu__icon">  <i class="fa-solid fa-user-plus -mt-1"></i> </div>
                                        <div class="menu__title"> Voting Position </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('elect_parties_page') }}" class="menu menu--{{ (request()->is('vote/election-parties')) ? 'active' : '' }}">
                                        <div class="menu__icon">    <i class="fa-solid fa-user-plus -mt-1"></i> </div>
                                        <div class="menu__title"> Candidate Parties </div>
                                    </a>
                                </li>
                            @endif

                                <li>
                                    <a href="{{ route('elecApplication') }}" class="menu menu--{{ (request()->is('vote/election-application')) ? 'active' : '' }}">
                                        <div class="menu__icon">    <i class="fa-solid fa-user-plus -mt-1"></i> </div>
                                        <div class="menu__title"> Election Application </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('elecParticipants') }}" class="menu menu--{{ (request()->is('vote/election-participants')) ? 'active' : '' }}">
                                        <div class="menu__icon">    <i class="fas fa-vote-yea"></i> </div>
                                        <div class="menu__title"> Vote </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('result') }}" class="menu menu--{{ (request()->is('vote/election-result')) ? 'active' : '' }}">
                                        <div class="menu__icon">    <i class="fas fa-vote-yea"></i> </div>
                                        <div class="menu__title"> Result </div>
                                    </a>
                                </li>
                        </ul>
                    </li>
                    <!-- END:: ELECTIONS -->


                    <!-- BEGIN:: MY LEDGER -->
                    <li>
                        <a href="javascript:;" class="menu menu--{{ (request()->is('student_ledger/*')) ? 'active' : '' }}">
                            <div class="menu__icon">
                                <i data-lucide="bookmark"></i>
                            </div>
                            <div class="menu__title"> My Ledger
                                <i data-lucide="chevron-down" class="menu__sub-icon transform rotate-180"></i>
                            </div>
                        </a>
                        <ul class="menu__{{ (request()->is('student_ledger/*')) ? 'sub-open' : '' }}">

                            <li>
                                <a href="{{ route('my_ledger') }}" class="menu menu--{{ (request()->is('academic-records')) ? 'active' : '' }}">
                                    <div class="menu__icon">     <i class="fa-solid fa-book"></i> </div>
                                    <div class="menu__title"> Subsidiary Ledger </div>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <!-- END:: MY LEDGER -->


                    <!-- BEGIN:: ACADEMIC RECORDS -->
                    <li>
                        <a href="javascript:;" class="menu menu--{{ (request()->is('academic-records')) ? 'active' : '' }}">
                            <div class="menu__icon">
                                <i data-lucide="book"></i>
                            </div>
                            <div class="menu__title">  Academic Records
                                <i data-lucide="chevron-down" class="menu__sub-icon transform rotate-180"></i>
                            </div>
                        </a>
                        <ul class="menu__{{ (request()->is('academic-records')) ? 'sub-open' : '' }}">

                            <li>
                                <a href="{{ route('academic_transcript') }}" class="menu menu--{{ (request()->is('academic-records')) ? 'active' : '' }}">
                                    <div class="menu__icon">     <i data-lucide="book-open"></i> </div>
                                    <div class="menu__title"> Subsidiary Ledger </div>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <!-- END:: ACADEMIC RECORDS -->


                    <!-- BEGIN:: CURRICULUM -->
                    <li>
                        <a href="/curriculum" class="menu">
                            <div class="menu__icon"> <i data-lucide="bookmark"></i> </div>
                            <div class="menu__title"> Curriculum </div>
                        </a>
                    </li>
                    <!-- END:: CURRICULUM -->


                    <!-- BEGIN:: EVENTS -->
                    @if(Auth::user()->role === 'Admin')
                        <li>
                            <a href="javascript:;" class="menu menu--{{ (request()->is('event/*')) ? 'active' : '' }}">
                                <div class="menu__icon">
                                    <i data-lucide="bookmark"></i>
                                </div>
                                <div class="menu__title">  Events
                                    <i data-lucide="chevron-down" class="menu__sub-icon transform rotate-180"></i>
                                </div>
                            </a>
                            <ul class="menu__{{ (request()->is('event/*')) ? 'sub-open' : '' }}">

                                <li>
                                    <a href="{{ route('event_reminder') }}" class="menu menu--{{ (request()->is('event/reminder')) ? 'active' : '' }}">
                                        <div class="menu__icon">     <i class="fa-solid fa-bell"></i> </div>
                                        <div class="menu__title"> Reminder </div>
                                    </a>
                                </li>

                            </ul>
                        </li>
                    @endif
                    <!-- END:: EVENTS -->

                @endif
            @endif
            <!-- END: STUDENTS SIDE BAR -->

            <!-- BEGIN: PRE ENROLLEES SIDE BAR -->
            @if(auth()->guard('enrollees_guard')->check())
                @if(!auth()->guard('enrollees_guard')->user()->email_verified_at == '')

                    <!-- BEGIN:: PRE ENROLLEES DASHBOARD -->
                    <li>
                        <a href="{{ route('enrollees_home') }}" class="menu menu--{{ (request()->is('pre/enrollees/home')) ? 'active' : '' }}">
                            <div class="menu__icon"> <i data-lucide="home"></i> </div>
                            <div class="menu__title"> Dashboard </div>
                        </a>
                    </li>
                    <!-- END:: PRE ENROLLEES DASHBOARD -->


                    <!-- BEGIN:: PRE ENROLLEES DASHBOARD -->
                    <li>
                        <a href="javascript:;" class="menu menu--{{ (request()->is('enrollees/*')) ? 'active' : '' }}">
                            <div class="menu__icon">
                                <i data-lucide="settings"></i>
                            </div>
                            <div class="menu__title">  Schedule
                                <i data-lucide="chevron-down" class="menu__sub-icon transform rotate-180"></i>
                            </div>
                        </a>
                        <ul class="menu__{{ (request()->is('enrollees/*')) ? 'sub-open' : '' }}">

                            <li>
                                <a href="{{ route('enroll_schedule') }}" class="menu menu--{{ (request()->is('enrollees/schedule')) ? 'active' : '' }}">
                                    <div class="menu__icon">      <i data-lucide="calendar"></i> </div>
                                    <div class="menu__title"> My Schedule </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('myTransaction') }}" class="menu menu--{{ (request()->is('transaction/my/transaction')) ? 'active' : '' }}">
                                    <div class="menu__icon">      <i data-lucide="list"></i> </div>
                                    <div class="menu__title"> My Transactions </div>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <!-- END:: PRE ENROLLEES DASHBOARD -->

                @endif

            @endif
            <!-- END: PRE ENROLLEES SIDE BAR -->


            <!-- BEGIN: ADMIN SIDE BAR -->
            @if(auth()->guard('employee_guard')->check())


                    <!-- BEGIN:: PRE EMPLOYEE DASHBOARD -->
                    <li>
                        <a href="{{ route('enrollees_dashboard') }}" class="menu menu--{{ (request()->is('admin/dashboard')) ? 'active' : '' }}">
                            <div class="menu__icon"> <i data-lucide="home"></i> </div>
                            <div class="menu__title"> Dashboard </div>
                        </a>
                    </li>
                    <!-- END:: PRE EMPLOYEE DASHBOARD -->


                    <!-- BEGIN:: CLEARANCE -->
                    <li class="hidden">
                        <a href="javascript:;" class="menu menu--{{ (request()->is('student/clearance/*')) ? 'active' : '' }}">
                            <div class="menu__icon">
                                <i data-lucide="clipboard"></i>
                            </div>
                            <div class="menu__title">  Clearance
                                <i data-lucide="chevron-down" class="menu__sub-icon transform rotate-180"></i>
                            </div>
                        </a>
                        <ul class="menu__{{ (request()->is('student/clearance/*')) ? 'active' : '' }}">

                            <li>
                                <a href="{{ route('overview') }}" class="menu menu--{{ (request()->is('student/clearance/overview')) ? 'active' : '' }}">
                                    <div class="menu__icon">      <i data-lucide="star"></i> </div>
                                    <div class="menu__title"> Overview </div>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <!-- END:: CLEARANCE -->


                    <!-- BEGIN:: ACCOUNTS -->
                    <li>
                        <a href="javascript:;" class="menu menu--{{ (request()->is('ASIS/admin/*')) ? 'active' : '' }}">
                            <div class="menu__icon">
                                <i data-lucide="users"></i>
                            </div>
                            <div class="menu__title">  Accounts
                                <i data-lucide="chevron-down" class="menu__sub-icon transform rotate-180"></i>
                            </div>
                        </a>
                        <ul class="menu__{{ (request()->is('ASIS/admin/*')) ? 'sub-open' : '' }}">

                            @if(auth()->guard('employee_guard')->user()->role_name === 'Admin')
                                <li>
                                    <a href="{{ route('adminStudentsAccountManagement') }}" class="menu menu--{{ (request()->is('ASIS/admin/manage/students/accounts')) ? 'active' : '' }}">
                                        <div class="menu__icon">      <i data-lucide="user-check"></i> </div>
                                        <div class="menu__title"> Manage </div>
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </li>
                    <!-- END:: ACCOUNTS -->

                    <!-- BEGIN:: ENTRANCE EXAM -->
                    <li>
                        <a href="javascript:;" class="menu menu--{{ (request()->is('exam/*')) ? 'active' : '' }}">
                            <div class="menu__icon">
                                <i data-lucide="folder"></i>
                            </div>
                            <div class="menu__title">   Entrance Exam
                                <i data-lucide="chevron-down" class="menu__sub-icon transform rotate-180"></i>
                            </div>
                        </a>
                        <ul class="menu__{{ (request()->is('exam/*')) ? 'sub-open' : '' }}">

                            @if(auth()->guard('employee_guard')->user()->role_name === 'Admin')
                                <li>
                                    <a href="{{ route('entranceExamineesList') }}" class="menu menu--{{ (request()->is('exam/list')) ? 'active' : '' }}">
                                        <div class="menu__icon">      <i data-lucide="users"></i> </div>
                                        <div class="menu__title"> Examinees List </div>
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </li>
                    <!-- END:: ENTRANCE EXAM -->

                    <!-- BEGIN:: ADMIN SCHEDULE -->
                    <li>
                        <a href="javascript:;" class="menu menu--{{ (request()->is('enrollees/*')) ? 'active' : '' }}">
                            <div class="menu__icon">
                                <i data-lucide="settings"></i>
                            </div>
                            <div class="menu__title">  Schedule
                                <i data-lucide="chevron-down" class="menu__sub-icon transform rotate-180"></i>
                            </div>
                        </a>
                        <ul class="menu__{{ (request()->is('enrollees/*')) ? 'sub-open' : '' }}">

                            @if(auth()->guard('employee_guard')->user()->role_name === 'Admin')
                                <li>
                                    <a href="{{ route('enrollees_overview') }}" class="menu menu--{{ (request()->is('enrollees/schedule/overview')) ? 'active' : '' }}">
                                        <div class="menu__icon">      <i data-lucide="calendar"></i> </div>
                                        <div class="menu__title"> Overview </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('transactionList') }}" class="menu menu--{{ (request()->is('transaction/list')) ? 'active' : '' }}">
                                        <div class="menu__icon">      <i data-lucide="calendar"></i> </div>
                                        <div class="menu__title"> Transaction List </div>
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </li>
                    <!-- END:: ADMIN SCHEDULE -->


            @endif
            <!-- END: ADMIN SIDE BAR -->


        </ul>
    </div>
</div>
<!-- END: Mobile Menu -->
