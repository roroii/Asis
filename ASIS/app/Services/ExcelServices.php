<?php

namespace App\Services;
use Carbon\Carbon;
use App\Models\Hiring\tbljob_info;
use App\Models\Hiring\tbljob_doc_rec;
use App\Models\Hiring\tbleduc_req;
use App\Models\Hiring\tbl_position;
use App\Models\Hiring\tbl_job_doc_requirements;
use App\Models\agency\agency_employees;
use App\Models\tblemployee;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Str;


class ExcelServices
{

    //get the head id of the organization
    private function get_head_id()
    {
        try
        {
            $get_head = system_settings()->where('key','agency_head')->first();

            if($get_head)
            {
                return $get_head->value;
            }else {

                $get_head = 'no head of organization found';

                return $get_head;
            }
        } catch(Exception $e)
        {
            dd($e);
        }
    }

    //get the head of the agancy or the organization
    public function get_head_org()
    {
        $id = $this->get_head_id();
        $employee = '';
        $name = '';
        $empty = 'No data';

        if($id != '')
        {
            $employee = tblemployee::whereHas('get_employee_profile_pos', function ($query)
            {
                $query -> whereNotNull('agency_id')->where('position_id','!=','');
            })->where('agencyid',$id)->where('active',true)->first();

            if($employee)
            {
                return $employee->firstname.' '.$employee->mi.'.'.$employee->lastname;
            }
            else
            {
                return $empty;
            }
        }
        else
        {
            return $empty;
        }
    }

    //get the position of the head
    public function get_head_org_pos()
    {
        try
        {
            $id = $this->get_head_id();
            $empty = "No poisiton found";

            if ($id)
            {
                return get_HRMO_Position($id);
            }
            else
            {
                return $empty;
            }
        }
        catch(Exception $e)
        {
            dd($e);
        }
    }


    //get the information on the position
    public function get_position_info($id)
    {
          try
            {
                if($id)
                {
                    $decrypt = Crypt::decryptString($id);

                    $get_hiring_pos = tbljob_info::where('jobref_no',$decrypt)->where('active',true)->first();
                    if($get_hiring_pos)
                    {
                        $get_pos = tbl_position::where('id',$get_hiring_pos->pos_title)->where('active',true)->first();

                        return $get_pos->emp_position;
                    }
                }
            }catch(DecryptException $e)
            {
                dd($e);
            }
    }

    //get the data of job information
    public function get_job_info_custom($id)
    {
        try
        {
            $get_job_info = '';

            if($id)
            {
                $get_job_info = tbljob_info::where('jobref_no',$id)->first();

                return $get_job_info;
            }
        }
        catch(Exception $e)
        {
            dd($e);
        }
    }

    //get the education background information
    public function get_educ_rec_custom($id)
    {
        try
        {
            $get_educ_info = '';

            if($id)
            {
                $get_educ_info = tbleduc_req::where('job_info_no',$id)->first();

                return $get_educ_info;
            }
        }
        catch(Exception $e)
        {
            dd($e);
        }
    }

    //get the documents requirements information
    public function get_doc_req_custom($id)
    {
        try
        {
            $get_doc_req_info = '';

            if($id)
            {
                $get_doc_req_info = tbljob_doc_rec::where('job_ref',$id)->first();

                return $get_doc_req_info;
            }
        }
        catch(Exception $e)
        {
            dd($e);
        }
    }
     //*==================================*//
    // return the current date
    public function get_date()
    {
        try
            {
            $currentTime = date('M d,Y');
            $datetime = Carbon::createFromFormat('M d,Y', $currentTime);
            $datetime->setTimezone('Asia/Manila');
            $current_date = $datetime->format('M d,Y');

            return $current_date;
            }
        catch(Exception $e)
        {
            dd($e);
        }
    }
    //*==================================*//

    //select the HRMO
    public function get_the_HRM()
    {
        try
        {
            $get_all_data = '';
            $get_hrm = $this->search_hrmo_position();

            if($get_hrm)
            {
                $get_all_data = agency_employees::wherenotNull('position_id')->where('position_id',$get_hrm)->whereraw('active = true && status != 0')->chunk(50, function($q) use (&$res)
                {
                    foreach($q as $data)
                    {
                        $res = $data->agency_id;
                    }
                });

                return $res;
            }

        }
        catch(Exception $e)
        {
            dd($e);
        }
    }
    //search for the Human Resource Management
    private function search_hrmo_position()
    {
        try
        {
            $get_position = '';
            $get_position = tbl_position::where('id',15)->where('active',true)->chunk(50, function($q) use (&$val)
            {
                foreach ($q as $get_hrm)
                {
                    $val = $get_hrm->id;
                }
            });
            return $val;

        }catch(Exception $e)
        {
            dd($e);
        }
    }

    //*=====*//
    //get all the data in the tbl_job_info
    public function get_all_job_info()
    {
        try
        {
            $get_hiring_position = tbljob_info::where('active',true)->whereraw('status = 13 || status = 1')->latest('created_at')->get();
            return $get_hiring_position;

        } catch(Exception $e)
        {
            dd($e);
        }
    }


    //*=====*//
    //count the duplicated jobref id
    public function count_doc_re()
    {
        try
        {
            $get_doc_req = tbl_job_doc_requirements::select('job_info_no')->groupby('job_info_no')->orderByRaw('COUNT(*) ASC')->where('active',true)
            ->limit(1)->chunk(50, function($q) use (&$val)
            {
                foreach($q as $data)
                {
                    $val = $data->job_info_no;
                }
            });

            return $val;

        }catch(Exception $e)
        {
            dd($e);
        }
    }

    //count the lenght of the word in the tbl_doc_req
    public function count_lenght_remarks()
    {
        try
        {

            $count_doc_rec = tbljob_doc_rec::where('active',true)->orderByraw('CHAR_LENGTH (remarks) ASC')->chunk(50, function($q)
            use (&$val)
            {
                foreach($q as $data)
                {
                   $val = $data->job_ref;
                }
            });
            return $val;
        }catch(Exception $e)
        {
            dd($e);
        }
    }
    //get the email address of the position hiring
    public function get_email()
    {
        try
        {
            $get_email = tbljob_info::where('active',true)->latest('created_at')->first();

            if($get_email)
            {
                return $get_email->email_add;
            }


        }catch(Exception $e)
        {
            dd($e);
        }
    }
    //get the address in the position hiring
    public function get_address()
    {
        try
        {
            $get_address = tbljob_info::select('address')->where('active',true)->latest('created_at')->first();

            if($get_address)
            {
                return $get_address->address;
            }

        }catch(Exception $e)
        {
            dd($e);
        }
    }

    public function check_status_for_download($id)
    {
        try
        {
            if($id)
            {
                $decrypt_id = Crypt::decryptString($id);

                $check_status = tbljob_info::where('jobref_no',$decrypt_id)->where('active',true)->where('status',13)->first();

                if($check_status)
                {
                    return true;

                } else
                {
                    return false;
                }
            }

        }catch(DecryptException $e)
        {
            dd($e);
        }
    }

    //check if the content is not equal to null
    public function check_all_pos()
    {
        try
        {
            $count_pos = tbljob_info::where('active',true)->whereraw('(status = 13 || status = 1)')->count();

            if($count_pos > 0)
            {
                return true;
            } else
            {
                return false;
            }

        }catch(Exception $e)
        {
            dd($e);
        }
    }
}
