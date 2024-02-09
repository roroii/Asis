<?php

namespace App\Http\Controllers\chat;

use App\Events\load_conversation_id;
use App\Events\load_have_message;
use App\Events\load_new_message;
use App\Events\load_user_id;
use App\Http\Controllers\Controller;
use App\Models\chat\chat_conversation;
use App\Models\chat\chat_members;
use App\Models\chat\chat_messages;
use App\Models\chat\chat_viewers;
use App\Models\event\event;
use App\Models\tblemployee;
use App\Models\User;
use Auth;
use Cache;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class chatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('auth',['except' => ['login','setup','setupSomethingElse']]);
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

     public function chat()
     {
        return view('chat.chat');
     }

     public function chat_search_user_info(Request $request)
     {
        $keyword = $request->search_key;
        $current_user_id = Auth::user()->employee;
        $users_on_search ='';

        $q_users_on_search = User::with('getUserinfo')->where(function ($query) use ($keyword) {
                $query->where('id', 'like', '%' . $keyword . '%')
                ->orWhere('firstname', 'like', '%' . $keyword . '%')
                ->orWhere('middlename', 'like', '%' . $keyword . '%')
                ->orWhere('lastname', 'like', '%' . $keyword . '%')
                ->orWhere('username', 'like', '%' . $keyword . '%')
                ->orWhere('email', 'like', '%' . $keyword . '%');
            })->whereNotNull('last_seen')
            ->where('id','!=',Auth::user()->id)
            ->where('active',1)
            ->whereHas('getUserinfo')
            ->inRandomOrder()
            ->orderBy('last_seen', 'DESC')
            ->take(10)
            ->get();

            if($q_users_on_search){

                foreach($q_users_on_search as $user){
                    $fullname = 'N/A';
                    $firstname = 'N/A';
                    $lastname = 'N/A';
                    if( $user->getUserinfo()->exists()){
                        $fullname = $user->getUserinfo->firstname .' '. $user->getUserinfo->lastname;
                        $firstname = $user->getUserinfo->firstname;
                        $lastname = $user->getUserinfo->lastname;
                    }

                    $conversation_id ='';

                    $users_on_search
                        .= '
                            <div class="w-10 mr-4 cursor-pointer " data-us-id="'.$user->employee.'" data-nm-fn="'.Str::title(fullname($user->employee)).'" >
                                <div class="w-10 h-10 flex-none image-fit rounded-full">
                                    <img alt="profile-picture" data-action="zoom" class="rounded-full zoom-in" src="'.get_profile_image($user->employee).'">
                                        '. user_status($user->employee) .'
                                </div>
                                <div class="text-align-center div_load_on_modal" data-us-id="'.$user->employee.'" data-nm-fn="'.Str::title(fullname($user->employee)).'" data-tw-toggle="modal" data-tw-target="#chat_modal_send_message" >
                                    <div class="text-xs text-slate-500 truncate text-center mt-2">'.Str::title($firstname).'</div>
                                    <div class="text-xs text-slate-500 truncate text-center ">'.Str::title($lastname).'</div>
                                </div>
                            </div>
                        ';
                }
            }else{
                $users_on_search
                        .= '
                        <div class="w-10 mr-4 cursor-pointer">
                            <strong>No User Found!</strong>
                        </div>
                        ';
            }



         return json_encode(array(
             "users_on_search"=>$users_on_search,
             "current_user_id"=>$current_user_id,
         ));
     }

     public function load_my_conversations(Request $request){
        $data = $request->all();
        $load_conversations = '';
        $group_chat_images = '';

        $get_conversations = chat_conversation::with(['get_members.getUserinfo','get_im_member','count_message_unseen','chat_messages' => function ($q) {
            $q->orderBy('chat_messages.created_at', 'DESC');
        }])->where('active',1)->whereHas('get_im_member')->orderBy('updated_at', 'DESC')->get();

        foreach($get_conversations as $conversation){
            $current_message_count = '';
            $user_information_id = '';
            $user_information_name = '';
            $current_message_count_message = 'No Messages';
            $current_message_count_created_at = Carbon::now()->diffForHumans();

            if($conversation->count_message_unseen()->exists()){
                $current_message_count = '<div class="z-index fa-beat w-5 h-5 flex items-center justify-center absolute top-0 right-0 text-xs text-white rounded-full bg-primary font-medium -mt-1 -mr-1 div_number_of_not_seen">'.$conversation->count_message_unseen->count().'</div>';
            }
            if($conversation->chat_messages()->exists()){

                $get_latest_message = $conversation->chat_messages()->orderBy('created_at', 'desc')->first();
                $current_message_count_message = $get_latest_message->message_text;
                $current_message_count_created_at = $get_latest_message->created_at->diffForHumans();
            }
            if($conversation->get_members()->exists()){

                if($conversation->conversation_type == 'direct_message'){
                    foreach($conversation->get_members as $member){

                        // $user_information_id = $member->user_id;
                        $group_chat_images .= '<div class="w-10 h-10 flex-none image-fit mr-1">
                        <img alt="user_profile" class="rounded-full" data-action="zoom" src="'.get_profile_image($member->user_id).'">
                        '.user_status($member->user_id).'
                    </div>';


                        $user_information_name= '';
                        if( $member->getUserinfo()->exists()){
                            $user_information_name = $member->getUserinfo->firstname .' '. $member->getUserinfo->lastname;
                        }
                    }
                }else{

                    foreach($conversation->get_members->take(3) as $key => $member){
                        $total_members = $conversation->get_members->count() - 3;
                        $names = 'N/A';
                        $image = 'N/A';
                        if( $member->getUserinfo()->exists()){
                            $names = $member->getUserinfo->firstname .' '. $member->getUserinfo->lastname;
                        }
                        $class_merge = '-ml-5';
                        if( $key == 0){
                            $class_merge = '';
                        }

                        if( $key == 2){
                            $group_chat_images .= '
                            <div class="'.$class_merge.' zoom-in h-10 w-10 image-fit rounded-full overflow-hidden items-center before:block before:absolute before:w-full before:h-full before:top-0 before:left-0 before:z-10 before:bg-gradient-to-t before:from-black before:to-black/10">
                                    <img alt="'. $names.'" class="rounded-full" data-action="zoom" src="'.get_profile_image($member->user_id).'" title="'. $names.'">
                                    <div class="absolute text-white z-10 items-center"> <small style="line-height: 1em;" class="block mt-1 pl-1 pt-1 w-full items-center">+'.$total_members.' Others</small></div>
                                </div>';
                        }else{
                            $group_chat_images .= '
                            <div class="w-10 h-10 image-fit zoom-in '.$class_merge.'">
                                <img alt="'. $names.'" class="tooltip rounded-full" data-action="zoom" src="'.get_profile_image($member->user_id).'" title="'. $names.'">
                                '.user_status($member->user_id).'
                            </div>';
                        }



                    }



                    // $user_information_id = Auth::user()->employee;
                    $user_information_name = $conversation->title;
                }


            }else{
                //No Members yet
                $group_chat_images .= '<div class="w-10 h-10 flex-none image-fit mr-1">
                <img alt="user_profile" data-action="zoom" class="rounded-full" src="'.get_profile_image(Auth::user()->employee).'">
                '.user_status(Auth::user()->employee).'
            </div>';

            $user_information_name = $conversation->title;
            }



            $load_conversations
                .= '
                    <div data-cv-id="'.$conversation->id.'" conversation_id="'.$conversation->id.'" user_id="'.$user_information_id.'" class="intro-x cursor-pointer box  flex items-center p-5 mt-5 mr-1 zoom-in on_click_load_conversation_with_id">
                    <div class="flex">
                        '. $group_chat_images.'

                    </div>
                        <div class="ml-2 overflow-hidden">
                            <div class="flex items-center w-full">
                                <a href="javascript:;" class="font-medium truncate">'.Str::title($user_information_name).'</a>
                                <div class="text-xs text-slate-400 ml-auto absolute top-0 right-0 mt-1"><small style="padding: 25px;">'.$current_message_count_created_at.'</small></div>
                            </div>
                            <div class="w-full truncate text-slate-500 mt-0.5">'.$current_message_count_message.'</div>

                        </div>
                        '.$current_message_count.'

                    </div>

                ';
                $group_chat_images = '';
        }

        return json_encode(array(
            "data"=>$data,
            "load_conversations"=>$load_conversations,
        ));

     }

     public function load_conversation_content(Request $request){
        $data = $request->all();
        $load_header_chat_box = '';
        $load_footer_chat_box = '';
        $load_main_view_chat = '';

        $get_conversations = chat_conversation::
        with('get_members.getUserinfo','get_im_member','count_message_unseen','chat_messages')
        ->where('id',$request->conversation_id)
        ->first();

        if($get_conversations){

            //load_header_of_the_chat_box
            if ($get_conversations->conversation_type === 'direct_message') {
                if($get_conversations->get_members()->exists()){
                    foreach($get_conversations->get_members as $member){

                        $user_information_name=fullname($member->user_id);

                        $load_header_chat_box = '
                            <div class="w-10 h-10 sm:w-12 sm:h-12 flex-n1`one image-fit relative">
                            <img alt="user-profile-picture" class="rounded-full" data-action="zoom" src="'.get_profile_image($member->user_id).'">
                                '.user_status($member->user_id).'
                            </div>
                            <div class="ml-3 mr-auto">
                                <div class="font-medium text-base">'.Str::title($user_information_name).'</div>
                                <div class="text-slate-500 text-xs sm:text-sm cursor-pointer btn_load_members" data-cv-id="'.$request->conversation_id.'" data-tw-toggle="modal" data-tw-target="#view_conversation_members_modal">Direct Message<span class="mx-1 text-success">•</span>Active</div>
                                <input hidden name="main_view_chat_user_id" id="main_view_chat_user_id" type="text" value="'.$member->user_id.'" class="form-check-input">
                                <input hidden name="load_conversation_id_main_view" id="load_conversation_id_main_view" type="text" value="'.$request->conversation_id.'" class="form-check-input">
                                <input hidden name="load_conversation_type" id="load_conversation_type" type="text" value="DM" class="form-check-input">
                            </div>
                            <div class="flex items-center sm:ml-auto mt-5 sm:mt-0 border-t sm:border-0 border-slate-200/60 pt-3 sm:pt-0 -mx-5 sm:mx-0 px-5 sm:px-0">
                                    <a href="javascript:;" class="w-5 h-5 text-slate-500 ml-5 refresh_conversation_with_id"> <i  class="fa fa-refresh w-4 h-4"></i> </a>
                                    <div class="dropdown ml-auto sm:ml-3">
                                        <a href="javascript:;" class="dropdown-toggle w-5 h-5 text-slate-500" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h w-4 h-4"></i> </a>
                                        <div class="dropdown-menu w-40">
                                            <ul class="dropdown-content">
                                                <li>
                                                    <a data-cv-id="'.$request->conversation_id.'" href="javascript:;" class="dropdown-item btn_load_members" data-tw-toggle="modal" data-tw-target="#view_conversation_members_modal"> <i class="fa fa-user w-4 h-4 mr-2"></i> Member </a>
                                                </li>
                                                <li>
                                                    <a data-cv-id="'.$request->conversation_id.'" href="javascript:;" class="dropdown-item btn_leave_conversation" data-tw-toggle="modal" data-tw-target="#chat_modal_leave_conversation"> <i class="fa fa-sign-out w-4 h-4 mr-2"></i> Leave </a>
                                                </li>
                                                <li>
                                                    <a data-cv-id="'.$request->conversation_id.'" href="javascript:;" class="dropdown-item btn_remove_conversation" data-tw-toggle="modal" data-tw-target="#chat_modal_remove_conversation"> <i class="fa fa-remove w-4 h-4 mr-2"></i> Remove </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            ';

                        $load_footer_chat_box = '
                            <textarea id="textarea_send_the_message" data-cv-id="'.$request->conversation_id.'" class="chat__box__input form-control dark:bg-darkmode-600 h-16 resize-none border-transparent px-5 py-3 shadow-none focus:border-transparent focus:ring-0" rows="1" placeholder="Type your message..."></textarea>
                            <div class="flex absolute sm:static left-0 bottom-0 ml-5 sm:ml-0 mb-5 sm:mb-0">
                                <div class="w-4 h-4 sm:w-5 sm:h-5 relative text-slate-500 mr-3 sm:mr-5">

                                </div>
                            </div>
                            <button id="btn_send_message_onclick" class="w-8 h-8 sm:w-10 sm:h-10 block bg-primary text-white rounded-full flex-none flex items-center justify-center mr-5" data-cv-id="'.$request->conversation_id.'"> <i class="fa fa-paper-plane"></i> </button>
                        ';
                    }

                }else{
                        $load_header_chat_box = '
                            <div class="w-10 h-10 sm:w-12 sm:h-12 flex-n1`one image-fit relative">
                            <img alt="user-profile-picture" class="rounded-full" data-action="zoom" src="'.get_profile_image(Auth::user()->employee).'">
                                '.user_status(Auth::user()->employee).'
                            </div>
                            <div class="ml-3 mr-auto">
                                <div class="font-medium text-base">'.Str::title(fullname(Auth::user()->employee)).'</div>
                                <div class="text-slate-500 text-xs sm:text-sm">Direct Message<span class="mx-1">•</span>Inactive</div>

                            </div>
                            <div class="flex items-center sm:ml-auto mt-5 sm:mt-0 border-t sm:border-0 border-slate-200/60 pt-3 sm:pt-0 -mx-5 sm:mx-0 px-5 sm:px-0">
                                    <a href="javascript:;" class="w-5 h-5 text-slate-500 ml-5 refresh_conversation_with_id"> <i  class="fa fa-refresh w-4 h-4"></i> </a>
                                    <div class="dropdown ml-auto sm:ml-3">
                                        <a href="javascript:;" class="dropdown-toggle w-5 h-5 text-slate-500" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h w-4 h-4"></i> </a>
                                        <div class="dropdown-menu w-40">
                                            <ul class="dropdown-content">
                                                <li>
                                                    <a data-cv-id="'.$request->conversation_id.'" href="javascript:;" class="dropdown-item btn_load_members" data-tw-toggle="modal" data-tw-target="#view_conversation_members_modal"> <i class="fa fa-user w-4 h-4 mr-2"></i> Member </a>
                                                </li>
                                                <li>
                                                    <a data-cv-id="'.$request->conversation_id.'" href="javascript:;" class="dropdown-item btn_leave_conversation" data-tw-toggle="modal" data-tw-target="#chat_modal_leave_conversation"> <i class="fa fa-sign-out w-4 h-4 mr-2"></i> Leave </a>
                                                </li>
                                                <li>
                                                    <a data-cv-id="'.$request->conversation_id.'" href="javascript:;" class="dropdown-item btn_remove_conversation" data-tw-toggle="modal" data-tw-target="#chat_modal_remove_conversation"> <i class="fa fa-remove w-4 h-4 mr-2"></i> Remove </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            ';

                        $load_footer_chat_box = '
                            <textarea id="textarea_send_the_message" data-cv-id="'.$request->conversation_id.'" class="chat__box__input form-control dark:bg-darkmode-600 h-16 resize-none border-transparent px-5 py-3 shadow-none focus:border-transparent focus:ring-0" rows="1" placeholder="Type your message..."></textarea>
                            <div class="flex absolute sm:static left-0 bottom-0 ml-5 sm:ml-0 mb-5 sm:mb-0">
                                <div class="w-4 h-4 sm:w-5 sm:h-5 relative text-slate-500 mr-3 sm:mr-5">

                                </div>
                            </div>
                            <button id="btn_send_message_onclick" class="w-8 h-8 sm:w-10 sm:h-10 block bg-primary text-white rounded-full flex-none flex items-center justify-center mr-5" data-cv-id="'.$request->conversation_id.'"> <i class="fa fa-paper-plane"></i> </button>
                        ';
                }
            }else{
                if($get_conversations->get_members()->exists()){
                    foreach($get_conversations->get_members as $member){

                    }

                    $load_header_chat_box = '
                            <div class="w-10 h-10 sm:w-12 sm:h-12 flex-n1`one image-fit relative">
                                <img alt="user-profile-picture" class="rounded-full" data-action="zoom" src="'.get_profile_image(Auth::user()->employee).'">
                                '.user_status(Auth::user()->employee).'
                            </div>
                            <div class="ml-3 mr-auto">
                                <div class="font-medium text-base">'. Str::title($get_conversations->title).'</div>
                                <div class="text-slate-500 text-xs sm:text-sm cursor-pointer btn_load_members" data-cv-id="'.$request->conversation_id.'" data-tw-toggle="modal" data-tw-target="#view_conversation_members_modal">Group Message<span class="mx-1 text-success">•</span>Active <span class="mx-1 text-success">•</span>'.$get_conversations->get_members->count().' Member(s)</div>
                            </div>
                            <div class="flex items-center sm:ml-auto mt-5 sm:mt-0 border-t sm:border-0 border-slate-200/60 pt-3 sm:pt-0 -mx-5 sm:mx-0 px-5 sm:px-0">
                                <a href="javascript:;" class="w-5 h-5 text-slate-500 ml-5 refresh_conversation_with_id"> <i  class="fa fa-refresh w-4 h-4"></i> </a>
                                <div class="dropdown ml-auto sm:ml-3">
                                    <a href="javascript:;" class="dropdown-toggle w-5 h-5 text-slate-500" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h w-4 h-4"></i> </a>
                                    <div class="dropdown-menu w-40">
                                        <ul class="dropdown-content">
                                        <li>
                                            <a data-cv-id="'.$request->conversation_id.'" href="javascript:;" class="dropdown-item btn_load_members" data-tw-toggle="modal" data-tw-target="#view_conversation_members_modal"> <i class="fa fa-users w-4 h-4 mr-2"></i> Members </a>
                                        </li>
                                        <li>
                                            <a data-cv-id="'.$request->conversation_id.'" href="javascript:;" class="dropdown-item btn_add_new_members" data-tw-toggle="modal" data-tw-target="#chat_modal_add_members_conversation"> <i class="fa fa-user-plus w-4 h-4 mr-2"></i> Add Member </a>
                                        </li>
                                        <li>
                                            <a data-cv-id="'.$request->conversation_id.'" href="javascript:;" class="dropdown-item btn_leave_conversation" data-tw-toggle="modal" data-tw-target="#chat_modal_leave_conversation"> <i class="fa fa-sign-out w-4 h-4 mr-2"></i> Leave </a>
                                        </li>
                                        <li>
                                            <a data-cv-id="'.$request->conversation_id.'" href="javascript:;" class="dropdown-item btn_remove_conversation" data-tw-toggle="modal" data-tw-target="#chat_modal_remove_conversation"> <i class="fa fa-remove w-4 h-4 mr-2"></i> Remove </a>
                                        </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            ';
                }else{

                    $load_header_chat_box = '
                            <div class="w-10 h-10 sm:w-12 sm:h-12 flex-n1`one image-fit relative">
                                <img alt="user-profile-picture" class="rounded-full" data-action="zoom" src="'.get_profile_image(Auth::user()->employee).'">
                                '.user_status(Auth::user()->employee).'
                            </div>
                            <div class="ml-3 mr-auto">
                                <div class="font-medium text-base">'. Str::title($get_conversations->title).'</div>
                                <div class="text-slate-500 text-xs sm:text-sm cursor-pointer">Group Message<span class="mx-1">•</span>Inactive <span class="mx-1">•</span>0 Member(s)</div>
                            </div>
                            <div class="flex items-center sm:ml-auto mt-5 sm:mt-0 border-t sm:border-0 border-slate-200/60 pt-3 sm:pt-0 -mx-5 sm:mx-0 px-5 sm:px-0">
                                <a href="javascript:;" class="w-5 h-5 text-slate-500 ml-5 refresh_conversation_with_id"> <i  class="fa fa-refresh w-4 h-4"></i> </a>
                                <div class="dropdown ml-auto sm:ml-3">
                                    <a href="javascript:;" class="dropdown-toggle w-5 h-5 text-slate-500" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h w-4 h-4"></i> </a>
                                    <div class="dropdown-menu w-40">
                                        <ul class="dropdown-content">
                                        <li>
                                            <a data-cv-id="'.$request->conversation_id.'" href="javascript:;" class="dropdown-item btn_load_members" data-tw-toggle="modal" data-tw-target="#view_conversation_members_modal"> <i class="fa fa-users w-4 h-4 mr-2"></i> Members </a>
                                        </li>
                                        <li>
                                            <a data-cv-id="'.$request->conversation_id.'" href="javascript:;" class="dropdown-item btn_add_new_members" data-tw-toggle="modal" data-tw-target="#chat_modal_add_members_conversation"> <i class="fa fa-user-plus w-4 h-4 mr-2"></i> Add Member </a>
                                        </li>
                                        <li>
                                            <a data-cv-id="'.$request->conversation_id.'" href="javascript:;" class="dropdown-item btn_leave_conversation" data-tw-toggle="modal" data-tw-target="#chat_modal_leave_conversation"> <i class="fa fa-sign-out w-4 h-4 mr-2"></i> Leave </a>
                                        </li>
                                        <li>
                                            <a data-cv-id="'.$request->conversation_id.'" href="javascript:;" class="dropdown-item btn_remove_conversation" data-tw-toggle="modal" data-tw-target="#chat_modal_remove_conversation"> <i class="fa fa-remove w-4 h-4 mr-2"></i> Remove </a>
                                        </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            ';
                }

                $load_footer_chat_box = '
                    <textarea id="textarea_send_the_message" data-cv-id="'.$request->conversation_id.'" class="chat__box__input form-control dark:bg-darkmode-600 h-16 resize-none border-transparent px-5 py-3 shadow-none focus:border-transparent focus:ring-0" rows="1" placeholder="Type your message..."></textarea>
                    <div class="flex absolute sm:static left-0 bottom-0 ml-5 sm:ml-0 mb-5 sm:mb-0">
                        <div class="w-4 h-4 sm:w-5 sm:h-5 relative text-slate-500 mr-3 sm:mr-5">

                        </div>
                    </div>
                    <button id="btn_send_message_onclick" class="w-8 h-8 sm:w-10 sm:h-10 block bg-primary text-white rounded-full flex-none flex items-center justify-center mr-5" data-cv-id="'.$request->conversation_id.'"> <i class="fa fa-paper-plane"></i> </button>
                    ';

            }

            if($get_conversations->chat_messages()->exists()){
                $get_messages = $get_conversations->chat_messages()
                ->selectRaw('id,message_text,user_id,created_at , DATE(created_at) as created_date')
                ->orderByRaw('created_date', 'desc')
                ->get()
                ->groupBy('created_date');

                foreach ($get_messages as $date => $message) {

                    $load_main_view_chat .= '
                            <div class="text-slate-400 dark:text-slate-500 text-xs text-center mb-10 mt-5">' . date('d/M/Y', strtotime($date )). '</div>';
                            foreach($message as $msg){
                                if ($msg->user_id == Auth::user()->employee) {
                                    $load_main_view_chat .= '
                                        <div class="clear-both"></div>
                                        <div class="chat__box__text-box flex items-end float-right mb-4">
                                            <div style="display:none" class="hidden sm:block dropdown mr-3 my-auto">
                                                <a href="javascript:;" class="dropdown-toggle w-4 h-4 text-slate-500" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h w-4 h-4"></i> </a>
                                                <div class="dropdown-menu w-40">
                                                    <ul class="dropdown-content">
                                                        <li>
                                                            <a href="javascript:;" class="dropdown-item"> <i class="fa fa-mail-reply w-4 h-4 mr-2"></i> Reply </a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:;" class="dropdown-item"> <i class="fa fa-trash w-4 h-4 mr-2"></i> Remove </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="bg-primary px-4 py-3 text-white rounded-l-md rounded-t-md">
                                                ' . $msg->message_text . '
                                                <div class="mt-1 text-xs text-white text-opacity-80"><small class="block mt-1">' . $msg->created_at->diffForHumans() . '</small></div>
                                            </div>
                                            <div class="w-10 h-10 hidden sm:block flex-none image-fit relative ml-5">
                                                <img alt="user-profile-picture" class="rounded-full" data-action="zoom" src="'.get_profile_image(Auth::user()->employee).'">
                                            </div>
                                        </div>

                                        <div class="clear-both"></div>
                                    ';

                                } else {
                                    $load_main_view_chat .= '
                                    <div class="chat__box__text-box flex items-end float-left mb-4">

                                        <div class="w-10 hidden sm:block flex-none image-fit relative mr-5">

                                        </div>
                                        <div class=" text-xs text-slate-500 -mb-7"><small class="block mt-1">' .Str::title(fullname($msg->user_id)). '</small></div>
                                    </div>
                                    <div class="clear-both"></div>
                                    <div class="chat__box__text-box flex items-end float-left mt-4 mb-4">
                                        <div class="w-10 h-10 hidden sm:block flex-none image-fit relative mr-5">
                                            <img alt="user-profile-picture" class="rounded-full" data-action="zoom" src="'.get_profile_image($msg->user_id).'">
                                            '.user_status($msg->user_id).'
                                        </div>
                                        <div class="bg-slate-100 dark:bg-darkmode-400 px-4 py-3 text-slate-500 rounded-r-md rounded-t-md">
                                            ' . $msg->message_text . '
                                            <div class="mt-1 text-xs text-slate-500 w-full"><small class="block float-right">' . $msg->created_at->diffForHumans() . '</small></div>
                                        </div>
                                        <div style="display:none" class="hidden sm:block dropdown ml-3 my-auto">

                                            <a href="javascript:;" class="dropdown-toggle w-4 h-4 text-slate-500" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h w-4 h-4"></i> </a>
                                            <div class="dropdown-menu w-40">
                                                <ul class="dropdown-content">
                                                    <li>
                                                        <a href="javascript:;" class="dropdown-item"> <i class="fa fa-mail-reply w-4 h-4 mr-2"></i> Reply </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;" class="dropdown-item"> <i class="fa fa-trash w-4 h-4 mr-2"></i> Remove </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clear-both"></div>

                                    ';
                                    //<div class="mt-1 text-xs text-slate-500">' .Str::title(fullname($msg->user_id)). '</div>

                                    // <div class="flex">
                                    //     <div class="w-3 h-3 image-fit zoom-in">
                                    //         <img alt="profile" class="tooltip rounded-full" src="dist/images/preview-11.jpg" title="Uploaded at 27 October 2021">
                                    //     </div>
                                    //     <div class="w-3 h-3 image-fit zoom-in -ml-10">
                                    //         <img alt="profile" class="tooltip rounded-full" src="dist/images/preview-14.jpg" title="Uploaded at 27 October 2021">
                                    //     </div>
                                    //     <div class="w-3 h-3 image-fit zoom-in -ml-10">
                                    //         <img alt="profile" class="tooltip rounded-full" src="dist/images/preview-2.jpg" title="Uploaded at 27 October 2021">
                                    //     </div>
                                    // </div>

                                }
                            }

                    $load_main_view_chat .= '

                                        ';


                }
            }else{
                $load_main_view_chat = '
                    <div class="clear-both"></div>
                    <div class="text-slate-400 dark:text-slate-500 text-xs text-center mb-10 mt-5">Send a Message!</div>
                    ';

            }

        }

        //mark all messages as read
        $get_chat_view = chat_viewers::where('conversation_id',$request->conversation_id)->where('user_id',Auth::user()->employee)->where('read',0)->get();

        if($get_chat_view){
            foreach($get_chat_view as $read){
                $update_view = [
                    'read' => 1,
                    'seen' => 1,
                ];
                chat_viewers::where(['id' =>  $read->id])->first()->update($update_view);
            }
        }


        return json_encode(array(
            "data"=>$data,
            "load_header_chat_box"=>$load_header_chat_box,
            "load_footer_chat_box"=>$load_footer_chat_box,
            "load_main_view_chat"=>$load_main_view_chat,
        ));

     }

     public function send_conversation_text(Request $request){
        $data = $request->all();
        $expiresAt = now()->addMinutes(1);

        $send_message = [
            'conversation_id' => $request->conversation_id,
            'message_text' => $request->text_message,
            'user_id' => Auth::user()->employee,
            'created_by' => Auth::user()->employee,
        ];

        $chat_message_id = chat_messages::create($send_message)->id;

        $get_conversation = chat_conversation::with('get_members')->where('id',$request->conversation_id)->first();

        if( $get_conversation->get_members()->exists()){
            foreach ($get_conversation->get_members as $key => $member) {
                    $add_view = [
                        'conversation_id' => $request->conversation_id,
                        'message_id' => $chat_message_id ,
                        'user_id' => $member->user_id,
                        'created_by' => Auth::user()->employee,
                    ];
                    $chat_view_id = chat_viewers::create($add_view)->id;

                    Cache::put('msg_sent-' . $member->user_id, $request->conversation_id, $expiresAt);

                event (new load_have_message('msg-sent-'.$member->user_id,$request->conversation_id,$chat_message_id,Auth::user()->employee));

            }

        }
        $update_conversation = [
            'last_sent_by' => Auth::user()->employee,
        ];
        chat_conversation::where(['id' =>  $request->conversation_id])->first()->update($update_conversation);






        // __notification_set(1,'Sent','Message Sent!');
        return json_encode(array(
            "data"=>$data,
        ));
     }

     public function save_new_conversation(Request $request){
        $data = $request->all();

        //create conversation
        $add_conversation = [
            'title' => $request->title,
            'description' => $request->description,
            'conversation_type' => 'group_message',
            'user_id' => Auth::user()->employee,
            'created_by' => Auth::user()->employee,
        ];

        $conversation_id = chat_conversation::create($add_conversation)->id;

        //add me
        $add_new_group_member = [
            'conversation_id' =>  $conversation_id,
            'user_id' => Auth::user()->employee,
            'created_by' => Auth::user()->employee,
            'status' => 'active',
        ];
        $member_id = chat_members::create($add_new_group_member)->id;
        //add every person
        if($request->has('userList')) {

            foreach($request->userList as $key => $user_id){

                $check_if_already_at_the_list = chat_members::where('conversation_id',$conversation_id)->where('user_id',$user_id)->first();

                if(!$check_if_already_at_the_list){
                    $add_new_group_member = [
                        'conversation_id' =>  $conversation_id,
                        'user_id' => $user_id,
                        'created_by' => Auth::user()->employee,
                        'status' => 'active',
                    ];
                    $member_id = chat_members::create($add_new_group_member)->id;
                }

            }

        }


        __notification_set(1,'Conversation','Successfully Created!');
        return json_encode(array(
            "data"=>$data,
            "conversation_id"=>$conversation_id,
        ));
     }

     public function load_all_contacts(Request $request){


        $load_all_contacts = '';
        $profile = tblemployee::with('getUsername')->whereNotNull('firstname')->whereNotNull('lastname')->where('active',1)->whereHas('getUsername')->where('id','!=',Auth::user()->id)->get();

        $grouped = $profile->groupBy(function($item,$key) {
            return ucfirst(strtolower($item->lastname[0]));     //treats the name string as an array
        })
        ->sortBy(function($item,$key){      //sorts A-Z at the top level
                return $key;
        });


        foreach ($grouped as $key => $profiles) {



            $load_all_contacts .= '
            <div class="mt-4 text-slate-500">'.$key.'</div>';

            foreach($profiles as $profile){

                $load_all_contacts .= '<div class="cursor-pointer box relative flex items-center p-5 mt-5 div_load_on_modal" data-us-id="'.$profile->agencyid.'" data-nm-fn="'.Str::title(fullname($profile->agencyid)).'" data-tw-toggle="modal" data-tw-target="#chat_modal_send_message">
                <div class="w-12 h-12 flex-none image-fit mr-1">
                    <img alt="profile" class="rounded-full" data-action="zoom" src="'.get_profile_image($profile->agencyid).'">
                    '.user_status($profile->agencyid).'
                </div>
                <div class="ml-2 overflow-hidden">
                    <div class="flex items-center"> <a href="" class="font-medium">'.Str::title($profile->lastname .' '. $profile->firstname).'</a> </div>
                    <div class="w-full truncate text-slate-500 mt-0.5">'.Carbon::parse($profile->getUsername->last_seen)->diffForHumans().'</div>
                </div>
                <div style="display:none" class="dropdown ml-auto">
                    <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>
                    <div class="dropdown-menu w-40">
                        <ul class="dropdown-content">
                            <li>
                                <a href="" class="dropdown-item"> <i data-lucide="share-2" class="w-4 h-4 mr-2"></i> Share Contact </a>
                            </li>
                            <li>
                                <a href="" class="dropdown-item"> <i data-lucide="copy" class="w-4 h-4 mr-2"></i> Copy Contact </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>';
            }


        }
        // dd($load_all_contacts);

        // __notification_set(1,'Conversation','Successfully Created!');

        return json_encode(array(
            "load_all_contacts"=>$load_all_contacts,
        ));
     }

     public function load_conversation_members(Request $request){
        $data = $request->all();
        $modal_content_members = '';
        $can_remove = '';

        $get_conversations = chat_conversation::with('get_members.getUserinfo','get_im_member','count_message_unseen','chat_messages')->where('id',$request->conversation_id)->first();

        if($get_conversations){



            if($get_conversations->get_members()->exists()){

                    foreach($get_conversations->get_members as $member){
                        $is_admin = '';
                        if($get_conversations->created_by == $member->user_id){
                            $is_admin = '(Admin)';
                        }
                        $last_sent_message = 'No Messages!';
                        $get_last_chat = chat_messages::where('conversation_id',$request->conversation_id)->where('user_id',$member->user_id)->where('active',1)->orderBy('created_at','DESC')->first();
                        if($get_last_chat){
                            $last_sent_message = $get_last_chat->message_text;
                        }
                        if( $get_conversations->created_by == Auth::user()->employee){
                            $can_remove = '
                            <li>
                                <a href="javascript:;" class="dropdown-item remove_person_on_click_history" data-us-id="'.$member->user_id.'" data-cv-id="'.$request->conversation_id.'"> <i data-lucide="copy" class="fa fa-remove w-4 h-4 mr-2"></i> Remove </a>
                            </li>';
                        }

                        $modal_content_members .='
                            <div class="cursor-pointer box relative flex items-center p-3 mt-2">
                                <div class="flex load_chat_div_modal_history" data-us-id="'.$member->user_id.'" data-cv-id="'.$request->conversation_id.'">
                                    <div class="w-12 h-12 flex-none image-fit mr-1">
                                        <img alt="user-profile-picture" class="rounded-full" data-action="zoom" src="'.get_profile_image($member->user_id).'">
                                            '.user_status($member->user_id).'
                                    </div>
                                    <div class="ml-2 overflow-hidden">
                                        <div class="flex items-center "> <a href="javascript:;" class="font-medium truncate w-72">'.Str::title(fullname($member->user_id)).'<span class="text-success"> '.$is_admin.'</span> </a> </div>
                                        <div class=" w-24 truncate text-slate-500 mt-0.5 ">'.$last_sent_message.'</div>
                                    </div>
                                </div>
                                    <div class="dropdown ml-auto">
                                        <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i class="fa fa-ellipsis-h w-5 h-5 text-slate-500"></i> </a>
                                        <div class="dropdown-menu w-40">
                                            <ul class="dropdown-content">

                                                <li>
                                                    <a href="javascript:;" class="dropdown-item load_chat_div_modal_history" data-us-id="'.$member->user_id.'" data-cv-id="'.$request->conversation_id.'"> <i data-lucide="copy" class="fa fa-align-left w-4 h-4 mr-2"></i> History </a>
                                                </li>
                                                '.$can_remove.'
                                            </ul>
                                        </div>
                                    </div>
                            </div>
                            ';
                    }

            }else{
                $modal_content_members .='
                            <div class="cursor-pointer box relative flex items-center p-3 mt-2">
                                <strong>You are the only person on this conversation!</strong>
                            </div>
                            ';
            }

        }



        return json_encode(array(
            "data"=>$data,
            "modal_content_members"=>$modal_content_members,

        ));
     }

     public function add_conversation_new_member(Request $request){
        $data = $request->all();

        return json_encode(array(
            "data"=>$data,

        ));
     }

     public function leave_conversation(Request $request){
        $data = $request->all();

        $send_message = [
            'conversation_id' => $request->conversation_id,
            'message_text' => fullname(Auth::user()->employee).' left the conversation!',
            'user_id' => Auth::user()->employee,
            'created_by' => Auth::user()->employee,
        ];

        $chat_message_id = chat_messages::create($send_message)->id;

        $get_conversation = chat_conversation::with('get_members')->where('id',$request->conversation_id)->first();

        if( $get_conversation->get_members()->exists()){
            foreach ($get_conversation->get_members as $key => $member) {
                    $add_view = [
                        'conversation_id' => $request->conversation_id,
                        'message_id' => $chat_message_id ,
                        'user_id' => $member->user_id,
                        'created_by' => Auth::user()->employee,
                    ];
                    $chat_view_id = chat_viewers::create($add_view)->id;
            }

        }
        $update_conversation = [
            'last_sent_by' => Auth::user()->employee,
        ];
        chat_conversation::where(['id' =>  $request->conversation_id])->first()->update($update_conversation);


        $update_remove_user = [
            'active' => '0',
        ];
        chat_members::where(['conversation_id' =>  $request->conversation_id , 'user_id' =>  Auth::user()->employee])->first()->update($update_remove_user);

        __notification_set(1,'Success!','You left the conversation!');

        $load_default_view
                        = '
                        <div class="h-full flex items-center">
                            <div class="mx-auto text-center">
                                <div class="w-16 h-16 flex-none image-fit rounded-full overflow-hidden mx-auto">
                                    <img alt="user-profile-picture" class="rounded-full" data-action="zoom" src="'.get_profile_image(Auth::user()->employee).'">
                                    '.user_status(Auth::user()->employee).'
                                </div>
                                <div class="mt-3">
                                    <div class="font-medium">Hey, '.fullname(Auth::user()->firstname ).'</div>
                                    <div class="text-slate-500 mt-1">Please select a chat to start messaging.</div>
                                </div>
                            </div>
                        </div>
                        ';

        return json_encode(array(
            "data"=>$data,
            "load_default_view"=>$load_default_view,
        ));
     }

     public function remove_conversation(Request $request){
        $data = $request->all();
        $load_default_view = '';
        $deleted = 0;
        $get_conversation = chat_conversation::where('id',$request->conversation_id)->first();

        if( $get_conversation->created_by == Auth::user()->employee){

            $send_message = [
                'conversation_id' => $request->conversation_id,
                'message_text' => 'Admin removed this conversation!',
                'user_id' => Auth::user()->employee,
                'created_by' => Auth::user()->employee,
            ];

            $chat_message_id = chat_messages::create($send_message)->id;

            $update_remove_conversation = [
                'active' => '0',
            ];
            chat_conversation::where(['id' =>  $request->conversation_id])->first()->update($update_remove_conversation);

            __notification_set(1,'Success!','You removed the conversation!');


            $load_default_view = '
                    <div class="h-full flex items-center">
                        <div class="mx-auto text-center">
                            <div class="w-16 h-16 flex-none image-fit rounded-full overflow-hidden mx-auto">
                                <img alt="user-profile-picture" class="rounded-full" data-action="zoom" src="'.get_profile_image(Auth::user()->employee).'">
                                '.user_status(Auth::user()->employee).'
                            </div>
                            <div class="mt-3">
                                <div class="font-medium">Hey, '.fullname(Auth::user()->employee).'</div>
                                <div class="text-slate-500 mt-1">Please select a chat to start messaging.</div>
                            </div>
                        </div>
                    </div>
                ';
                $deleted = 1;
        }else{

            __notification_set(-3,'Failed!','You are not the admin of this conversation!');
        }




        return json_encode(array(
            "data"=>$data,
            "load_default_view"=>$load_default_view,
            "deleted"=>$deleted,

        ));
     }

     public function load_chat_history(Request $request){
        $data = $request->all();
        $modal_load_history = '';

        $get_messages = chat_messages::where('conversation_id',$request->conversation_id)->where('user_id',$request->user_id)->get();
        if($get_messages->isNotEmpty()){
            foreach($get_messages as $message){
                $modal_load_history .='
                    <div class="clear-both"></div>
                    <div class="chat__box__text-box flex items-end float-right mb-4 ">

                        <div class="bg-primary px-4 py-3 text-white rounded-l-md rounded-t-md">
                            ' . $message->message_text . '
                            <div class="mt-1 text-xs text-white text-opacity-80"><small class="block mt-1">' . $message->created_at->diffForHumans() . '</small></div>
                        </div>
                        <div class="w-10 h-10 hidden sm:block flex-none image-fit relative ml-5">
                            <img alt="user-profile-picture" class="rounded-full" data-action="zoom" src="'.get_profile_image($message->user_id).'">
                        </div>
                    </div>

                    <div class="clear-both"></div>
                ';

            }

        }else{
            $modal_load_history .='
                <div class=" w-full h-full items-center">
                <strong> No Message History!</strong>
            </div>
                ';
        }

        return json_encode(array(
            "data"=>$data,
            "modal_load_history"=>$modal_load_history,
        ));
     }

     public function remove_user_conversation(Request $request){
        $data = $request->all();

        $send_message = [
            'conversation_id' => $request->conversation_id,
            'message_text' => fullname($request->user_id).' has been removed by the admin.',
            'user_id' => Auth::user()->employee,
            'created_by' => Auth::user()->employee,
        ];

        $chat_message_id = chat_messages::create($send_message)->id;

        $get_conversation = chat_conversation::with('get_members')->where('id',$request->conversation_id)->first();

        if( $get_conversation->get_members()->exists()){
            foreach ($get_conversation->get_members as $key => $member) {
                    $add_view = [
                        'conversation_id' => $request->conversation_id,
                        'message_id' => $chat_message_id ,
                        'user_id' => $member->user_id,
                        'created_by' => Auth::user()->employee,
                    ];
                    $chat_view_id = chat_viewers::create($add_view)->id;
            }

        }
        $update_conversation = [
            'last_sent_by' => Auth::user()->employee,
        ];
        chat_conversation::where(['id' =>  $request->conversation_id])->first()->update($update_conversation);


        $update_remove_user = [
            'active' => '0',
        ];
        chat_members::where(['conversation_id' =>  $request->conversation_id , 'user_id' =>  $request->user_id])->first()->update($update_remove_user);

        __notification_set(-3,'Removed','User Successfully Removed!');

        return json_encode(array(
            "data"=>$data,
        ));
     }

     public function add_new_member(Request $request){
        $data = $request->all();


        //add every person
        if($request->has('userList')) {

            foreach($request->userList as $key => $user_id){

                $check_if_already_at_the_list = chat_members::where('conversation_id',$request->conversation_id)->where('user_id',$user_id)->where('active',1)->first();

                if(!$check_if_already_at_the_list){
                    $add_new_group_member = [
                        'conversation_id' =>  $request->conversation_id,
                        'user_id' => $user_id,
                        'created_by' => Auth::user()->employee,
                        'status' => 'active',
                    ];
                    $member_id = chat_members::create($add_new_group_member)->id;

                    $send_message = [
                        'conversation_id' => $request->conversation_id,
                        'message_text' => Str::title(fullname($user_id)).' has been added by '.Str::title(fullname(Auth::user()->employee)).'.',
                        'user_id' => Auth::user()->employee,
                        'created_by' => Auth::user()->employee,
                    ];

                    $chat_message_id = chat_messages::create($send_message)->id;

                    $get_conversation = chat_conversation::with('get_members')->where('id',$request->conversation_id)->first();

                    if( $get_conversation->get_members()->exists()){
                        foreach ($get_conversation->get_members as $key => $member) {
                                $add_view = [
                                    'conversation_id' => $request->conversation_id,
                                    'message_id' => $chat_message_id ,
                                    'user_id' => $member->user_id,
                                    'created_by' => Auth::user()->employee,
                                ];
                                $chat_view_id = chat_viewers::create($add_view)->id;
                        }

                    }
                    $update_conversation = [
                        'last_sent_by' => Auth::user()->employee,
                    ];
                    chat_conversation::where(['id' =>  $request->conversation_id])->first()->update($update_conversation);
                }

            }

        }


        __notification_set(1,'User','User Added Successfully!');
        return json_encode(array(
            "data"=>$data,
        ));
     }

     public function send_message_user(Request $request){
        $data = $request->all();
        $user_id = $request->user_id;
        $conversation_id = '';

        $get_conversations = chat_conversation::with('get_im_member','get_members')->whereHas('get_im_member')
        ->whereHas('get_members', function ($query) use ($user_id) {
            $query->where('user_id',$user_id);})->where('conversation_type','direct_message')->orderBy('created_at', 'DESC')->where('active',1)->first();

        if($get_conversations){

            $conversation_id =  $get_conversations->id;

        }else{
            //create conversation
            $add_conversation = [
                'title' => $request->fullname,
                'description' => 'Direct Message for '.$request->fullname.'.',
                'conversation_type' => 'direct_message',
                'user_id' => Auth::user()->employee,
                'created_by' => Auth::user()->employee,
            ];

            $conversation_id = chat_conversation::create($add_conversation)->id;

            //add me
            $add_new_group_member = [
                'conversation_id' =>  $conversation_id,
                'user_id' => Auth::user()->employee,
                'created_by' => Auth::user()->employee,
                'status' => 'active',
            ];
            chat_members::create($add_new_group_member)->id;

            //add other user
            $add_new_group_member_other = [
                'conversation_id' =>  $conversation_id,
                'user_id' => $user_id,
                'created_by' => Auth::user()->employee,
                'status' => 'active',
            ];
            chat_members::create($add_new_group_member_other)->id;

        }


        $send_message = [
            'conversation_id' => $conversation_id,
            'message_text' => $request->text_message,
            'user_id' => Auth::user()->employee,
            'created_by' => Auth::user()->employee,
        ];

        $chat_message_id = chat_messages::create($send_message)->id;

        $get_conversation = chat_conversation::with('get_members')->where('id',$conversation_id)->first();

        if( $get_conversation->get_members()->exists()){
            foreach ($get_conversation->get_members as $key => $member) {
                    $add_view = [
                        'conversation_id' => $conversation_id,
                        'message_id' => $chat_message_id ,
                        'user_id' => $member->user_id,
                        'created_by' => Auth::user()->employee,
                    ];
                    $chat_view_id = chat_viewers::create($add_view)->id;
            event (new load_have_message('msg-sent-'.$member->user_id,$conversation_id,$chat_message_id,Auth::user()->employee));
            }

        }
        $update_conversation = [
            'last_sent_by' => Auth::user()->employee,
        ];
        chat_conversation::where(['id' =>  $conversation_id])->first()->update($update_conversation);

        __notification_set(1,'Sent','Message Sent Successfully!');

        return json_encode(array(
            "data"=>$data,
            "conversation_id"=>$conversation_id,
            "get_conversations"=>$get_conversations,
        ));
     }

     public function autoload_conversation(Request $request){
        $data = $request->all();
        $conversation_id = Cache::get('msg_sent-'. Auth::user()->employee);
        $action = '';


        if(Cache::has('msg_sent-'. Auth::user()->employee)){
            // __notification_set(1,'Message','You have a message!');
            $action = '1';
            Cache::forget('msg_sent-'. Auth::user()->employee);
        }else{
            $action = '0';
            // __notification_set(1,'Message','No new messages!');
        }

        return json_encode(array(
            "data"=>$data,
            "action"=>$action,
            "conversation_id"=>$conversation_id,

        ));
     }

     public function load_message_id(Request $request){
        $data = $request->all();
        $load_message = '';

        $get_message = chat_messages::where('id',$request->message_id)->first();

        $load_message = '
                    <div id="adminNotification-with-avatar-content-'. $get_message->id.'" class="toastify-content hidden flex">
                        <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                            <img alt="profile" data-action="zoom" src="'.get_profile_image($get_message->created_by).'">
                        </div>
                        <div class="ml-4 mr-4">
                            <div class="font-medium">'.Str::title(fullname($get_message->created_by)).'</div>
                            <div class="text-slate-500 mt-1">'.$get_message->message_text.'</div>

                            <div class="hidden">
                                <div hidden class="search  sm:block">
                                    <input type="text" class="search__input form-control border-transparent" placeholder="Message...">
                                    <i data-lucide="search" class="fa fa-paper-plane dark:text-slate-500 text-primary"></i>
                                </div>
                                <a class="text-primary dark:text-slate-400" href="javascript:;">Reply</a>
                            </div>

                        </div>
                    </div>
            ';

        return json_encode(array(
            "data"=>$data,
            "load_message"=>$load_message,
            "message_id"=>$get_message->id,
        ));
     }

}

