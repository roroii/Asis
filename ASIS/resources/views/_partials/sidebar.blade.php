<nav class="side-nav">
    <a href="javascript:;" class="intro-x flex items-center  py-4">
        {{--        <img alt="logo" class="w-10" src="{{ asset('dist/images/logo.png') }}">--}}
        {{--        <img alt="logo" class="w-10" src="{{ asset('dist/images/qrdts_logo_1.png') }}">--}}

            @if (system_settings())
            @php
                $system_title = system_settings()->where('key','system_title')->first();
                $system_logo = system_settings()->where('key','agency_logo')->first();
            @endphp

            @if ($system_logo)
            <div class="w-12 h-12 rounded-full overflow-hidden shadow-lg image-fit zoom-in ml-5"><img data-action="zoom" alt="logo" src=" {{ asset('uploads/settings/'.$system_logo->image.'') }}"></div>

            @else
            <img alt="logo" class="w-10" src="">
            @endif

            @if ($system_title)
                <span class="text-white new-text-lg ml-3"> {{ $system_title->value }}</span>
            @else
                <span class="text-white text-lg ml-3"> N/A </span>
            @endif

            @else
            <img alt="logo" class="w-10" src="">
            <span class="text-white text-lg ml-3"> N/A </span>
            @endif


    </a>
    <div class="side-nav__devider my-6"></div>
