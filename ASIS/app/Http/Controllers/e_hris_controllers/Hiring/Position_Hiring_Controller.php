<?php

namespace App\Http\Controllers\Hiring;

use App\Http\Controllers\Controller;
use App\Models\applicant\applicants_academic_bg;
use App\Models\Hiring\tbl_job_doc_requirements;
use App\Models\PDS\pds_child_list;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Hiring\tbljob_info;
use App\Models\Hiring\tbljob_doc_rec;
use App\Models\Hiring\tbleduc_req;
use App\Models\Hiring\tbl_shortlisted;
use App\Models\Hiring\tblpanels;
use App\Models\Hiring\tbl_competency_skills;
use App\Models\Hiring\tbl_step;
use App\Models\Hiring\tbl_position;
use App\Models\Hiring\tbl_competencies_list;
use App\Models\doc_notification;
use App\Models\tblemployee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\position_hiring;
use App\Exports\allpositionExport;
use PDF;

use App\Services\ExcelServices;

class Position_Hiring_Controller extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index()
    {
        return view('hiring_blade.hiring');
    }

    //retrieve the monthly salary
    public function get_monthly_salaries(Request $request)
    {
        try
        {
            $get_salarys = '';

            $get_salarys = tbl_step::where('sg_id',$request->sg)->where('stepnum',$request->step )->first();
            $amount = $get_salarys -> amount;

            return response()->json([
                'status' => true,
                'message' => $amount,
            ]);
        }
        catch(Exception $e)
        {
            $message = $e->getMessage();
            var_dump('Exception Message: '. $message);

            $code = $e->getCode();
            var_dump('Exception Code: '. $code);

            $string = $e->__toString();
            var_dump('Exception String: '. $string);
        }
    }

    //dave the data in the position hiring
    public function position_hiring(Request $request)
    {

        try{

              //use the date now to as referrence for the generated id
              $date = Carbon::now()->format('d-m-y');

             //responsible for generating an id
             $id = $this->IDGenerator(new tbljob_info,'jobref_no',4,$date);

        $data = [
            'jobref_no' => $id,
            'assign_agency' => $request -> assign,
            'pos_title' => $request -> position_title,
            'sg' => $request -> salarygrade,
            'step' =>$request-> step,
            'salary' => $request -> monthly_salary,
            'pos_type' => $request -> position_type,
            'post_date' => $request->post_date,
            'close_date' => $request->close_date,
            'email_add' => $request->email_ad,
            'address' => $request->address,
            'email_through' => $request->hrmo,
            'status' => '13'
             ];

        $doc_req = [
            'job_info_no' => $id,
            'item_no' => $request -> item_no,
            'eligibility' => $request -> eligibility,
            'educ' => $request -> education,
            'work_ex' => $request -> work_ex,
            'competency' => $request ->competency,
            'training' => $request ->training
        ];

        $job_info = tbljob_info::create($data);
        $saved_doc = $this->saved_doc_rec($id,$request->remarks,$request->doc_req);
        $job_doc_requirements = $this->saved_job_doc_requirements($id,$request->td_doc_requirement,$request->td_doc_requirement_type);
        $ratees = $this->saved_ratees($id,$request->ratees,$job_info->jobref_no,$request->position_title);
        $educ_req = tbleduc_req::create($doc_req);
        $saved_comp = $this->save_competencies_list($request->temp_var,$id);
        $saved_doc;

            return response()->json([
                'status' => true,
                'message' => 'Successfully Saved']);


        }catch(Exception $e)
        {
            dd($e);
        }

    }

    public function saved_job_doc_requirements($id,$doc_requirements,$doc_type)
    {
        $temp_data = $doc_requirements;
        $temp_data1 = $doc_type;

        for($i=0;$i<count($doc_requirements);$i++)
        {
            $saved_doc_requirements = tbl_job_doc_requirements::create([
                'job_info_no' => $id,
                'doc_requirements' => $temp_data[$i],
                'doc_type' => $temp_data1[$i],
                'active' => true,
            ]);
        }
    }

    private function saved_doc_rec($id,$remark,$doc)
    {
        $data = [
            'job_ref' => $id,
            'remarks' => $remark,
        ];

        $saved_doc = tbljob_doc_rec::create($data);

        return $saved_doc;
    }

    //save competencies
    private function save_competencies_list($comp,$id)
    {
        try
        {
            $data = '';

            for($i=0;$i<count($comp);$i++)
            {
                if($comp[$i] != null)
                {
                    $data = [
                        'job_ref' => $id,
                        'comp_list' => $comp[$i]
                    ];

                    $saved = tbl_competencies_list::create($data);
                }
            }

        }catch(Throwable $e)
        {
            dd($e);
        }
    }
    //get the competencies
    public function get_competencies_list(Request $request)
    {
        try
        {
            $get_comp = '';
            $temp_data = [];
            $comp = tbl_competencies_list::where('job_ref',$request->ref_num)->where('active',true)->get();

            foreach($comp as $comps)
            {
                $td = [
                    'comp_list' => $comps->comp_list,
                    'id' => $comps->id
                ];

                $temp_data[count($temp_data)]=$td;
            }
            echo json_encode($temp_data);

        }catch(Throwable $e)
        {
            dd($e);
        }
    }

    //saved the panels and add adminNotification
    private function saved_ratees($id,$panels,$hiring_id,$pos)
    {
        $notif = '';
        $position = get_position_title($pos);
        $message = 'You have been appointed as one of the panel memeber for the upcoming interview of the position hiring of'.' '.$position->emp_position.'.';

        if($panels!=null)
        {
            foreach($panels as $panel)
            {
                $saved_panel = tblpanels::create([
                    'available_ref' => $id,
                    'panel_id' => $panel
                ]);
               createNotification('hiring',$hiring_id,'user', auth()->user()->employee,$panel,'user',$message);
            }
        }
    }

    //get the different panels in the position
    public function get_panels(Request $request)
    {
        $ref_num = $request->id;
        $temp = [];
        $panels = tblpanels::where('available_ref',$ref_num)->where('active',true)->get(['panel_id']);

        foreach($panels as $panel)
        {
            $td = [
                'get_panel' => $panel->panel_id,
            ];
            $temp[count($temp)]=$td;
        }

        echo json_encode($temp);
    }

    //get the competency
    public function get_competencies(Request $request)
    {
        try
        {
            $id = $request->competency_id;
            if($id!="")
            {
                $retrieve_competency = tbl_competency_skills::where('skillid',$id)->where('active','1')->get(['skill']);
                echo ($retrieve_competency);
            }
        }
        catch(Exception $e)
        {
            dd($e);
        }
    }

    //generate an id for the position
    private static function IDGenerator($model,$trow,$lenght,$prefix)
    {
        $data = $model::orderBy('id','desc')->first();
        if(!$data)
        {
            $log_length = $lenght;
            $last_number = '';
        } else{
            $code = substr($data->$trow, strlen($prefix)+1);
            $actual_last_number = ($code/1)*1;
            $increment_last_number = $actual_last_number+1;
            $last_number_length = strlen($increment_last_number);
            $log_length = $lenght - $last_number_length;
            $last_number = $increment_last_number;
        }
        $zeros = "";
        for($i=0;$i<$log_length;$i++)
        {
            $zeros.="0";
        }
        return $prefix.'-'.$zeros.$last_number;
    }

     //change the date format to number
     private function change_date_format($request)
     {
         $date =  Carbon::createFromFormat('j M, Y',$request)->format('Y/m/d');
         return $date;
     }

     //update the position hiring
     public function update_data(Request $request)
     {
        try
        {
            // $post = convert_date($request->post_date);
            // $close = convert_date($request->close_date);

            // dd($post,
            // $close);

                $update_job = [
                    'assign_agency' => $request-> agencys,
                    'pos_title' => $request-> position_titles,
                    'salary' => $request->monthly_salarys,
                    'sg' => $request-> salarygrades,
                    'step' => $request-> step,
                    'pos_type' => $request-> position_types,
                    'post_date' => $request->post_dates,
                    'close_date' => $request->close_dates,
                    'email_through' => $request->hrmo,
                    'email_add' => $request->email_add,
                    'address' => $request->address,
                ];

                $datas = [
                    'item_no' => $request->plantilla,
                    'eligibility' => $request->eligibility,
                    'educ' => $request->education,
                    'work_ex' => $request->work,
                    'competency' => $request->competency,
                    'training' => $request->training,
                ];


                $update = tbljob_info::where('id',$request->ids)->where('active','1')->update($update_job);
                $update_data = tbleduc_req::where('job_info_no',$request->ref_num)->where('active','1')->update($datas);
                $updated = $this->update_doc_rec($request->remarks,$request->ref_num);
                $update_doc_requirement = $this->update_job_doc_requirements($request->ref_num,$request->td_doc_requirement,$request->td_doc_requirement_type);
                $update_panel = $this->update_panels($request->panels,$request->ref_num,$request->position_titles);
                $update_competency_list = $this->update_competencies_list($request->ref_num,$request->temp_var,$request->temp_id);

                return response()->json([
                    'status' => true,
                    'message' => 'Successfully Update'
                ]);

        }catch(Exception $e)
        {
            dd($e);
        }
     }

     //update the remarks
     private function update_doc_rec($remarks,$id)
     {
        $update_rec =[
            'remarks' => $remarks,
        ];

        $updated = tbljob_doc_rec::where('job_ref',$id)->where('active','1')->update($update_rec);
     }

     //update the documents requirements
     private function update_job_doc_requirements( $id,$doc_req,$doc_type)
     {
        $temp1=$doc_req;
        $temp2=$doc_type;

        if($doc_req != '' && $doc_type != '' )
        {
            $delete = tbl_job_doc_requirements::where('job_info_no',$id)->where('active',true)->delete();
            for($i=0;$i<count($doc_req);$i++)
            {
                tbl_job_doc_requirements::create([
                    'job_info_no' => $id,
                    'doc_requirements' => $temp1[$i],
                    'doc_type' => $temp2[$i],
                    'active' => '1'
                ]);
            }
        }
     }

     //update the competencies list
     private function update_competencies_list($id,$comp,$temp_id)
     {
        try
        {

            $temp = [];

            // for($i=0;$i<count($comp);$i++)
            // {
            //     if(($comp[$i]!=null && $id!=null) && $temp_id[$i]!=null)
            //     {
            //         $data = [
            //             'job_ref' => $id,
            //             'comp_list' => $comp[$i]
            //         ];

            //         if($temp_id[$i] == 0 )
            //         {
            //             $saved = tbl_competencies_list::create($data);
            //         }
            //         else
            //         {
            //             $get_comp_id = tbl_competencies_list::where('job_ref', $id)->whereNotIn('id',$temp_id)->pluck('id');

            //             if($get_comp_id)
            //             {
            //                 for($c=0;$c<count($get_comp_id);$c++)
            //                 {
            //                     $saved = tbl_competencies_list::where('id',$get_comp_id[$c])->update(['active' => false]);
            //                 }
            //             }
            //         }
            //     }
            // }

            for($i=0;$i<count($comp);$i++)
            {
                $check_if_exist = tbl_competencies_list::where('job_ref',$id)->where('id',$temp_id[$i])->where('active',true)->exists();
                $check_all_if_exist = tbl_competencies_list::where('job_ref',$id)->where('active',true)->whereNotIn('id',$temp_id)->pluck('id');

                if(!$check_all_if_exist)
                {
                    if(!$check_if_exist)
                    {
                        for($q=0;$q<count($temp_id);$q++)
                        {
                            if($temp_id[$q] == 0 )
                            {
                                $data = [
                                    'job_ref' => $id,
                                    'comp_list' => $comp[$q]
                                ];

                                $saved = tbl_competencies_list::create($data);
                            }
                        }
                    }
                    else
                    {
                        $get_comp_id = tbl_competencies_list::where('job_ref', $id)->whereNotIn('id',$temp_id)->pluck('id');

                        if($get_comp_id)
                        {
                            for($c=0;$c<count($get_comp_id);$c++)
                            {
                                $saved = tbl_competencies_list::where('id',$get_comp_id[$c])->update(['active' => false]);
                            }
                        }
                    }

                } else
                {
                    for($x=0;$x<count($check_all_if_exist);$x++)
                    {
                        $update = tbl_competencies_list::where('id',$check_all_if_exist[$x])->where('job_ref',$id)->where('active',true)->update(['active'=>false]);
                    }

                    for($z=0;$z<count($temp_id);$z++)
                    {
                        if($temp_id[$z] == 0 )
                        {
                            $data = [
                                'job_ref' => $id,
                                'comp_list' => $comp[$z]
                            ];

                            $saved = tbl_competencies_list::create($data);
                        }
                    }
                }
            }

        }
        catch(Throwable $e)
        {
            dd($e);
        }
     }

     //update the panels ============================================================================================================
     private function update_panels($panels,$id,$pos_id)
     {
        $get_position = get_position_title($pos_id);
        $messages = 'You have been appointed as one of the panel memeber for the upcoming interview of the position hiring of'.' '.$get_position->emp_position.'.';
        $remove = 'You have been remove as a panel member for the upcoming interview for the position hiring of '.' '.$get_position->emp_position.'.';

        if($panels)
        {
            for($i=0;$i<count($panels);++$i)
            {
                $get_panels = tblpanels::where('available_ref',$id)->where('panel_id',$panels[$i])->exists();

                if($get_panels)
                {
                    $check_panel = tblpanels::where('available_ref',$id)->where('panel_id',$panels[$i])
                                    ->where('active',false)->get();

                    if($check_panel)
                    {
                        foreach($check_panel as $panel)
                        {
                            $update = tblpanels::where('available_ref',$panel->available_ref)->where('panel_id',$panel->panel_id)->update(['active' => true]);
                            createNotification('hiring',$id,'user', auth()->user()->employee,$panel->panel_id,'user',$messages);
                        }
                    }
                    //remove
                    $check_panels = tblpanels::where('available_ref',$id)->whereNotIn('panel_id',$panels)->where('active',1)->pluck('panel_id');
                    if( $check_panels){
                        foreach($check_panels as $gasd){
                            $check = tblpanels::where('available_ref',$id)->where('panel_id',$gasd)->where('active',1)->update(['active' => '0']);
                            createNotification('hiring',$id,'user', auth()->user()->employee,$gasd,'user',$remove);
                        }
                    }
                }
                else
                {
                    $save_panel = tblpanels::create(['available_ref' => $id, 'panel_id' => $panels[$i]]);
                    createNotification('hiring',$id,'user', auth()->user()->employee,$panels[$i],'user',$messages,);
                }

            }
        }
        else
        {
            $get_panelists = tblpanels::where('available_ref',$id)->where('active',true)->get();
            foreach($get_panelists as $panelist)
            {
                createNotification('hiring',$id,'user', auth()->user()->employee,$panelist->panel_id,'user',$remove);
                $delete = tblpanels::where('available_ref',$id)->update(['active' => '0']);
            }

        }
     }

     // Responsible for the Deletion of data ==================================================================================

     public function delete_data(Request $request)
     {
        $delete =tbljob_info::where('id',$request->id)->update([
            'active' => '0'
        ]);

        return response()->json([
            'status' => true,
        ]);
     }

     // check the status if the position can be open or not base on the date ==================================================================================
     public function change_status(Request $request)
     {
        $post_date = $this->change_date_format($request->posting_date);
        $close_date = $this->change_date_format($request->closing_date);

        $currentTime = date('Y/m/d');
        $datetime = Carbon::createFromFormat('Y/m/d', $currentTime);
        $datetime->setTimezone('Asia/Manila');
        $current_date = $datetime->format('Y/m/d');

        if($request->close == 'Close')
        {
            if($request->position_status == 'Available' )
            {
                $delete_stat = tbljob_info::where('id',$request->id)->update([
                    'status' => '14'
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Successfully close the position'
                ]);
            }
        }
        else if($request->close == 'Open')
        {
            if($request->position_status == 'Closed')
            {
                if($post_date < $current_date)
                {
                    if($close_date <= $current_date)
                    {
                        return response()->json([
                            'status' => false,
                            'message' => 'Make sure the posting and closing date are inline with the current date'
                        ]);
                    }
                }
                if($post_date <= $current_date)
                {
                    if($close_date > $current_date)
                    {
                        $delete_stat = tbljob_info::where('id',$request->id)->update([
                            'status' => '13'
                        ]);

                        return response()->json([
                            'status' => true,
                            'message' => 'Successfully open the position'
                        ]);
                    }
                }
                else if($post_date >= $current_date)
                {
                    if($close_date > $current_date)
                    {
                        $delete_stat = tbljob_info::where('id',$request->id)->update([
                            'status' => '1'
                        ]);

                        return response()->json([
                            'status' => false,
                            'message' => 'This position is pending due to the post date that hast been started yet'
                        ]);
                    }
                }
            }
            else if($request->position_status == 'Pending')
            {
                if($post_date > $current_date)
                {
                    return response()->json([
                        'status' => false,
                        'message' => 'Make sure to check the date first'
                    ]);
                }
                else if($post_date <= $current_date)
                {
                    if($close_date > $current_date)
                    {
                        $delete_stat = tbljob_info::where('id',$request->id)->update([
                            'status' => '13'
                        ]);

                        return response()->json([
                            'status' => true,
                            'message' => 'Successfully open the position'
                        ]);

                    }

                } if (($post_date < $current_date) && ($close_date < $current_date))
                {
                    $delete_stat = tbljob_info::where('id',$request->id)->update([
                        'status' => '14'
                    ]);

                    return response()->json([
                        'status' => true,
                        'message' => 'This position will be closed due to obsolete date'
                    ]);
                }
            }
        }
     }


     // load the data table =============================================================================

     public function load_hiring_data(Request $request)
     {
        try
        {
            $data = $this->load_data($request->filter);
            $load_datas = [];

            foreach( $data as $datas)
            {
                $position = $this->getPosition($datas);

                $check_posting_date = $this->check_posting_date($datas->id,$datas->post_date,$datas->close_date,$datas->status);

                if($check_posting_date == true || $check_posting_date == false )
                {
                    $check_position = $this->get_job_profile($datas->id,$datas->post_date,$datas->close_date,$datas->status);
                    $notif_color = $this->change_notif_color($datas->id,$datas->post_date,$datas->close_date,$datas->status);

                    foreach($position as $get_position)
                    {
                        $education = $this->getJob_doc($datas);

                        foreach($education as $get_educ)
                        {
                            $pos_type = $this->getPosition_type($datas);

                            foreach($pos_type as $pos_types)
                            {
                                $doc_rec = $this->getDoc_re($datas);

                                foreach ($doc_rec as $docs)
                                {
                                    $td = [
                                        'id' => $datas ->id,
                                        'ref_num' => $datas->jobref_no,
                                        'ref_id' => Crypt::encryptString($datas->jobref_no),
                                        'encrypt_ref_num' => Crypt::encryptString($datas->jobref_no,),
                                        'agency' => str::limit($datas -> assign_agency,20,'.....'),
                                        'agency_title' =>$datas -> assign_agency,
                                        'pos_title' => $get_position -> emp_position,
                                        'pos_title_id' => $get_position -> id,
                                        'sg' => $datas -> sg,
                                        'step' => $datas -> step,
                                        'salary' => $datas -> salary,
                                        'plantilla' => $get_educ -> item_no,
                                        'eligibility' => $get_educ -> eligibility,
                                        'education' => $get_educ -> educ,
                                        'training' => $get_educ -> training,
                                        'work_ex' => $get_educ -> work_ex,
                                        'pos_type' => $pos_types -> id,
                                        'competency' => $get_educ -> competency,
                                        'email_through' => $datas->email_through,
                                        'email_add' => $datas->email_add,
                                        'address' => $datas->address,
                                        'post_date' => $datas -> post_date,
                                        'close_date' => $datas -> close_date,
                                        'orig_post_date' => convert_date($datas -> post_date),
                                        'orig_close_date' => convert_date($datas -> close_date),
                                        'remarks' => $docs -> remarks,
                                        'status' => $datas ->status,
                                        'pos_info' => $check_position,
                                        'notif_color' => $notif_color,
                                    ];

                                    $load_datas[count($load_datas)] = $td;
                                }

                            }
                        }
                    }

                }

            }
            echo json_encode($load_datas);


        } catch(Throwable $e)
        {
            dd($e);
        }
     }

     private function load_data($filter)
     {
            if($filter == '13')
            {
                $data = tbljob_info::with('getJob_doc','getDoc_rec', 'get_job_doc_requirements')->where('active','1')->where('status','13')->orderBy('id','ASC')->get()->unique(['jobref_no']);

            } else if($filter == '14')
            {
                $data = tbljob_info::with('getJob_doc','getDoc_rec', 'get_job_doc_requirements')->where('active','1')->where('status','14')->orderBy('id','ASC')->get()->unique(['jobref_no']);
            }
            else if($filter == '1')
            {
                $data = tbljob_info::with('getJob_doc','getDoc_rec', 'get_job_doc_requirements')->where('active','1')->where('status','1')->orderBy('id','ASC')->get()->unique(['jobref_no']);
            }
            else
            {
                $data = tbljob_info::with('getJob_doc','getDoc_rec', 'get_job_doc_requirements')->where('active','1')->where('status','13')->orderBy('id','ASC')->get()->unique(['jobref_no']);
            }
            return $data;
     }

     private function getJob_doc($job)
     {
        return $job->getJob_doc->unique('jobref_no');
     }

     private function getDoc_re($doc)
     {
        return $doc->getDoc_rec->unique('job_ref');
     }
     //get the position
     private function getPosition($position)
     {
        return $position->getPos;
     }
     private function getPosition_type($pos_type)
     {
        return $pos_type->getPos_type;
     }

     //check the date of the posting date
     private function check_posting_date($id,$posting_date,$closing_date,$status)
     {
        $currentTime = date('Y/m/d');
        $datetime = Carbon::createFromFormat('Y/m/d', $currentTime);
        $datetime->setTimezone('Asia/Manila');
        $current_date = $datetime->format('Y/m/d');

        $post_date = $this->change_date_format($posting_date);
        $close_date = $this->change_date_format($closing_date);

       if($post_date > $current_date)
       {
         if($close_date > $current_date)
         {
            $update_stat = tbljob_info::where('id',$id)->update([
                'status' => '1'
            ]);

            return false;
         }
       }
       else if($close_date < $current_date)
       {
        $update_stat = tbljob_info::where('id',$id)->update([
            'status' => '14'
        ]);
        return false;
       }
        return true;
     }

     //provide adminNotification for closing and pending of data
     private function get_job_profile($id,$post_date,$close_date,$status)
     {
        $currentTime = date('Y/m/d');
        $datetime = Carbon::createFromFormat('Y/m/d', $currentTime);
        $datetime->setTimezone('Asia/Manila');
        $current_date = $datetime->format('Y/m/d');

        $posting_date = $this->change_date_format($post_date);
        $closing_date = $this->change_date_format($close_date);
        $check_date = $this->check_posting_date($id,$post_date,$close_date,$status);

        if($check_date == false)
        {
            if($status == '13')
            {
                if($closing_date <= $current_date)
                {
                  $get_position = tbljob_info::where('id',$id)->get();
                  foreach($get_position as $pos)
                  {
                    return $pos->assign_agency;
                  }
                }
                else if($posting_date >= $current_date)
                {
                  $get_position = tbljob_info::where('id',$id)->get();
                  foreach($get_position as $poss)
                  {
                    return $poss->assign_agency;
                  }

                }
            }
        }
     }

     //change the color of the text based on the position status
     private function change_notif_color($id,$post_date,$close_date,$status)
     {
        $currentTime = date('Y/m/d');
        $datetime = Carbon::createFromFormat('Y/m/d', $currentTime);
        $datetime->setTimezone('Asia/Manila');
        $current_date = $datetime->format('Y/m/d');

        $posting_date = $this->change_date_format($post_date);
        $closing_date = $this->change_date_format($close_date);

        $check_date = $this->check_posting_date($id,$post_date,$close_date,$status);

        if($check_date == false)
        {
            if($closing_date <= $current_date)
            {
              $get_position_stat = "close";
              return $get_position_stat;
            }
            else if($posting_date >= $current_date)
            {
              $get_position_stat = "pending";
              return $get_position_stat;
            }
        }
     }

