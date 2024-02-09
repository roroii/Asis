<?php

namespace App\Http\Controllers\Pre_Enrollees;

use App\Http\Controllers\Controller;
use App\Mail\NotifyEmail;
use App\Mail\ScheduleMailer;
use App\Models\ASIS_Models\enrollment\enrollment_list;
use App\Models\ASIS_Models\enrollment\enrollment_schedule;
use App\Models\ASIS_Models\enrollment\enrollment_settings;
use App\Models\ASIS_Models\pre_enrollees\enrollees_appointment;
use App\Models\ASIS_Models\pre_enrollees\entrance_examinees;
use App\Models\ASIS_Models\signature\user_signature_model;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class ScheduleController extends Controller
{


    /** ADDITIONAL CONFIGURATION
     *
     * STATUS CODE
     *  7 - COMPLETED
     *  11 - APPROVE
     *  12 - DISAPPROVE
     *  15 - ON-GOING
     *
     */


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

//        $this->middleware('enrollees_auth');

    }

    public function overview()
    {
        return view('pre_enrollees.Schedule.overview');
    }

    public function adminScheduleOverview()
    {
        return view('admin.schedule.overview');
    }

    public function mySchedule()
    {
        return view('pre_enrollees.Schedule.schedule');
    }

    public function adminLoadSchedule(Request $request)
    {

        $enrollmentSchedules = enrollment_schedule::where('active', 1)->get();

        return response()->json($enrollmentSchedules);

    }



    public function save_schedule(Request $request)
    {
        $button_state = $request->button_state;
        if($request->slot_type === 'AM')
        {
            $desc = 'Morning';
        }elseif($request->slot_type === 'PM')
        {
            $desc = 'Afternoon';
        }else
        {
            $desc = null;
        }


        if($button_state === 'Add')
        {

            $active_sem = enrollment_settings::where('description', 'sem')->first();
            enrollment_schedule::updateOrCreate(
                [
                    'date'=> trim($request->schedule_date),
                    'slot_type'     => trim($request->slot_type),
                ],

                [
                    'title'         => trim($request->slot_type),
                    'description'   => $desc,
                    'slot_type'     => trim($request->slot_type),
                    'slots'         => trim($request->input_slots),
                    'date'          => trim($request->schedule_date),
                    'sem'           => $active_sem->key_value,
                    'status'        => 1,
                    'active'        => 1,
                ]
            );

            return json_encode(array(

                'status' => 200,
                'message' => 'Added Successfully!',
            ), JSON_THROW_ON_ERROR);

        }else
        {
            enrollment_schedule::where('id', $request->schedule_id)->update([

                'title'         => trim($request->slot_type),
                'description'   => $desc,
                'slot_type'     => trim($request->slot_type),
                'slots'         => trim($request->input_slots),
                'date'         => trim($request->schedule_date),

            ]);

            return json_encode(array(

                'status' => 200,
                'message' => 'Updated Successfully!',
            ), JSON_THROW_ON_ERROR);
        }
    }
    public function delete_schedule(Request $request)
    {
        enrollment_schedule::where('id', $request->delete_schedule_id)->update([

            'active'  => 0,

        ]);

        return json_encode(array(

            'status' => 200,
            'message' => 'Deleted Successfully!',
        ), JSON_THROW_ON_ERROR);
    }

    public function adminLoadAppointments(Request $request)
    {

        $fullName = 'No Data';
        $description = 'No Data';
        $date = 'No Data';
        $formattedDate = 'No Data';
        $html_data = '';
        $profile_pic = GLOBAL_PROFILE_PICTURE_GENERATOR();
        $empty_photo = url('') . "/dist/images/empty.webp";

        $get_appointees = enrollees_appointment::where('active', 1)
                            ->where('status', 1)
                            ->with(['getEnrolleesInfo', 'getScheduleData'])
                            ->orderBy('created_at', 'desc') // Add this line to sort by 'created_at' in ascending order
                            ->get();

        foreach ($get_appointees as $data)
        {

            if($data->getEnrolleesInfo)
            {
                $first_name = $data->getEnrolleesInfo->firstname;
                $last_name = $data->getEnrolleesInfo->lastname;

                if($data->getEnrolleesInfo->midname)
                {
                    $my_mid_name   = $data->getEnrolleesInfo->midname;
                    $my_mid_name_new = substr($my_mid_name, 0, 1);

                    $mi = $my_mid_name_new.'.';

                }else
                {
                    $mi = '';
                }

                $fullName = $first_name.' '.$mi.' '.$last_name;

            }
            if($data->getScheduleData)
            {
                $description = $data->getScheduleData->description;
                $date = Carbon::parse($data->getScheduleData->date);
                $formattedDate = $date->format('F d, Y');
            }


            $html_data .=
                ' <div data-appointment-id="'.$data->id.'" data-schedule-id="'.$data->schedule_id.'" data-enrollees-id="'.$data->enrollees_id.'" class="intro-x card_activity">
                            <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                    <img alt="Profile_Pic" src="'.$profile_pic.'">
                                </div>
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">'.$fullName.'</div>
                                    <div class="text-slate-500 text-xs mt-0.5">'.$formattedDate.'</div>
                                    <div class="text-slate-500 text-xs mt-0.5 text-pending">Pending</div>
                                </div>
                                <div class="text-pending">'.$description.'</div>
                            </div>
                </div>';

        }

        return json_encode(array(

            'status' => 200,
            'html_data' => $html_data,
            'default_photo' => $empty_photo,
        ), JSON_THROW_ON_ERROR);
    }
    public function approveDisapproveAppointments(Request $request)
    {
        $employee_id = auth()->guard('employee_guard')->user()->employee;
        $appointment_id = trim($request->appointment_id);
        $schedule_id = trim($request->schedule_id);
        $button_state = trim($request->button_state);

        $encrypted_transactionId = Crypt::encrypt($appointment_id);

        /** CONFIGURE EMAIL */
        $pre_enrollees_data = enrollees_appointment::with('getEnrolleesInfo')->where('id', $appointment_id)->first();
        $email_to = $pre_enrollees_data->getEnrolleesInfo->email;
        $email_title = 'Appointment Approved!';
        $message = 'Dear Mr./Ms. '. $pre_enrollees_data->getEnrolleesInfo->lastname.' We are pleased to inform you that your requested appointment schedule has been successfully approved. Your commitment to this process is greatly appreciated.';
        $closing = '';
        $imagePath = '';
        $get_attachments = '';

        $checkSlotsAvailability = enrollment_schedule::where('id', $schedule_id)->first();

        $active_year = enrollment_settings::where('description', 'year')->first()->key_value;
        $active_sem = enrollment_settings::where('description', 'sem')->first()->key_value;

        if($button_state === 'APPROVE')
        {
            if((!$checkSlotsAvailability->slots) < 1 || !$checkSlotsAvailability->slots === 0)
            {

                $available_slots = $checkSlotsAvailability->slots - 1;


                /** UPDATE ENROLLMENT SCHEDULE SLOTS*/
                enrollment_schedule::where('id', $schedule_id)->update([

                    'slots' => $available_slots,

                ]);

                /** UPDATE APPOINTMENT TABLE*/
                enrollees_appointment::where('id', $appointment_id)->update([

                    'status' => 11,
                    'action' => 15,
                    'signatory' => $employee_id,

                ]);


                /** INSERT/UPDATE ENTRANCE EXAMINEES LIST*/
                entrance_examinees::updateOrCreate(
                    [
                        'appointment_id'    => $appointment_id,
                        'transaction_id'    => trim($pre_enrollees_data->transaction_id),
                        'enrollees_id'      => trim($pre_enrollees_data->enrollees_id),
                        'schedule_id'       => trim($pre_enrollees_data->schedule_id),
                    ],

                    [
                        'appointment_id'    => $appointment_id,
                        'transaction_id'    => trim($pre_enrollees_data->transaction_id),
                        'enrollees_id'      => trim($pre_enrollees_data->enrollees_id),
                        'schedule_id'       => trim($pre_enrollees_data->schedule_id),
                        'status'            => 1,      /** 1 means PENDING  */
                        'year'              => $active_year,
                        'sem'               => $active_sem,
                        'active'            => 1,       /** 1 means Active  */
                    ]
                );



                try {

                    /** SEND EMAIL TO THE PRE-ENROLLEES */
                    Mail::to($email_to)->queue(new ScheduleMailer($email_title,$message, $closing, $encrypted_transactionId));

//                    Mail::to($email_to)->send(new ScheduleMailer($email_title,$message, $closing, $encrypted_transactionId));

                    // Email sent successfully
                    // You can add any additional logic you need here
                    return json_encode(array(

                        'status' => 'success',
                        'title' => 'Success!',
                        'status_code' => -1,
                        'message' => 'Approved Successfully!',

                    ), JSON_THROW_ON_ERROR);

                }
                catch (\Exception $e)
                {
                    // Email sending failed
                    // Log or handle the exception as needed
                    echo 'Error sending email: ' . $e->getMessage();
                }

            }
            else
            {
                return json_encode(array(

                    'status' => 'warning',
                    'title' => 'Oops!',
                    'status_code' => -1,
                    'message' => 'No available slots!',
                ), JSON_THROW_ON_ERROR);
            }

        }
        elseif($button_state === 'DISAPPROVE')
        {
            enrollees_appointment::where('id', $appointment_id)->update([

                'status' => 12,
                'action' => 12,

            ]);


            entrance_examinees::where('transaction_id', $pre_enrollees_data->transaction_id)
                ->where('enrollees_id', $pre_enrollees_data->enrollees_id)
                ->update([

                'status' => 12,
                'action' => 12,

            ]);


            return json_encode(array(

                'status' => 'success',
                'title' => 'Success!',
                'status_code' => -1,
                'message' => 'Appointment has been disapproved successfully!',
            ), JSON_THROW_ON_ERROR);
        }

    }
    public function searchNameAppointments(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
        $fullName = 'No Data';
        $description = 'No Data';
        $date = 'No Data';
        $formattedDate = 'No Data';
        $html_data = '';
        $profile_pic = GLOBAL_PROFILE_PICTURE_GENERATOR();
        $empty_photo = url('') . "/dist/images/empty.webp";

        $get_appointees = enrollees_appointment::where('active', 1)
                        ->where('status', 1)
                        ->whereHas('getEnrolleesInfo', function ($query) use ($searchTerm) {
                            $query->where('firstname', 'LIKE', "%$searchTerm%")
                                ->orWhere('midname', 'LIKE', "%$searchTerm%")
                                ->orWhere('lastname', 'LIKE', "%$searchTerm%");
                        })
                        ->with(['getEnrolleesInfo', 'getScheduleData'])
                        ->orderBy('created_at', 'desc') // Add this line to sort by 'created_at' in ascending order
                        ->get();

        foreach ($get_appointees as $data)
        {

            if($data->getEnrolleesInfo)
            {
                $first_name = $data->getEnrolleesInfo->firstname;
                $last_name = $data->getEnrolleesInfo->lastname;

                if($data->getEnrolleesInfo->midname)
                {
                    $my_mid_name   = $data->getEnrolleesInfo->midname;
                    $my_mid_name_new = substr($my_mid_name, 0, 1);

                    $mi = $my_mid_name_new.'.';

                }else
                {
                    $mi = '';
                }

                $fullName = $first_name.' '.$mi.' '.$last_name;

            }
            if($data->getScheduleData)
            {
                $description = $data->getScheduleData->description;
                $date = Carbon::parse($data->getScheduleData->date);
                $formattedDate = $date->format('F d, Y');
            }


            $html_data .=
                ' <div data-appointment-id="'.$data->id.'" data-schedule-id="'.$data->schedule_id.'" data-enrollees-id="'.$data->enrollees_id.'" class="intro-x card_activity">
                            <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                    <img alt="Profile_Pic" src="'.$profile_pic.'">
                                </div>
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">'.$fullName.'</div>
                                    <div class="text-slate-500 text-xs mt-0.5">'.$formattedDate.'</div>
                                    <div class="text-slate-500 text-xs mt-0.5 text-pending">Pending</div>
                                </div>
                                <div class="text-pending">'.$description.'</div>
                            </div>
                </div>';

        }

        return json_encode(array(

            'status' => 200,
            'html_data' => $html_data,
            'default_photo' => $empty_photo,
        ), JSON_THROW_ON_ERROR);
    }





