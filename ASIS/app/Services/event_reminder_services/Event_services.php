<?php

namespace App\Services\event_reminder_services;
use App\Models\ASIS_Models\event\event_reminder;
use App\Models\ASIS_Models\event\event_dismiss;
use App\Models\ASIS_Models\event\event_group;
use App\Models\ASIS_Models\posgres\portal\srgb\program;
use App\Models\ASIS_Models\enrollment\enrollment_list;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

Class Event_services
{

    /*Display the list of the program*/
    public function displayProgram()
    {
        $td = [];

        $program = program::select('progcode', 'progdesc')
                            ->latest('progcode')
                            ->get();

        $td = $program->map(function($query){
            return [
                'program' => trim($query->progcode),
                'desc' => trim($query->progdesc)
            ];
        });

         //filter the array for any null value
        $filter_array = array_filter($td->toArray(),function($element){
            return $element!==null;
        });

        if( $filter_array)
        {
            return $td;
        }
    }

    /*Saved the data into the databases*/
    public function savedData($datas)
    {
        try {

            if(!empty($datas))
            {
                $val = [];
                $id = '';
                $filtered_array = '';

                foreach ($datas as $data)
                {
                    $id = $data['id'];
                    $decrypted = '';

                    if($data['id'] === '0' )
                    {
                        $decrypted = 0;
                    } else
                    {
                        $decrypted = Crypt::decryptString($data['id']);
                    }

                    $val = [
                        'title' => $data['title'],
                        'event_desc' => $data['desc'],
                        'title_icon'=>$data['title_icon'],
                        'message_icon'=>$data['message'],
                    ];

                    $saved = event_reminder::UpdateorCreate(['id'=>$decrypted],$val);

                    //filter the array
                    $filtered_array = array_filter($data['group'],function($element){
                        return $element !== null;
                    });

                    if($filtered_array)
                    {
                        foreach($filtered_array as $group)
                        {
                                $group_data = [
                                    'event_id' => $saved->id,
                                    'program_code' => $group
                                ];

                                $saved_group = event_group::UpdateorCreate(['event_id'=>$decrypted,'program_code'=>$group],$group_data);
                                $check = $this->checkGroupData($decrypted,$group,$data['group']);
                        }

                    } else
                    {
                        $check = $this->checkGroupData($decrypted,'',$filtered_array);
                    }
                }

                return true;
            } else
            {
                return false;
            }


        } catch (\DecryptException $e) {
            dd($e);
        }
    }

    /*Check the group for the data*/
    private function checkGroupData($event_id,$progcode,$group)
    {

        if($event_id!==0)
        {
            if(count($group)>0)
            {
                $remove = event_group::Where('event_id',$event_id)
                ->WhereNotIn('program_code',$group)
                ->pluck('id');

                foreach($remove as $delete_id)
                {
                    $delete = event_group::Where('id',$delete_id)->delete();
                }
            } else
            {
                $remove = event_group::Where('event_id',$event_id)
                                    ->Where('active',true)
                                    ->delete();
            }

        }
    }

    /*Retrived  the data*/
    public function getEventList()
    {
        $td = '';
        $event_list = event_reminder::select('id','title','event_desc','status')
                                    ->Where('active',true)
                                    ->get();

        if(!empty($event_list))
        {
            $td = $event_list->map(function($list){
                return [
                    'id' => Crypt::encryptString($list->id),
                    'title' => $list->title,
                    'desc' => $list->event_desc,
                    'status' => $list->status,
                ];
        });
        }

        return $td;
    }

    /*Update the stat*/
    public function updateStat($id,$stat)
    {
        try {
            $decrypted = Crypt::decryptString($id);

            //update the status of the event list
            $update = event_reminder::Where('id',$decrypted)
                                    ->Where('active',true);

            //update the status of the group
            $update_group = event_group::Where('id',$decrypted)
                                        ->Where('active',true);

            if($stat === '0')
            {
                $update->Where('status','0')->update(['status'=>'1']);
                $update_group->Where('status','0')->update(['status'=>'1']);

                //check for existing dissmiss and delete the records
                $check_user_dismiss = event_dismiss::Where('event_id',$decrypted)
                                                    ->Where('active',true)
                                                    ->Where('status',true)
                                                    ->get();

                if(!empty($check_user_dismiss))
                {
                    foreach($check_user_dismiss as $dismiss)
                    {
                        $dismiss->delete();
                    }
                }
            }
            else if ($stat === '1')
            {
                $update->Where('status','1')->update(['status'=>'0']);
                $update_group->Where('status','1')->update(['status'=>'0']);
            }

            return $update;

        } catch (\DecryptException $e) {
            dd($e);
        }
    }

    /*Display notification*/
    public function getNotif()
    {
        if(Auth::user()->studid !== null)
        {
            $td = [];

            $get_notif = event_reminder::with('getProgramCode')
                                        ->Where('status',true)
                                        ->Where('active',true)
                                        ->get();

            $td = $get_notif->map(function($query){

                $studmajor = $query->getProgramCode
                                ->Where('event_id',$query->id)
                                ->Where('status',true)
                                ->Where('active',true)
                                ->Where('program_code',$this->getProgramMajor())
                                ->count()>0;

                $check_event = $query->getProgramCode
                                ->Where('event_id',$query->id)
                                ->Where('program_code','all')
                                ->Where('status',true)
                                ->Where('active',true)
                                ->count()>0;

                if($studmajor)
                {
                    return [
                        'id' => $query->id,
                        'title' => $query->title,
                        'desc' => $query->event_desc,
                        'title_icon' => $query->title_icon,
                        'message_icon' => $query->message_icon,
                        'status' => $query->status,
                        'check_dismiss' =>$this->checkUserDismiss(Auth::user()->studid,$query->id),
                    ];
                }

                if($check_event)
                {
                    return [
                        'id' => $query->id,
                        'title' => $query->title,
                        'desc' => $query->event_desc,
                        'title_icon' => $query->title_icon,
                        'message_icon' => $query->message_icon,
                        'status' => $query->status,
                        'check_dismiss' =>$this->checkUserDismiss(Auth::user()->studid,$query->id),
                    ];
                }
            });

            //filter the array for any null value
            $filter_array = array_filter($td->toArray(),function($element){
                return $element!==null;
            });

            if($filter_array)
            {
                return $td;
            }
        }
    }

    /*Get the program major of the student*/
    private function getProgramMajor()
    {
        $td = [];

         $program = enrollment_list::Where('studid',Auth::user()->studid)
                                    ->first();
         return $program->studmajor?$program->studmajor:'';
    }

    /*Saved the user who view the notif*/
    public function CancelNotif($event_id,$status)
    {
         $data = '';
         $user_id = Auth::user()->studid;
            $data = [
                'user_id' => $user_id,
                'event_id' =>$event_id,
                'status' => $status,
            ];

        $saved = event_dismiss::create($data);

        return $saved;
    }

    /*Check if the user has dismiss the */
    private function checkUserDismiss($user_id,$event_id)
    {
        $check = event_dismiss::Where(function($query) use ($user_id,$event_id){
                                    $query->Where('user_id',$user_id)
                                          ->Where('event_id',$event_id);
                                        })->exists();
        return $check;
    }

    /*Delete the event list in the database*/
    public function deleteEventList($id)
    {
        try {
            if(!empty($id))
            {
                $decrypted = Crypt::decryptString($id);

                $delete_reminder = event_reminder::Where('id',$decrypted)
                                            ->Where('active',true)
                                            ->update(['active'=>false]);

                $delete_dismiss = event_dismiss::GroupBy('event_id')
                                            ->Where('event_id',$decrypted)
                                            ->Where('active',true)
                                            ->update(['active'=>false]);

                $delete_groups = event_group::GroupBy('event_id')
                                            ->Where('event_id',$decrypted)
                                            ->Where('active',true)
                                            ->update(['active'=>false]);
                return true;
            }

            return false;

        } catch (\DecryptException $e) {
            dd($e);
        }
    }

    /*Retrieved the event reminder*/
    public function getEventReminder($id)
    {
        try
        {

            if(!empty($id))
            {
                $td = '';
                $program = [];
                $prog_id = [];

                $decrypted = Crypt::decryptString($id);

                $event = event_reminder::with('getProgramCode')
                                ->select('id', 'title', 'event_desc', 'title_icon', 'message_icon')
                                ->Where('id',$decrypted)
                                ->Where('active',true)
                                ->get();

                $td = $event->map(function($query) use($program,$prog_id) {

                    foreach($query->getProgramCode->Where('active',true) as  $progcode)
                    {
                        $program[] = $progcode->program_code;
                        $prog_id[] = $progcode->id;
                    }

                    return [
                        'id' => Crypt::encryptString($query->id),
                        'title' => $query->title,
                        'event_desc' => $query->event_desc,
                        'title_icon' => $query->title_icon,
                        'message_icon' => $query->message_icon,
                        'group' => [$program],
                        'groupid' => [$prog_id],
                    ];
                });

                return $td;
            }

        } catch (\DecryptException $e) {
            dd($e);
        }
    }
}
