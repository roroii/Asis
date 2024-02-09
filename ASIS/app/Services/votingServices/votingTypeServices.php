<?php
namespace App\Services\votingServices;

use App\Models\ASIS_Models\vote\elect_participants_model;

use App\Models\ASIS_Models\vote\open_voting_model;
use Carbon\Carbon;

class votingTypeServices {

    public function checkParticipantsExists($voting_typeID){
            try
            {
                if($voting_typeID!=null){
                       $participants = elect_participants_model::where('type_id', $voting_typeID)->where('active', true)->exists();
                       if($participants){
                            return true;
                       }else{
                        return false;
                       }
                } else
                {
                    return false;
                }
            }
            catch(\Exception $e)
            {
                dd($e);
            }

    }

    public function checkVoting_is_Done($voting_typeID){
        try {
            if ($voting_typeID != null) {
                $exist = open_voting_model::where('type_id', $voting_typeID)->where('active', true)->exists();
                $participants = open_voting_model::where('type_id', $voting_typeID)->where('active', true)->first();
        
                if ($exist) {
                    $closeDate = Carbon::parse($participants->close_date)->timezone('Asia/Manila'); // Use 'Asia/Manila' for Philippine time
                    $currentDate = Carbon::now('Asia/Manila'); // Use 'Asia/Manila' for Philippine time
        
                    // dd('close Date:'.$closeDate, 'Open Date: '.$currentDate);

                    if ($closeDate < $currentDate) {
                        return false;
                        // dd('di na pwede');
                    }else{
                        return true;
                        // dd('pwede pa');
                    }
                } else {
                    return true;
                    // dd('AYAAY KA WALA NAG EXIST');
                }
            } else {
                return true;
                // dd('AYAAY KA NULL MAN');
            }
        } catch (\Exception $e) {
            // Handle exceptions if any
            return false;
        }

}

}