//    STUDENT SUBMIT APPOINTMENT
    public function submit_appointment(Request $request)
    {
        $enrollees_id = auth()->guard('enrollees_guard')->user()->pre_enrollee_id;
        $schedule_id = trim($request->confirm_scheduled_date_id);

        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;
        $transaction_id = uniqid($year.'-'.$month.'-', false);


        $check_submitted_appointment = enrollees_appointment::where('enrollees_id', $enrollees_id)->
                                                              where('schedule_id', $schedule_id)
                                                              ->first();

        $check_pending_appointment = enrollees_appointment::where('enrollees_id', $enrollees_id)->
                                                            where('status', 1)->get();

        $check_approved_appointment = enrollees_appointment::where('enrollees_id', $enrollees_id)->
                                                             where('status', 11)->
                                                             where('action', 15)->get();

        $check_completed_appointment = enrollees_appointment::where('enrollees_id', $enrollees_id)->
                                                             where('status', 11)->
                                                             where('action', 7)->get();

        $has_completed_appointment = false;
        foreach ($check_completed_appointment as $data)
        {
            if($data)
            {
                $has_completed_appointment = true;
            }
        }

        if ($has_completed_appointment)
        {
            enrollees_appointment::updateOrCreate(
                [
                    'enrollees_id'  => $enrollees_id,
                    'schedule_id'   => $schedule_id,
                ],

                [
                    'transaction_id'  => $transaction_id,
                    'enrollees_id'  => $enrollees_id,
                    'schedule_id'   => $schedule_id,
                    'status'        => 1,
                    'active'        => 1,
                ]
            );

            return json_encode(array(

                'status' => 'success',
                'title' => 'Success!',
                'status_code' => -1,
                'message' => 'Appointment submitted Successfully!',
            ), JSON_THROW_ON_ERROR);
        }


        $has_pending_appointment = false;
        foreach ($check_pending_appointment as $data)
        {
            if($data)
            {
                $has_pending_appointment = true;
            }
        }

        $has_approved_appointment = false;
        foreach ($check_approved_appointment as $data)
        {
            if($data)
            {
                $has_approved_appointment = true;
            }
        }


        if($has_approved_appointment)
        {
            return json_encode(array(

                'status' => 'warning',
                'title' => 'Ooops!',
                'status_code' => -1,
                'message' => 'You have an existing appointment, please proceed to the next step!',
            ), JSON_THROW_ON_ERROR);

        }


        if($has_pending_appointment)
        {
            return json_encode(array(

                'status' => 'warning',
                'title' => 'Ooops!',
                'status_code' => -1,
                'message' => 'You have already submitted an appointment! Please wait for Approval',
            ), JSON_THROW_ON_ERROR);

        }
        else
        {
            if($check_submitted_appointment)
            {
                return json_encode(array(

                    'status' => 'warning',
                    'title' => 'Ooops!',
                    'status_code' => -1,
                    'message' => 'You have already made an appointment on this date, please proceed to the next step!',
                ), JSON_THROW_ON_ERROR);

            }else
            {
                enrollees_appointment::updateOrCreate(
                    [
                        'enrollees_id'  => $enrollees_id,
                        'schedule_id'   => $schedule_id,
                    ],

                    [
                        'transaction_id'  => $transaction_id,
                        'enrollees_id'  => $enrollees_id,
                        'schedule_id'   => $schedule_id,
                        'status'        => 1,
                        'active'        => 1,
                    ]
                );

                return json_encode(array(

                    'status' => 'success',
                    'title' => 'Success!',
                    'status_code' => -1,
                    'message' => 'Appointment submitted Successfully!',
                ), JSON_THROW_ON_ERROR);

            }

        }

    }

    public function userLoadSchedule(Request $request)
    {

        $currentDateTime = Carbon::now();
        $nextDayDateTime = $currentDateTime->copy()->addDay();
        $amPm = $currentDateTime->format('A'); // Get AM or PM


        if ($amPm === 'AM')
        {
            $enrollmentSchedules = enrollment_schedule::where('active', 1)
                ->whereMonth('date', $currentDateTime->month)
                ->whereYear('date', $currentDateTime->year)
                ->where(function ($query) use ($amPm, $nextDayDateTime, $currentDateTime) {

                    $query->where('date', '>=', $currentDateTime->toDateString())
                          ->orWhere('date', '>=', $nextDayDateTime->startOfDay()); // For tomorrow and beyond
                })
                ->get();

        }else{

            $enrollmentSchedules = enrollment_schedule::where('active', 1)
                ->whereMonth('date', $currentDateTime->month)
                ->whereYear('date', $currentDateTime->year)
                ->where(function ($query) use ($amPm, $nextDayDateTime, $currentDateTime) {

                    $query->where('date', '>=', $currentDateTime->toDateString())
                          ->where('slot_type', 'LIKE', '%' . $amPm)
                          ->orWhere('date', '>=', $nextDayDateTime->startOfDay()); // For tomorrow and beyond
                })
                ->get();
        }



        return response()->json($enrollmentSchedules);

    }
}
