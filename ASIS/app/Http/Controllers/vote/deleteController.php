<?php

namespace App\Http\Controllers\vote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

use App\Models\ASIS_Models\vote\voteType_model;
use App\Models\ASIS_Models\vote\votePosition_model;
use App\Models\ASIS_Models\vote\voteOpenApplication_Model;
use App\Models\ASIS_Models\vote\assignPosition_model;
use App\Models\ASIS_Models\vote\elect_participants_model;
use App\Models\ASIS_Models\vote\open_voting_model;
use App\Models\ASIS_Models\vote\signatory_model;
use App\Models\ASIS_Models\vote\candidate_parties_model;

class deleteController extends Controller
{
    public function delete_voteData($voteDataID, $RequestForDelete){

        // dd($voteDataID, $RequestForDelete);
        $voteData = '';
        $response = '';
        if($RequestForDelete == 'VoteType'){
            try {
                $voteData = voteType_model::where('id', Crypt::decryptString($voteDataID));
                $response = ['status' => 'voteTypeDeleted'];
            } catch(DecryptException  $e){
                dd($e);
            }
           
        }else if($RequestForDelete == 'VotePosition'){
            $voteData = votePosition_model::where('id', $voteDataID);
            $response = ['status' => 'votePositionDeleted'];
        }else if($RequestForDelete == 'signatory') {
            try {
                $voteData = signatory_model::where('id', Crypt::decryptString($voteDataID));
                $response = ['status' => 'signatoryDeleted', 'type_id' => $voteDataID];
            } catch(DecryptException  $e){
                dd($e);
            }
            
        }else if($RequestForDelete == 'candidate_parties') {
            try {
                $voteData = candidate_parties_model::where('id', Crypt::decryptString($voteDataID));
                $response = ['status' => 'partiesDeleted'];
            } catch(DecryptException  $e){
                dd($e);
            }
        }


        if ($voteData) {
            $voteData->update([
                'active' => 0
            ]);
            return response()->json($response);
        }

    }

}
