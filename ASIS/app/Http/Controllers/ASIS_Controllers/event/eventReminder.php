<?php

namespace App\Http\Controllers\ASIS_Controllers\event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\event_reminder_services\Event_services;

class eventReminder extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view('events.reminder');
    }

    /*Display the list of the program*/
    public function displayProgram()
    {
        try
        {
            $event = new Event_services();
            $program = $event->displayProgram();

            return json_encode($program);

        }catch(\Exception $e)
        {
            dd($e);
        }
    }

    /*Saved the data*/
    public function saveEventReminder(Request $request)
    {
        try{

            $data = $request->data;

            $event = new Event_services();
            $saved = $event->savedData($data);

            if($saved)
            {
                return response()->json([
                    'status' => true,
                    'message' => 'Successfully Saved'
                ]);
            }else
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Unable to saved please try again'
                ]);
            }
        }catch(\Exception $e)
        {
            dd($e);
        }
    }

    /*Display the data*/
    public function getEventReminder()
    {
        try
        {
            $event = new Event_services();
            $event_list = $event->getEventList();

            return json_encode($event_list);

        }catch(\Exception $e)
        {
            dd($e);
        }
    }

    /*Update the status*/
    public function updateStat(Request $request)
    {
        try
        {
            $id = $request->id;
            $stat = $request->stat;

            $event = new Event_services();
            $update_stat = $event->updateStat($id,$stat);

            if($update_stat)
            {
                return response()->json([
                    'status' => true,
                    'message' => 'Successfully updated'
                ]);
            }
            else
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Unable to update please try again'
                ]);
            }

        }
        catch(\Exception $e)
        {
            dd();
        }
    }

    /*Display the notification*/
    public function getNotification()
    {
        try
        {
            $event = new Event_services();
            $notif = $event->getNotif();

            return json_encode($notif);

        }
        catch(\Exception $e)
        {
            dd($e);
        }
    }

    /*Saved the User who view the notif*/
    public function SavedUserView(Request $request)
    {
        try
        {
            $id = $request->id;
            $stat = $request->stat;
            $event = new Event_services();

            $savedNotif = $event->CancelNotif($id,$stat);

            return response()->json([
                'status' => true,
                'message' => 'Successfully Clear'
            ]);
        }
        catch(\Exception $e)
        {
            dd($e);
        }
    }

    /*Remove the event from the list*/
    public function deleteEventList(Request $request)
    {
        try
        {
            $id = $request->id;

            $event = new Event_services();
            $delete = $event->deleteEventList($id);

            if($delete === true)
            {
                return response()->json([
                    'status' => true,
                    'message' => 'Successfully Delete'
                ]);
            }
            else
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Unable to delete please try again later'
                ]);
            }
        }catch(\Exception $e)
        {
            dd($e);
        }
    }

    /*Retrieve the event in the list*/
    public function getEventReminderList(Request $request)
    {
        try
        {
            $id = $request->id;

            $event = new Event_services();
            $get_event = $event->getEventReminder($id);

            return json_encode($get_event);

        }catch(\Exception $e)
        {
            dd($e);
        }
    }
}
