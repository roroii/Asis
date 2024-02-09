<?php
namespace App\Services\survey_training;

use App\Models\EmployeeRating\tbl_survey_indicators;

use App\Services\rating_service\RatingServices;

class TrainingSatisfactionServices {

public function saved_survey_data($indicators)
{
        try
        {
            if($indicators!='')
            {
                    $rating = new RatingServices();
                    $generated_id = $rating->generate_id(new tbl_survey_indicators,'ref_id',4,'REF');


                for($x=0;$x<count($indicators);$x++)
                {
                    $data = [
                        'ref_id' => $generated_id,
                        'indicators' => $indicators[$x],
                    ];
                }

                $saved = tbl_survey_indicators::create($data);

                if($saved)
                {
                    return true;
                } else
                {
                    return false;
                }
            } else
            {
                return false;
            }
        }
        catch(Exception $e)
        {
            dd($e);
        }

}

}
