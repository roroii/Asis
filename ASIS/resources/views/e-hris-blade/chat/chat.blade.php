@extends('layouts.app')

@section('content')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">
        Chat
    </h2>
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
        <button class="btn btn-primary shadow-md mr-2" data-tw-toggle="modal" data-tw-target="#chat_modal_new_conversation">Group Chat</button>
        {{-- <div class="dropdown ml-auto sm:ml-0">
            <button class="dropdown-toggle btn px-2 box text-slate-500" aria-expanded="false" data-tw-toggle="dropdown">
                <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span>
            </button>
            <div class="dropdown-menu w-40">
                <ul class="dropdown-content">
                    <li>
                        <a href="" class="dropdown-item"> <i data-lucide="users" class="w-4 h-4 mr-2"></i> Create Group </a>
                    </li>
                    <li>
                        <a href="" class="dropdown-item"> <i data-lucide="settings" class="w-4 h-4 mr-2"></i> Settings </a>
                    </li>
                </ul>
            </div>
        </div> --}}
    </div>
</div>

<div class="intro-y chat grid grid-cols-12 gap-5 mt-5">
    <!-- BEGIN: Chat Side Menu -->
    <div class="intro-y col-span-12 lg:col-span-8 2xl:col-span-3 lg:row-span-3">
        <div class="intro-y pr-1">
            <div class="box p-2">
                <ul class="nav nav-pills" role="tablist">
                    <li id="chats-tab" class="nav-item flex-1" role="presentation">
                        <button class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#chats" type="button" role="tab" aria-controls="chats" aria-selected="true" > Chats </button>
                    </li>
                    <li id="friends-tab" class="nav-item flex-1" role="presentation">
                        <button id="load_all_users" class="nav-link w-full py-2 h-full" data-tw-toggle="pill" data-tw-target="#friends" type="button" role="tab" aria-controls="friends" aria-selected="false" > Users </button>
                    </li>
                    <li id="profile-tab" class="nav-item flex-1" role="presentation">
                        <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false" > Profile </button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tab-content">
            <div id="chats" class="tab-pane active" role="tabpanel" aria-labelledby="chats-tab">
                <div class="pr-1">
                    <div class="box px-4 pt-2 pb-5 lg:pb-1 mt-2">
                        <div class="relative text-slate-500 pr-1 pt-1 mt-2">
                            <input onkeyup="doDelayedSearch(this.value)" autocomplete="off" id="seach_input_chatbox" type="text" class="form-control py-3 px-4 border-transparent bg-slate-100 pr-10" placeholder="Find a user...">
                            <i class="w-4 h-4 hidden sm:absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                        </div>
                        <div class="overflow-x-auto scrollbar-hidden ">
                            <div  class="flex mt-4" id="users_on_search">

                            </div>
                        </div>
                    </div>
                </div>


                {{-- conversation list --}}

                <div id="load_chat_user_conversation" class="chat__chat-list overflow-y-auto  pr-1 pt-1 mt-4">
                    <div id="load_direct_message" >

                    </div>
                </div>



            </div>
            <div id="friends" class="tab-pane h-full" role="tabpanel" aria-labelledby="friends-tab">
                <div style="height: 730px" id="div_append_all_users" class="chat__user-list overflow-y-auto h-full pr-1 pt-1 ">


                </div>
            </div>
            <div id="profile" class="tab-pane" role="tabpanel" aria-labelledby="profile-tab">
                <div class="pr-1">
                    <div class="box px-5 py-10 mt-5">
                        <div class="w-20 h-20 flex-none image-fit rounded-full overflow-hidden mx-auto">
                            <img alt="Profile" src="{{ get_profile_image(Auth::user()->employee) }}">
                        </div>
                        <div class="text-center mt-3">
                            <div class="font-medium text-lg">{{ fullname(Auth::user()->employee) }}</div>
                            <div class="text-slate-500 mt-1">{{  getLoggedUserPosition()  }}</div>




                        </div>
                    </div>
                    <div class="box p-5 mt-5">
                        <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5">
                            <div>
                                <div class="text-slate-500">Address</div>
                                <div class="mt-1">{{
                                    profile_details(Auth::user()->employee)->placeofbirth
                                 }}</div>
                            </div>
                            <i data-lucide="globe" class="w-4 h-4 text-slate-500 ml-auto"></i>
                        </div>
                        <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 py-5">
                            <div>
                                <div class="text-slate-500">Phone</div>
                                <div class="mt-1">{{
                                    profile_details(Auth::user()->employee)->mobile_number
                                 }}</div>
                            </div>
                            <i data-lucide="mic" class="w-4 h-4 text-slate-500 ml-auto"></i>
                        </div>
                        <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 py-5">
                            <div>
                                <div class="text-slate-500">Email</div>
                                <div class="mt-1">{{
                                    profile_details(Auth::user()->employee)->email
                                 }}</div>
                            </div>
                            <i data-lucide="mail" class="w-4 h-4 text-slate-500 ml-auto"></i>
                        </div>
                        <div class="flex items-center pt-5">
                            <div>
                                <div class="text-slate-500">Joined Date</div>
                                <div class="mt-1">{{Carbon\Carbon::parse(profile_details(Auth::user()->employee)->entrydate)->diffForHumans()}}</div>
                            </div>
                            <i data-lucide="clock" class="w-4 h-4 text-slate-500 ml-auto"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Chat Side Menu -->

    <!-- BEGIN: Chat Content -->
    <div class="intro-y col-span-12 lg:col-span-8 2xl:col-span-9">
        <div class="chat__box box">
            <!-- BEGIN: Chat Active -->
            <div class="h-full flex flex-col">
                <div id="load_header_chat_box" class="flex flex-col sm:flex-row border-b border-slate-200/60 dark:border-darkmode-400 px-5 py-4">
                    <!-- <a href="deleteppmp/" class="dropdown-item btn btn-danger sweet-success-cancel" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="fa fa-trash"></i> Delete</a> -->
                </div>
                <div id="load_main_view_chat" class="overflow-y-scroll scrollbar-hidden px-5 pt-5 flex-1">
                    <div class="h-full flex items-center">
                        <div class="mx-auto text-center">
                            <div class="w-16 h-16 flex-none image-fit rounded-full overflow-hidden mx-auto">
                                <img alt="user-profile-picture" class="rounded-full" src="{{ get_profile_image(Auth::user()->employee) }}">
                            </div>
                            <div class="mt-3">
                                <div class="font-medium">Hi there, {{ Str::title(Auth::user()->firstname)  }}</div>
                                <div class="text-slate-500 mt-1">Start a conversation by picking a person.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="load_footer_chat_box" class="pt-4 pb-10 sm:py-4 flex items-center border-t border-slate-200/60 dark:border-darkmode-400">

                </div>
            </div>
            <!-- END: Chat Active -->

        </div>
    </div>
    <!-- END: Chat Content -->
</div>

    @include('chat.chat_modals.create_conversation')
    @include('chat.chat_modals.view_conversation_members')
    @include('chat.chat_modals.add_new_members')
    @include('chat.chat_modals.leave_conversation_modal')
    @include('chat.chat_modals.remove_conversation_modal')
    @include('chat.chat_modals.sent_message_to_user')

@endsection
@section('scripts')
<script src="{{asset('js/app.js')}}"></script>
<script>



</script>
<script src="{{ asset('/js/chat/chat.js') }}"></script>
@endsection