//Print the pdf in CSC format=============================================================================================
    public function print_pdf($id)
    {
        try
        {
            $filename = 'Position Hiring';
            $extract_data = new ExcelServices;
            $decrypted_id = Crypt::decryptString($id);

            $get_job_info = $extract_data ->get_job_info_custom($decrypted_id);
            $get_educ_rec = $extract_data ->get_educ_rec_custom($decrypted_id);
            $get_doc_req = $extract_data ->get_doc_req_custom($decrypted_id);

             $long_BondPaper = array(0, 0, 612.00, 936.0);

             $pdf = PDF::loadView('hiring_blade.print_pdf.print_position',compact('get_job_info','get_educ_rec','get_doc_req','filename',))->setPaper('a4','portrait');

             $pdf->output();
             $dom_pdf = $pdf->getDomPDF();
             $canvas = $dom_pdf ->get_canvas();
             $canvas->page_text(275, 950, "{PAGE_NUM} / {PAGE_COUNT}", null, 10, array(0, 0, 0));

             return $pdf->stream($filename . '.pdf');

        }catch(DecryptException $e)
        {
            dd($e);
        }
    }

//Print the new pdf=============================================================================================
    public function new_print_pdf($id)
    {
        $extract_data = new ExcelServices;
        $decrypted_id = Crypt::decryptString($id);
        $file = 'Print Position Hiring';
        $date = $extract_data->get_date();
        $get_org_head = $extract_data->get_head_org();
        $get_org_head_pos = $extract_data->get_head_org_pos();

        $get_job_info_custom = $extract_data ->get_job_info_custom($decrypted_id);
        $get_educ_rec_custom = $extract_data ->get_educ_rec_custom($decrypted_id);
        $get_doc_req_custom = $extract_data ->get_doc_req_custom($decrypted_id);

            $pdf = PDF::loadView('hiring_blade.print_pdf.print_new_position',compact('get_job_info_custom','get_educ_rec_custom','get_doc_req_custom','get_org_head','get_org_head_pos','date','file',))->setPaper('legal','landscape');

            $pdf->output();

            return $pdf->stream($file . '.pdf');
    }

