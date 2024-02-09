<?php

namespace App\Http\Controllers\employee_rating;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\rating_service\RatingServices;

class employee_rating_controller extends Controller
{
    //
    public function index()
    {
        return view('employee_ratings.employee_rating');
    }

    public function save_input(Request $request)
    {
        $rating = $request->temp_rating;
        $adjectival = $request->temp_adjectival;
        $desc = $request->temp_rating_desc;
        $id = $request->temp_id;

        $rating_services =  new RatingServices();
        $saved = $rating_services->save_rating_val($id,$rating,$adjectival,$desc);

        if($saved)
        {
            return response()->json([
                'status' => true,
                'message' => 'Successfully Saved'
            ]);

        } else
        {
            return response()->json([
                'status' => false,
                'message' => 'Unable to saved'
            ]);
        }

    }

    public function load_spms_datas()
    {
        $load = new RatingServices();
        $data = $load->load_spms_data();

        echo json_encode($data);
    }

    public function load_rating_data(Request $request)
    {
        $emp_rating = new RatingServices();
        $rate_data = $emp_rating->retrieved_rating_data($request->ref_id);

        echo json_encode($rate_data);
    }

    public function update_rating_data(Request $request)
    {
        $emp_rating = new RatingServices();

        $updated_data = $emp_rating->check_if_exist($request->temp_id,$request->ref_id,$request->temp_rating,$request->temp_adjectival,$request->temp_rating_desc,$request->active_rating_stat);

        if($updated_data)
        {
            return response()->json([
                'status' => true,
                'message' => 'Successfully updated the data'
            ]);
        } else
        {
            return response()->json([
                'status' => false,
                'message' => 'Unable to update'
            ]);
        }
    }

    public function delete_rating_data(Request $request)
    {
        $emp_rating = new RatingServices();
        $delete_data = $emp_rating->delete_spms_data($request->ref_id);

        if($delete_data)
        {
            return response()->json([
                'status' => true,
                'message' =>'Successfully deleted the date',
            ]);

        } else
        {
            return response()->json([
                'status' => false,
                'message' =>'Please select the in-active status to delete',
            ]);
        }
    }

    public function activate_spms_rating(Request $request)
    {
        $emp_rating = new RatingServices();
        $activate = $emp_rating->activate_spms_rating($request->ref_id,$request->active);

        if($activate)
        {
            return response()->json([
                'status' => true,
                'message'=> 'Successfully Updated'
            ]);
        }
    }

}
