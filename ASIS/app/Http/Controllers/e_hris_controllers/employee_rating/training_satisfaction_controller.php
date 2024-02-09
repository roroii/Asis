<?php

namespace App\Http\Controllers\employee_rating;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeRating\tbl_survey_indicators;

use App\Services\survey_training\TrainingSatisfactionServices;

class training_satisfaction_controller extends Controller
{
    public function index()
    {
        return view('employee_ratings.survey_training.survey_training_satisfaction');
    }

    public function saveData(Request $request)
    {
        $survey = new TrainingSatisfactionServices();
        $saved_data = $survey->saved_survey_data($request->indicators);

        if($saved_data)
        {
            return response()->json([
                'status' => true,
                'message' => 'Successfully saved the data'
            ]);
        } else
        {
            return response()->json([
                'status' => false,
                'message' => 'Unable to saved please try again'
            ]);
        }
    }


}