//Export the poistion Hiring in excel form====================================================================================================
    public function export_position_hiring_excel($id)
    {
        if($id)
        {
            $extract_data = new ExcelServices();
            $pos = $extract_data->get_position_info($id);
            $date = $extract_data -> get_date();
            $check = $extract_data->check_status_for_download($id);

            if($check)
            {
                return Excel::download(new position_hiring($id),'Request for CSC of position hiring'.' '.$pos.'.xlsx');
            }
            else
            {
                return redirect()->route('index');
            }
        }
    }

 //Export all the position Hiring in excel form=============================================================================================
    public function export_all_position_hiring()
    {
        $extract_data = new ExcelServices;
        $date = $extract_data -> get_date();
        $check = $extract_data->check_all_pos();

        if($check!=false)
        {
            return Excel::download(new allpositionExport,'Request for CSC publication'.' '.'('.$date.')'.'.xlsx');
        }
        else
        {
            return redirect()->route('index');
        }

    }

//Added by MOntz===========================================================================================================================
    public function load_job_doc_requirements(Request $request)
    {
        $cs_eligibility_list = '';
        $job_doc_list = '';

        $get_job_doc_req = tbl_job_doc_requirements::where('job_info_no', $request->ref_num)
            ->where('active', true)
            ->get();

        if ($get_job_doc_req) {
            foreach ($get_job_doc_req as $index => $doc) {

                $job_doc_req_id = $doc->id;
                $job_doc_req = $doc->doc_requirements;
                $job_doc_req_type = $doc->doc_type;

                $job_doc_list .= '<tr class="hover:bg-gray-200">
                                            <td style="text-transform:uppercase"><input  name="td_doc_requirement[]" type="text" class="form-control" value="' .$job_doc_req. '"></td>
                                            <td style="text-transform:uppercase"><input  name="td_doc_requirement_type[]" type="text" class="form-control" value="' .$job_doc_req_type. '"></td>
                                            <td >
                                                <div class="flex justify-center items-center">
                                                    <a href="javascript:void(0);" class=" text-theme-6 delete_saved_doc_req text-center" data-doc-id="' . $job_doc_req_id . '" data-ref-num="'.$request->ref_num.'"><i  class="w-4 h-4 text-danger fa-solid fa-trash">Remove</i></a>
                                                </div>
                                            </td>
                                        </tr>';
            }
        }

        return json_encode(array(

            "job_doc_list" => $job_doc_list,

        ));
    }

    public function delete_job_doc_requirements(Request $request)
    {
        tbl_job_doc_requirements::where('id',$request->job_doc_id)->delete();

        return response()->json([
            'status' => 200,
        ]);
    }
}