<ul>

    <!-- BEGIN: STUDENTS SIDE BAR -->
    @if(Auth::check())
        @if(!Auth::user()->email_verified_at == '')
        <li>
            <a href="/home" class="side-menu side-menu--{{ (request()->is('home')) ? 'active' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
                <div class="side-menu__title">
                    Dashboard
                </div>
            </a>
        </li>


        <!-- BEGIN: CLEARANCE -->
        <li class="hidden">
            <a href="javascript:;" class="side-menu side-menu--{{ (request()->is('student/clearance/*')) ? 'active' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="clipboard"></i> </div>
                <div class="side-menu__title">
                    Clearance
                    <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                </div>
            </a>

            <ul class="side-menu__{{ (request()->is('student/clearance/*')) ? 'sub-open' : '' }}">

                <li>
                    <a href="{{ route('myClearance') }}" class="side-menu side-menu--{{ (request()->is('student/clearance/my/clearance')) ? 'active' : '' }}">
                        <div class="side-menu__icon"> <i data-lucide="bookmark"></i> </div>
                        <div class="side-menu__title">
                            My Clearance
                        </div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- END: CLEARANCE -->


        <li>
            <a href="/my-portal" class="side-menu side-menu--{{ (request()->is('my-portal')) ? 'active' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="bookmark"></i> </div>
                <div class="side-menu__title">
                    My Grades
                </div>
            </a>
        </li>

        <li>
            <a href="/student-enroll" class="side-menu side-menu--{{ (request()->is('student-enroll')) ? 'active' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="bookmark"></i> </div>
                <div class="side-menu__title">
                    Enrollment
                </div>
            </a>
        </li>

        <li>
            <a href="/student-evaluation" class="side-menu side-menu--{{ (request()->is('student-evaluation')) ? 'active' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="bookmark"></i> </div>
                <div class="side-menu__title">
                    Evaluation
                </div>
            </a>
        </li>

    @if( auth()->user()->role === 'Admin')
        <li>
            <a href="{{ route ('enrolledList')}}" class="side-menu side-menu--{{ (request()->is('enroll/enrolled-list')) ? 'active' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="bookmark"></i> </div>
                <div class="side-menu__title">
                    Applicant List
                </div>
            </a>
        </li>
    @endif

    @if( auth()->user()->role === 'Admin')
        <!-- BEGIN: Student List -->
            {{--        <li>--}}
            {{--            <a href="{{ route ('student_list')}}" class="side-menu side-menu--{{ (request()->is('students')) ? 'active' : '' }}">--}}
            {{--                <div class="side-menu__icon"> <i data-lucide="bookmark"></i> </div>--}}
            {{--                <div class="side-menu__title">--}}
            {{--                    Students (e-SMS)--}}
            {{--                </div>--}}
            {{--            </a>--}}
            {{--        </li>--}}
        <!-- END: Student List -->
        @endif

        <li>
               <a href="javascript:;" class="side-menu side-menu--{{ (request()->is('onlinerequest/dashboard*')) ? 'active' : '' }}">
                    <div class="side-menu__icon"><i data-lucide="bookmark"></i></div>
                  <div class="side-menu__title">
                        Online Request
                       <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                    </div>
               </a>

            <ul class="side-menu__{{ (request()->is('onlinerequest/dashboard/*')) ? 'sub-open' : '' }}">

               <li>
                    <a href="{{ route('student_dashboard') }}" class="side-menu side-menu--{{ (request()->is('onlinerequest/dashboard/student/dashboard')) ? 'active' : '' }}">
                      <i class="fa-solid fa-house-user"></i>
                        <div class="side-menu__title"> My Dashboard</div>
                    </a>
                </li>


             @if(Auth::user()->office)

                <li>
                    <a href="{{ route('dashboard') }}" class="side-menu side-menu--{{ (request()->is('onlinerequest/dashboard/dashboard')) ? 'active' : '' }}">
                      <i class="fa-solid fa-gauge-high"></i>



                 <div class="side-menu__title"> Dashboard</div>
                    </a>
                 </li>


            @elseif(Auth::user()->role == 'Admin')



                <li>
                    <a href="{{ route('dashboard') }}" class="side-menu side-menu--{{ (request()->is('onlinerequest/dashboard/dashboard')) ? 'active' : '' }}">
                      <i class="fa-solid fa-gauge-high"></i>
                        <div class="side-menu__title"> Dashboard</div>
                    </a>
                 </li>



               <li>
                    <a href="{{ route('manage_or') }}" class="side-menu side-menu--{{ (request()->is('onlinerequest/dashboard/manage_or')) ? 'active' : '' }}">
                   <i class="fa-solid fa-gear"></i>
                        <div class="side-menu__title">Manage OR</div>
                    </a>
                </li>

            @endif

               </ul>

           </li>

        </li>
        <li style="display: none">
            <a href="/chat" class="side-menu side-menu--{{ (request()->is('chat')) ? 'active' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="message-square"></i> </div>
                <div class="side-menu__title">
                    Chat
                </div>
                <div id="load_unread_messages">

                </div>
            </a>
        </li>

        <!-- BEGIN: Admin -->
        <li style="display: none">
            <a href="javascript:;" class="side-menu side-menu--{{ (request()->is('my/grading/sheet/*')) ? 'active' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="settings"></i> </div>
                <div class="side-menu__title">
                    Admin
                    <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                </div>
            </a>


            <ul class="side-menu__{{ (request()->is('admin/*')) ? 'sub-open' : '' }}">

                <li>
                    <a href="/admin/ac" class="side-menu side-menu--{{ (request()->is('admin/ac')) ? 'active' : '' }}">
                        <i data-lucide="settings"></i>
                        <div class="side-menu__title">Account Management</div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('document_settings') }}" class="side-menu side-menu--{{ (request()->is('admin/document-settings')) ? 'active' : '' }}">
                        <i data-lucide="settings"></i>
                        <div class="side-menu__title">Document Settings</div>
                    </a>
                </li>

                <li>
                    <a href="/admin/rc" class="side-menu side-menu--{{ (request()->is('admin/rc')) ? 'active' : '' }}">
                        <i data-lucide="settings"></i>
                        <div class="side-menu__title">Responsibility Center</div>
                    </a>
                </li>


                <li>
                    <a href="/admin/group" class="side-menu side-menu--{{ (request()->is('admin/group')) ? 'active' : '' }}">
                        <i data-lucide="settings"></i>
                        <div class="side-menu__title">Groups</div>
                    </a>
                </li>

                <li>
                    <a href="/admin/user-privileges" class="side-menu side-menu--{{ (request()->is('admin/user-privileges')) ? 'active' : '' }}">
                    <a href="/admin/user-privileges" class="side-menu side-menu--{{ (request()->is('admin/user-privileges')) ? 'active' : '' }}">
                        <i data-lucide="settings"></i>
                        <div class="side-menu__title">User Privileges</div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('link_lists') }}" class="side-menu side-menu--{{ (request()->is('admin/link-list')) ? 'active' : '' }}">
                        <i data-lucide="settings"></i>
                        <div class="side-menu__title">Link List</div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('ss') }}" class="side-menu side-menu--{{ (request()->is('admin/ss')) ? 'active' : '' }}">
                        <i data-lucide="settings"></i>
                        <div class="side-menu__title">System Settings</div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('mail') }}" class="side-menu side-menu--{{ (request()->is('admin/mail/settings')) ? 'active' : '' }}">
                        <i data-lucide="settings"></i>
                        <div class="side-menu__title">Mail Settings</div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('student_list') }}" class="side-menu side-menu--{{ (request()->is('admin/mail/settings')) ? 'active' : '' }}">
                        <i data-lucide="settings"></i>
                        <div class="side-menu__title">Student List</div>
                    </a>
                </li>

            </ul>
        </li>
        <!-- END: Admin -->

        <li style="display: none">
            <a href="/article/my-article" class="side-menu side-menu--{{ (request()->is('article/my-article')) ? 'active' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="bookmark"></i> </div>
                <div class="side-menu__title">
                    Article
                </div>
            </a>
        </li>

         <!-- BEGIN: Set Semester Sched -->
            <li style="display: none">
                <a href="{{ route ('sem_sched')}}" class="side-menu side-menu--{{ (request()->is('sem/index')) ? 'active' : '' }}">
                    <div class="side-menu__icon"> <i data-lucide="bookmark"></i> </div>
                    <div class="side-menu__title">
                         Semestral Sched
                    </div>
                </a>
            </li>
        <!-- BEGIN: Set Semester Sched -->

         <!-- BEGIN: My Signature -->
         <li style="display: none">
            <a href="{{ route ('my_signature')}}" class="side-menu side-menu--{{ (request()->is('signature/my-sinature')) ? 'active' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="bookmark"></i> </div>
                <div class="side-menu__title">
                     My Signature
                </div>
            </a>
        </li>
        <!-- END: My Signature -->


        <!-- Begin: Voting -->
        <li>
            <a href="javascript:;" class="side-menu side-menu--{{ (request()->is('vote/*')) ? 'active' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="users"></i> </div>
                <div class="side-menu__title">
                    Elections
                    <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                </div>
            </a>

            <ul class="side-menu__{{ (request()->is('vote/*')) ? 'sub-open' : '' }}">

                {{-- @if(auth()->user()->role === 'Admin')
                    <li>
                        <a href="{{ route('votingType') }}" class="side-menu side-menu--{{ (request()->is('vote/voting-type')) ? 'active' : '' }}">
                            <i class="fa-solid fa-user-plus -mt-1"></i>
                            <div class="side-menu__title">Voting Type</div>
                        </a>
                    </li>

                    <li>
                            <a href="{{ route('votingPosition') }}" class="side-menu side-menu--{{ (request()->is('vote/voting-position')) ? 'active' : '' }}">
                                <i class="fa-solid fa-user-plus -mt-1"></i>
                                <div class="side-menu__title"> Voting Position </div>
                            </a>
                    </li>

                    <li>
                        <a href="{{ route('elect_parties_page') }}" class="side-menu side-menu--{{ (request()->is('vote/election-parties')) ? 'active' : '' }}">
                            <i class="fa-solid fa-user-plus -mt-1"></i>
                            <div class="side-menu__title"> Candidate Parties </div>
                        </a>
                    </li>
                @endif --}}

               {{-- <li style="display: none">
                    <a href="{{ route('elecRegistration') }}" class="side-menu side-menu--{{ (request()->is('vote/election-registration')) ? 'active' : '' }}">
                        <i class="fa-solid fa-user-plus -mt-1"></i>
                        <div class="side-menu__title"> Registration </div>
                    </a>
                </li> --}}

                <li>
                    <a href="{{ route('elecApplication') }}" class="side-menu side-menu--{{ (request()->is('vote/election-application')) ? 'active' : '' }}">
                        <i class="fa-solid fa-user-plus -mt-1"></i>
                        <div class="side-menu__title"> Election Application </div>
                    </a>
                </li>


               <li>
                   <a href="{{ route('elecParticipants') }}" class="side-menu side-menu--{{ (request()->is('vote/election-participants')) ? 'active' : '' }}">
                    <i class="fas fa-vote-yea"></i>
                       <div class="side-menu__title">Vote</div>
                   </a>
               </li>
                <li>
                    <a href="{{ route('result') }}" class="side-menu side-menu--{{ (request()->is('vote/election-result')) ? 'active' : '' }}">
                    <i class="fas fa-vote-yea"></i>
                        <div class="side-menu__title">Result</div>
                    </a>
                </li>

            </ul>
        </li>
        <!-- END: Voting -->

        <!-- BEGIN: Subsidary Ledger -->
        <li>
            <a href="javascript:;" class="side-menu side-menu--{{ (request()->is('student_ledger/*')) ? 'active' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="bookmark"></i> </div>
                <div class="side-menu__title">
                    My Ledger
                    <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                </div>
            </a>

            <ul class="side-menu__{{ (request()->is('student_ledger/*')) ? 'sub-open' : '' }}">
               <li>
                    <a href="{{ route('my_ledger') }}" class="side-menu side-menu--{{ (request()->is('student_ledger/my/ledger')) ? 'active' : '' }}">
                        <i class="fa-solid fa-book"></i>
                        <div class="side-menu__title"> Subsidiary Ledger</div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- END: Subsidary Ledger -->

        <!-- BEGIN: Academic Records -->
        <li>
            <a href="javascript:;" class="side-menu side-menu--{{ (request()->is('academic-records')) ? 'active' : '' }}">
                <div class="side-menu__icon"><i data-lucide="book"></i></div>
                <div class="side-menu__title">
                        Academic Records
                    <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                </div>
            </a>

            <ul class="side-menu__{{ (request()->is('academic-records')) ? 'sub-open' : '' }}">
               <li>
                    <a href="{{ route('academic_transcript') }}" class="side-menu side-menu--{{ (request()->is('academic-records')) ? 'active' : '' }}">
                        <i data-lucide="book-open"></i>
                        <div class="side-menu__title">Transcript</div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- END: Academic Records -->

        <!-- BEGIN: curriculum -->
        <li>
            <a href="javascript:;" class="side-menu side-menu--{{ (request()->is('curriculum*')) ? 'active' : '' }}">
                <div class="side-menu__icon"><i data-lucide="bookmark"></i></div>
                <div class="side-menu__title">
                        Curriculum
                    <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                </div>
            </a>

            <ul class="side-menu__{{ (request()->is('curriculum*')) ? 'sub-open' : '' }}">
                @if(auth()->user()->role === 'Admin')
                    <li>
                        <a href="{{ route('curriculum') }}" class="side-menu side-menu--{{ (request()->is('curriculum')) ? 'active' : '' }}">
                            <i data-lucide="book-open"></i>
                            <div class="side-menu__title">Curriculum</div>
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ route('my_curriculum') }}" class="side-menu side-menu--{{ (request()->is('curriculum/my-curriculum')) ? 'active' : '' }}">
                        <i data-lucide="book-open"></i>
                        <div class="side-menu__title">My Curriculum</div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- END: curriculum -->

        {{-- <li>
            <a href="/curriculum" class="side-menu side-menu--{{ (request()->is('curriculum')) ? 'active' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="bookmark"></i> </div>
                <div class="side-menu__title">
                    Curriculum
                </div>
            </a>
        </li> --}}

         <!-- BEGIN: Event Activities -->
         @if(Auth::user()->role === 'Admin')
            <li>
                <a href="javascript:;" class="side-menu side-menu--{{ (request()->is('event/*')) ? 'active' : '' }}">
                    <div class="side-menu__icon"> <i data-lucide="bookmark"></i> </div>
                    <div class="side-menu__title">
                        Events
                        <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                    </div>
                </a>

                <ul class="side-menu__{{ (request()->is('event/*')) ? 'sub-open' : '' }}">
                   <li>
                        <a href="{{ route('event_reminder') }}" class="side-menu side-menu--{{ (request()->is('event/reminder')) ? 'active' : '' }}">
                            <i class="fa-solid fa-bell"></i>
                            <div class="side-menu__title"> Reminder </div>
                        </a>
                    </li>
                </ul>
            </li>
         @endif
        <!-- END: Event Activities -->
        @endif
    @endif
    <!-- END: STUDENTS SIDE BAR -->





    <!-- BEGIN: PRE ENROLLEES SIDE BAR -->
    @if(auth()->guard('enrollees_guard')->check())
            @if(!auth()->guard('enrollees_guard')->user()->email_verified_at == '')
                <li>
                    <a href="{{ route('enrollees_home') }}" class="side-menu side-menu--{{ (request()->is('pre/enrollees/home')) ? 'active' : '' }}">
                        <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
                        <div class="side-menu__title">
                            Dashboard
                        </div>
                    </a>
                </li>

                <!-- BEGIN: Schedule -->
                <li>
                    <a href="javascript:;" class="side-menu side-menu--{{ (request()->is('enrollees/*') || request()->is('transaction/*')) ? 'active' : '' }}">
                        <div class="side-menu__icon"> <i data-lucide="calendar"></i> </div>
                        <div class="side-menu__title">
                            Schedule
                            <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                        </div>
                    </a>

                    <ul class="side-menu__{{ (request()->is('enrollees/*') || request()->is('transaction/*')) ? 'sub-open' : '' }}">


                        <li>
                            <a href="{{ route('enroll_schedule') }}" class="side-menu side-menu--{{ (request()->is('enrollees/schedule')) ? 'active' : '' }}">
                                <div class="side-menu__icon"> <i data-lucide="calendar"></i> </div>
                                <div class="side-menu__title">
                                    My Schedule
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('myTransaction') }}" class="side-menu side-menu--{{ (request()->is('transaction/my/transaction')) ? 'active' : '' }}">
                                <div class="side-menu__icon"> <i data-lucide="list"></i> </div>
                                <div class="side-menu__title">
                                    My Transactions
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- END: Schedule -->


            <!-- BEGIN: ENTRANCE EXAM -->
            <li>
                <a href="javascript:;" class="side-menu side-menu--{{ (request()->is('exam/*')) ? 'active' : '' }}">
                    <div class="side-menu__icon"> <i data-lucide="folder"></i> </div>
                    <div class="side-menu__title">
                        Entrance Exam
                        <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                    </div>
                </a>

                <ul class="side-menu__{{ (request()->is('exam/*')) ? 'sub-open' : '' }}">
                    <li>
                        <a href="{{ route('myEntranceExamResult') }}" class="side-menu side-menu--{{ (request()->is('exam/my/result')) ? 'active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="award"></i> </div>
                            <div class="side-menu__title">
                                Results
                            </div>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- END: ENTRANCE EXAM -->


            @endif

    <!-- END: PRE ENROLLEES SIDE BAR -->


    <!-- BEGIN: EMPLOYEE SIDE BAR -->

    @elseif(auth()->guard('employee_guard')->check())

                <!-- BEGIN: EMPLOYEE DASHBOARD -->
                <li>
                    <a href="{{ route('enrollees_dashboard') }}" class="side-menu side-menu--{{ (request()->is('admin/dashboard')) ? 'active' : '' }}">
                        <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
                        <div class="side-menu__title">
                            Dashboard
                        </div>
                    </a>
                </li>
                <!-- END: EMPLOYEE DASHBOARD -->



                <!-- BEGIN: CLEARANCE -->
                <li>
                    <a href="javascript:;" class="side-menu side-menu--{{ (request()->is('student/clearance/*')) ? 'active' : '' }}">
                        <div class="side-menu__icon"> <i data-lucide="clipboard"></i> </div>
                        <div class="side-menu__title">
                            Clearance
                            <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                        </div>
                    </a>

                    <ul class="side-menu__{{ (request()->is('student/clearance/*')) ? 'sub-open' : '' }}">

                    <li>
                        <a href="{{ route('overview') }}" class="side-menu side-menu--{{ (request()->is('student/clearance/overview')) ? 'active' : '' }}">
                            <div class="side-menu__icon"> <i data-lucide="star"></i> </div>
                            <div class="side-menu__title">
                                Overview
                            </div>
                        </a>
                    </li>
                    </ul>
                </li>
                <!-- END: CLEARANCE -->

            @if(auth()->guard('employee_guard')->user()->role_name === 'Admin')
                <!-- BEGIN: ENTRANCE EXAM -->
                <li>
                    <a href="javascript:;" class="side-menu side-menu--{{ (request()->is('exam/*')) ? 'active' : '' }}">
                        <div class="side-menu__icon"> <i data-lucide="folder"></i> </div>
                        <div class="side-menu__title">
                            Entrance Exam
                            <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                        </div>
                    </a>

                    <ul class="side-menu__{{ (request()->is('exam/*')) ? 'sub-open' : '' }}">

                        @if(auth()->guard('employee_guard')->user()->role_name === 'Admin')
                            <li>
                                <a href="{{ route('entranceExamineesList') }}" class="side-menu side-menu--{{ (request()->is('exam/list')) ? 'active' : '' }}">
                                    <div class="side-menu__icon"> <i data-lucide="users"></i> </div>
                                    <div class="side-menu__title">
                                        Examinees List
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('entranceExamineesRatedList') }}" class="side-menu side-menu--{{ (request()->is('exam/rated/list')) ? 'active' : '' }}">
                                    <div class="side-menu__icon"> <i data-lucide="edit-3"></i> </div>
                                    <div class="side-menu__title">
                                        Rated List
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('entranceExamineesShortList') }}" class="side-menu side-menu--{{ (request()->is('exam/short/listed')) ? 'active' : '' }}">
                                    <div class="side-menu__icon"> <i data-lucide="list"></i> </div>
                                    <div class="side-menu__title">
                                        Short Listed
                                    </div>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
                <!-- END: ENTRANCE EXAM -->


                <!-- BEGIN: ACCOUNTS -->
                <li>
                    <a href="javascript:;" class="side-menu side-menu--{{ (request()->is('ASIS/admin/*')) ? 'active' : '' }}">
                        <div class="side-menu__icon"> <i data-lucide="settings"></i> </div>
                        <div class="side-menu__title">
                            Manage
                            <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                        </div>
                    </a>

                    <ul class="side-menu__{{ (request()->is('ASIS/admin/*')) ? 'sub-open' : '' }}">

                        @if(auth()->guard('employee_guard')->user()->role_name === 'Admin')
                            <li>
                                <a href="{{ route('adminStudentsAccountManagement') }}" class="side-menu side-menu--{{ (request()->is('ASIS/admin/manage/students/accounts')) ? 'active' : '' }}">
                                    <div class="side-menu__icon"> <i data-lucide="users"></i> </div>
                                    <div class="side-menu__title">
                                        Students (My-SQL)
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route ('student_list')}}" class="side-menu side-menu--{{ (request()->is('ASIS/admin/students/e-sms')) ? 'active' : '' }}">
                                    <div class="side-menu__icon"> <i data-lucide="users"></i> </div>
                                    <div class="side-menu__title">
                                        Students (e-SMS)
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('adminEnrolleesAccountManagement') }}" class="side-menu side-menu--{{ (request()->is('ASIS/admin/manage/enrollees/accounts')) ? 'active' : '' }}">
                                    <div class="side-menu__icon"> <i data-lucide="users"></i> </div>
                                    <div class="side-menu__title">
                                        Enrollees Accounts
                                    </div>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
                <!-- END: ACCOUNTS -->


                <!-- BEGIN:: Online Request Here  -->
                <li>
                    <a href="javascript:;" class="side-menu side-menu--{{ (request()->is('test/*') || request()->is('test/*')) ? 'active' : '' }}">
                        <div class="side-menu__icon"> <i data-lucide="bookmark"></i> </div>
                        <div class="side-menu__title">
                            Online Request
                            <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                        </div>
                    </a>

                    <ul class="side-menu__{{ (request()->is('onlinerequest/dashboard/*')) ? 'sub-open' : '' }}">




                    <li>
                    <a href="{{ route('dashboard') }}" class="side-menu side-menu--{{ (request()->is('onlinerequest/dashboard/dashboard')) ? 'active' : '' }}">
                         <div class="side-menu__icon"> <i data-lucide="bookmark"></i> </div>
                        <div class="side-menu__title"> Dashboard</div>
                    </a>
                     </li>

                        <li>
                            <a href="{{ route('manage_or') }}" class="side-menu side-menu--{{ (request()->is('onlinerequest/dashboard/manage_or')) ? 'active' : '' }}">
                                <div class="side-menu__icon"> <i data-lucide="settings"></i> </div>
                                <div class="side-menu__title">
                                    Manage Online Request
                                </div>
                            </a>
                        </li>

                        </li>


                    </ul>
                </li>
                <!-- END::  Request Here  -->

                <!-- BEGIN: PROGRAM -->
                <li>
                    <a href="javascript:;" class="side-menu side-menu--{{ (request()->is('program/*')) ? 'active' : '' }}">
                        <div class="side-menu__icon"> <i data-lucide="book"></i> </div>
                        <div class="side-menu__title">
                            Program
                            <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                        </div>
                    </a>

                    <ul class="side-menu__{{ (request()->is('program/*')) ? 'sub-open' : '' }}">

                        @if(auth()->guard('employee_guard')->user()->role_name === 'Admin')
                            <li>
                                <a href="{{ route('programOverview') }}" class="side-menu side-menu--{{ (request()->is('program/overview')) ? 'active' : '' }}">
                                    <div class="side-menu__icon"> <i data-lucide="star"></i> </div>
                                    <div class="side-menu__title">
                                        Overview
                                    </div>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
                <!-- END: ENTRANCE EXAM -->

                <!-- BEGIN: SCHEDULE and TRANSACTION LIST -->
                <li>
                    <a href="javascript:;" class="side-menu side-menu--{{ (request()->is('enrollees/*') || request()->is('transaction/*')) ? 'active' : '' }}">
                        <div class="side-menu__icon"> <i data-lucide="calendar"></i> </div>
                        <div class="side-menu__title">
                            Schedule
                            <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                        </div>
                    </a>

                    <ul class="side-menu__{{ (request()->is('enrollees/*') || request()->is('transaction/*')) ? 'sub-open' : '' }}">

                        @if(auth()->guard('employee_guard')->user()->role_name === 'Admin')
                            <li>
                                <a href="{{ route('enrollees_overview') }}" class="side-menu side-menu--{{ (request()->is('enrollees/schedule/overview')) ? 'active' : '' }}">
                                    <div class="side-menu__icon"> <i data-lucide="star"></i> </div>
                                    <div class="side-menu__title">
                                        Overview
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('transactionList') }}" class="side-menu side-menu--{{ (request()->is('transaction/list')) ? 'active' : '' }}">
                                    <div class="side-menu__icon"> <i data-lucide="list"></i> </div>
                                    <div class="side-menu__title">
                                        Transaction List
                                    </div>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
                <!-- END: SCHEDULE and TRANSACTION LIST -->

                <!-- Begin: Voting -->
                <li>
                    <a href="javascript:;" class="side-menu side-menu--{{ (request()->is('vote/*')) ? 'active' : '' }}">
                        <div class="side-menu__icon"> <i data-lucide="users"></i> </div>
                        <div class="side-menu__title">
                            Elections
                            <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                        </div>
                    </a>

                    <ul class="side-menu__{{ (request()->is('vote/*')) ? 'sub-open' : '' }}">

                        {{-- @if(auth()->user()->role === 'Admin') --}}
                            <li>
                                <a href="{{ route('votingType') }}" class="side-menu side-menu--{{ (request()->is('vote/voting-type')) ? 'active' : '' }}">
                                    <i class="fa-solid fa-user-plus -mt-1"></i>
                                    <div class="side-menu__title">Voting Type</div>
                                </a>
                            </li>

                            <li>
                                    <a href="{{ route('votingPosition') }}" class="side-menu side-menu--{{ (request()->is('vote/voting-position')) ? 'active' : '' }}">
                                        <i class="fa-solid fa-user-plus -mt-1"></i>
                                        <div class="side-menu__title"> Voting Position </div>
                                    </a>
                            </li>

                            <li>
                                <a href="{{ route('elect_parties_page') }}" class="side-menu side-menu--{{ (request()->is('vote/election-parties')) ? 'active' : '' }}">
                                    <i class="fa-solid fa-user-plus -mt-1"></i>
                                    <div class="side-menu__title"> Candidate Parties </div>
                                </a>
                            </li>


                        {{-- @endif --}}

                    {{-- <li style="display: none">
                            <a href="{{ route('elecRegistration') }}" class="side-menu side-menu--{{ (request()->is('vote/election-registration')) ? 'active' : '' }}">
                                <i class="fa-solid fa-user-plus -mt-1"></i>
                                <div class="side-menu__title"> Registration </div>
                            </a>
                        </li> --}}

                        <li>
                            <a href="{{ route('elecApplication') }}" class="side-menu side-menu--{{ (request()->is('vote/election-application')) ? 'active' : '' }}">
                                <i class="fa-solid fa-user-plus -mt-1"></i>
                                <div class="side-menu__title"> Election Application </div>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('result') }}" class="side-menu side-menu--{{ (request()->is('vote/election-result')) ? 'active' : '' }}">
                            <i class="fas fa-vote-yea"></i>
                                <div class="side-menu__title">Result</div>
                            </a>
                        </li>

                    </ul>
                </li>
                <!-- END: Voting -->

            @endif
    @endif
    <!-- END: EMPLOYEE SIDE BAR -->



</ul>
</nav>
