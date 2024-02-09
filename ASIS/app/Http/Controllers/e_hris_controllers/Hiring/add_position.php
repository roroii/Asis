<?php

namespace App\Http\Controllers\Hiring;

use App\Http\Controllers\Controller;
use App\Models\Hiring\tbl_position;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class add_position extends Controller
{
    //
    public function position_index()
    {
        return view('hiring_blade.add_position.add_position');
    }


    public function create_position(Request $request)
    {
        try
        {
            $data = [];
            $check = $this->check_exist($request->position);
            if(!$check)
            {
                $data = [
                    'emp_position' => $request->position,
                    'descriptions' => $request->desc
                    ];

                $saved = tbl_position::create($data);

                if($saved)
                {
                    return response()->json([
                        'status' => true,
                        'message' => 'Successfully Saved'
                    ]);
                }
            }
            else
            {
                return response()->json([
                    'status' => false,
                    'message' => 'Position already exist'
                ]);
            }

        }
        catch(Exception $e)
        {
            $message = $e->getMessage();
            var_dump('Exception Message: '. $message);

            $code = $e->getCode();
            var_dump('Exception Code: '. $code);

            $string = $e->__toString();
            var_dump('Exception String: '. $string);

            exit;
        }
    }

    //===================================display the position
    public function check_exist($pos)
    {
        $check_exist = '';

        $check_exist = tbl_position::where('emp_position',$pos)->where('active',true)->exists();
        return $check_exist;
    }


    public function display_position()
    {
        try
        {
            $position_details = $this->get_position_details();
            $store_data = [];


            foreach($position_details as $details)
            {
                $data = [
                    'id' => Crypt::encryptString($details->id),
                    'emp_position' => $details->emp_position,
                    'description' => str::limit($details->descriptions,50,'.....'),
                    'descrpt' => $details->descriptions,
                    ];

                $store_data[count($store_data)] = $data;
            }

            echo json_encode($store_data);
        }
        catch(Exception $e)
        {
            $message = $e->getMessage();
            var_dump('Exception Message: '. $message);

            $code = $e->getCode();
            var_dump('Exception Code: '. $code);

            $string = $e->__toString();
            var_dump('Exception String: '. $string);

            exit;
        }
    }

    private function get_position_details()
    {
        $position_details = '';
        $position_details = tbl_position::where(function($query){
            $query->whereNotNull('id')->orWhere('emp_position','!=','');
        })->oldest('id')->where('active',true)->get();

        return $position_details;
    }
    //====================================================================== delete the data
    public function delete_position_data(Request $request)
    {
        try
        {
            if( $request->id !='')
            {
                $delete_data = '';
                $decrypted_id = Crypt::decryptString($request->id);

                $data = [
                    'active' => false
                ];

                $delete_data = tbl_position::where('id',$decrypted_id)->where('active',true)->update($data);

                if($delete_data)
                {
                    return response()->json([
                        'status' => true,
                        'message' => 'Successfully deleted'
                    ]);
                }
            }

        }catch(DecryptException $e)
        {
            dd($e);
        }
    }
    //====================================================================== update the data
    public function update_position_data(Request $request)
    {
        try
        {
            $decrypt_id = Crypt::decryptString($request->id);

            $get_position_details = tbl_position::where('id',$decrypt_id)->where('active',true)->first();

            return json_encode(array(
                "position" => $get_position_details->emp_position,
                "desc" => $get_position_details->descriptions
            ));
        }
        catch(Exception $e)
        {
            $message = $e->getMessage();
            var_dump('Exception Message: '. $message);

            $code = $e->getCode();
            var_dump('Exception Code: '. $code);

            $string = $e->__toString();
            var_dump('Exception String: '. $string);

            exit;
        }
    }

    public function update_data_position(Request $request)
    {
        try
        {
            $decrypt = Crypt::decryptString($request->id);
            $data = [
                'emp_position' => $request->pos,
                'descriptions' => $request->desc
            ];

         $update = tbl_position::where('id',$decrypt)->where('active',true)->update($data);

         if($update)
         {
            return response()->json([
                'status'=>true,
                'message' => 'Successfully Updated !'
            ]);
         }
         else
         {
            return response()->json([
                'status'=>false,
                'message' => 'Unable to update please try again'
            ]);
         }

        }catch(Exception $e)
        {
            $message = $e->getMessage();
            var_dump('Exception Message: '. $message);

            $code = $e->getCode();
            var_dump('Exception Code: '. $code);

            $string = $e->__toString();
            var_dump('Exception String: '. $string);

            exit;
        }
    }

}
