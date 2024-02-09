<?php

namespace App\Http\Controllers\vote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ASIS_Models\vote\voteType_model;
use App\Models\ASIS_Models\vote\votePosition_model;
use App\Models\ASIS_Models\vote\voteOpenApplication_Model;
use App\Models\ASIS_Models\vote\assignPosition_model;
use App\Models\ASIS_Models\vote\elect_participants_model;
use App\Models\ASIS_Models\vote\open_voting_model;
use App\Models\ASIS_Models\vote\signatory_model;
use App\Models\ASIS_Models\vote\assign_voters;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Carbon\Carbon;
use PDF;

use App\Services\votingServices\votingTypeServices;

use App\Models\ASIS_Models\posgres\portal\srgb\program;

class votingController extends Controller
{
    // =========  VOTE TYPE  ========== //

   
    public function voteType(){
        return view('vote.voteType_page');
    }

    public function add_voteType(Request $request){

        try {
            $saverated = new voteType_model;
            $saverated->vote_type = $request->input('voteType');
            $saverated->vote_description = $request->input('typeDescription');
        
            $encryptedTypeID = $request->input('typeID');
            $decryptedTypeID = 0; // Default value for decryption errors
            if ($encryptedTypeID != null) {
                // Attempt decryption only if the value is not zero
                $decryptedTypeID = Crypt::decryptString($encryptedTypeID);
            }
        
            // Debugging: Print the encrypted and decrypted values
            // dd('Encrypted:', $encryptedTypeID, 'Decrypted:', $decryptedTypeID);
        
            if ($decryptedTypeID != 0) {
                // Use the 'find' method to retrieve the model instance and then update
                $voteType = voteType_model::find($decryptedTypeID);
        
                if ($voteType) {

                   $votingTypeServices = new votingTypeServices;

                   $exists_data = $votingTypeServices->checkParticipantsExists($decryptedTypeID);

                   if($exists_data){
                        return response()->json(['status' => 'exists']);
                   }else{
                        $voteType->update([
                            'vote_type' => $request->input('voteType'),
                            'vote_description' => $request->input('typeDescription'),
                        ]);
                        return response()->json(['status' => 'updated']);
                   }                   
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Vote type not found']);
                }
            } else {
                $saverated->save();
                return response()->json(['status' => 'saved']);
            }
        
        } catch (DecryptException $e) {
            // Handle decryption errors
            return response()->json(['status' => 'error', 'message' => 'Decryption error']);
        }
        
        
        
    }

    public function fetch_voteTypeData(){

        $v_type_data = [];
        $voteTypeDatas = voteType_model::where('active', 1)->latest('created_at')->get();

        if($voteTypeDatas->count() > 0){

            foreach ($voteTypeDatas as $key => $voteTypeData) {

                $status = 'close';
                $openApp_date = '';
                $closeApp_date = '';
                $openApplicationDate = '';

                    $date_openApp = '';
                    $time_openApp = '';
                    $date_closeApp = '';
                    $time_closeApp = '';

                $currentDateTime = date('Y-m-d H:i:s');

                $check_openApplication = voteOpenApplication_Model::where('vote_typeID', $voteTypeData->id)->first();
                if($check_openApplication){

                    $openApp_date =  $check_openApplication->open_date;
                    $open_dateTimeParts = explode(' ', $openApp_date);
                    $date_openApp = $open_dateTimeParts[0]; // This will contain "2023-08-01"
                    $time_openApp = $open_dateTimeParts[1]; // This will contain "12:00:00"

                    $closeApp_date =  $check_openApplication->close_date;
                    $close_dateTimeParts = explode(' ', $closeApp_date);
                    $date_closeApp = $close_dateTimeParts[0]; // This will contain "2023-08-01"
                    $time_closeApp = $close_dateTimeParts[1]; // This will contain "12:00:00"


                    if ($currentDateTime >= $openApp_date &&  $currentDateTime <= $closeApp_date) {
                        $openApplicationDate = 'open';
                    }else if( $currentDateTime < $openApp_date) {
                        $openApplicationDate = 'comming';
                    }else{
                        $openApplicationDate = 'close';
                    }
                }else{
                    $openApplicationDate = 'notOpen';
                }

                $voter = '';
                if($voteTypeData->voter != ''){
                    $voter = $voteTypeData->voter;
                }

                $type_exist = false;
                $votingTypeServices = new votingTypeServices;
                $exists_data = $votingTypeServices->checkParticipantsExists($voteTypeData->id);
                
                if($exists_data){
                    $type_exist = true;
                }

                // dd( $type_exist);
                $td = [

                    "id" => crypt::encryptString($voteTypeData->id),
                    "voteType" => $voteTypeData->vote_type,
                    "VoteDiscription" => $voteTypeData->vote_description,
                    "openApplicationDate" => $openApplicationDate,
                    "date_openApp" => $date_openApp,
                    "time_openApp" => $time_openApp,
                    "date_closeApp" => $date_closeApp,
                    "time_closeApp" => $time_closeApp,
                    "voter" => $voter,
                    "type_exist" => $type_exist,
                    ];
                $v_type_data[count($v_type_data)] = $td;

            }
            
        }
        echo json_encode($v_type_data);

    }

    public function set_openApplication_Voting_date(Request $request){

        try {
            $typeID = crypt::decryptString($request->voteTypeID);
            $openDate = $request->openDate;
            $closeDate = $request->closeDate;
            $openTime = $request->openTime;
            $closeTime = $request->closeTime;

            voteOpenApplication_Model::updateOrCreate(
            ['vote_typeID' => $typeID],
            [
                'open_date' => $openDate . '-' . $openTime,
                'close_date' => $closeDate . '-' . $closeTime,
                'status' => 1
            ]
        );
        return response()->json(["status" => 200]);
        } catch (DecryptException $e) {
            echo 'Error: ' . $e->getMessage();
        }
        

    }

    public function addSignatory(Request $request){
        // dd($request->all());
        try {
            $type_id = crypt::decryptString($request->typeID);
            $signatory = $request->signatory_select;
            $sig_description = $request->sig_description;

            signatory_model::updateOrCreate([
                'type_id' => $type_id, 
                'signatory' => $signatory,
                'active' => 1,
            ],
            ['sig_description' => $sig_description]);

            return response()->json(['status' => 200, 'type_id' => $request->typeID]);
        } catch (DecryptException $e) {
            echo 'Error: ' . $e->getMessage();
        }
        
    }

    public function loadSignatory(Request $request){
        // dd($request->all());
        try {
            $signatory_data = '';

            $type_id = crypt::decryptString($request->type_id);

            $signatoryDatas = signatory_model::with('get_signatory')->where('type_id', $type_id)->where('active', 1)->get();
            if($signatoryDatas->count() > 0){

                foreach ($signatoryDatas as $key => $signatoryData) {
                    $signature_name = '';

                    $signatory_id =  $signatoryData->signatory;
                    $image = get_profile_image($signatory_id);

                    if($signatoryData->get_signatory){
                        $signature_name = $signatoryData->get_signatory->fullname;
                    }

                    $signatory_data .= '<div class="intro-y col-span-12 md:col-span-6">                                    
                        <div class="box">
                            <strong><label for="description">'.$signatoryData->sig_description.'</label></strong>
                            <div class="flex flex-col lg:flex-row items-center p-5">
                                <div class="w-24 h-24 lg:w-12 lg:h-12 image-fit lg:mr-1">
                                    <img alt="Midone - HTML Admin Template" class="rounded-full" src="'.$image.'">
                                </div>
                                <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                                    <a href="javascript:;" class="font-medium ">'.$signature_name.'</a> 
                                    <div class="text-slate-500 text-xs mt-0.5"></div>
                                </div>
                                <div class="flex mt-4 lg:mt-0">
                                    <a id="'.Crypt::encryptString($signatoryData->id).'"data-type-id="'.$request->type_id.'"  class="delete_signatory" href="javascript:;"><strong> <i class="fa-solid fa-x text-danger h-4 w-4"></i> </strong></a> 
                                </div>
                            </div>
                        </div>
                    </div>';
                    
                }

            echo $signatory_data;
        }
        } catch (DecryptException $e) {
            echo 'Error: ' . $e->getMessage();
        }
        
    }

    public function assign_voters(Request $request){
        // dd($request->all());
        try {
            $type_id = crypt::decryptString($request->type_id);

            $prog_code = $request->prog_code;
            if (!empty($prog_code)) {
                foreach ($prog_code as $key => $voters) {
                    $save_assign_voters = [
                        "type_id" => $type_id,
                        "prog_code" => $voters,
                        "active" => 1,
                    ];

                    $existingRecord = assign_voters::where('type_id', $type_id)
                        ->where('prog_code', $voters)
                        ->first();
                        if ($existingRecord) {
                        
                            $existingRecord->update($save_assign_voters);
                        } else {
                            // Create a new record
                            assign_voters::create($save_assign_voters);
                        }
                }
                    assign_voters::where('type_id', $type_id)
                            ->whereNotIn('prog_code', $prog_code)
                            ->update(['active' => 0]);
            }else{
                assign_voters::where('type_id', $type_id)->update(['active' => 0]);
            }

            return response()->json(['status' => 200]);

        } catch (DecryptException $e) {
            echo 'Error: ' . $e->getMessage();
        }
      
    }

    public function loadVoters(Request $request){

        
        try {
            $type_id = Crypt::decryptString($ $request->type_id);
            $voter_program = [];
            $voters = assign_voters::where('type_id', $type_id)->where('active', 1)->get();

            if($voters->count() > 0){
                foreach ($voters as $key => $voter) {

                    $td = [

                        "id" => $voter->id,
                        "type_id" => $voter->type_id,
                        "prog_code" => $voter->prog_code,
                    
                        ];
                    $voter_program[count($voter_program)] = $td;

                }
            }
            // dd($voter_program);
            echo json_encode($voter_program);
        } catch (DecryptException $e) {
            echo 'Error: ' . $e->getMessage();
        }

    }

    public function loadProgram(Request $request){

        try {
            $type_ID = crypt::decryptString($request->type_id);

            $votingTypeServices = new votingTypeServices;
            $exists_data = $votingTypeServices->checkVoting_is_Done($type_ID);
            
            $programData = [];
            
            // dd( $exists_data);
            $load_proram = program::where('active', true)->get();
    
            // dd($voters);
            if( $load_proram->count() > 0 ){
                foreach ($load_proram as $program) {
    
                    $voters = assign_voters::where('type_id', $type_ID)
                                        ->where('prog_code', trim($program->progcode))
                                        ->where('active', 1)
                                        ->exists();
                    $checked = '';
                    if($voters){
                        $checked = 'checked';
                    }
                    $td =   [
                                "program_code"  => $program->progcode,
                                "program_desc"  => $program->progdesc,
                                "checked"       => $checked,
                               
                            ];
                    $programData[count($programData)] = $td;
                }
            }

            $data = ['program' => $programData,
                    'exists' => $exists_data];
            // dd($programData);
            echo json_encode($data);
        } catch (\exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
       
    }

    public function print_allVoters($voteType_id){
        
        try {
            ini_set('memory_limit', '1024M'); 
            $dec_voteType_id = crypt::decryptString($voteType_id);
            $voter_assign = assign_voters::with('get_enrolledList')->where('type_id', $dec_voteType_id)->where('active', 1)->get();
            $signatoryDatas = signatory_model::with('get_signatory')->where('type_id', $dec_voteType_id)->where('active', 1)->get();
            
            // dd($voter_assign);
            $election_name = '-- Pangalan ni sa Election';

            $electionType = voteType_model::where('id', $dec_voteType_id)->first();

            if($electionType){
                $election_name = $electionType->vote_type;
            }else{
                $election_name = 'No Data Found';
            }

            $from = '';
            $to = '';
            $status_text = '';
            $now = date('m/d/Y g:ia');
            $datetime = Carbon::createFromFormat('m/d/Y g:ia', $now);
            $datetime->setTimezone('Asia/Manila');
            $current_date = $datetime->format('m-d-Y g:iA');
    
            $filename = $election_name.' - Voters';
    
            // $long_BondPaper = array(0, 0, 612.00, 936.0);
            $system_image_header ='';
            $system_image_footer ='';
    
            if(system_settings()){
                $system_image_header = system_settings()->where('key','image_header')->first();
                $system_image_footer = system_settings()->where('key','image_footer')->first();
            }
    
            $pdf = PDF::loadView('vote.voterPrint.print_all',
                        compact('system_image_header', 'system_image_footer',
                                'filename','current_date','status_text','dec_voteType_id',
                                'election_name', 'voter_assign',
                                'signatoryDatas',
                                ))
                        ->setPaper('legal','portrait');
            
            return $pdf->stream($filename . '.pdf');
            // unset($pdf);
        } catch (DecryptException $e) {
            echo 'Error: ' . $e->getMessage();
        }

       
    }

    // ========= VOTE POSITION ========== //
    public function votingPosition(){
        return view('vote.elctionPosition_page');
    }

    public function add_votePosition(Request $request){

        $saveVotePosition = new votePosition_model;
        $saveVotePosition->vote_position = $request->input('votePosition');
        $saveVotePosition->position_desc = $request->input('positionDescription');

        if ($request->votePositionID != 0) {
            // Use the 'find' method to retrieve the model instance and then update
            $voteposition = votePosition_model::where('id', $request->votePositionID);
            if ($voteposition) {
                $voteposition->update([
                    'vote_position' => $request->input('votePosition'),
                    'position_desc' => $request->input('positionDescription'), // Corrected field name
                ]);
                return response()->json(['status' => 'updated']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Vote type not found']);
            }
        } else {
            $saveVotePosition->save();
            return response()->json(['status' => 'saved']);
        }
    }

    public function fetch_votePositionData(){
        $v_position_data = [];
        $votePositionDatas = votePosition_model::where('active', 1)->latest('created_at')->get();

        if($votePositionDatas->count() > 0){

            foreach ($votePositionDatas as $key => $votePositionData) {

                $td = [

                    "id" => $votePositionData->id,
                    "votePosition" => $votePositionData->vote_position,
                    "position_desc" => $votePositionData->position_desc,


            ];
                $v_position_data[count($v_position_data)] = $td;





            }
            echo json_encode($v_position_data);
        }
    }

    public function assignPosition(Request $request){

        // Count the positions sent in the request


           foreach ($request->positionID as $key => $positionID) {
               $save_assignPosition = [
                   "positionID" => $positionID,
                   "typeID" => $request->elecType_select,
                   "active" => 1,
               ];

               // $assign_positionID = $request->assign_positionID[$key];
               $typeID = $request->elecType_select;

               $existingRecord = assignPosition_model::where('positionID', $positionID)
                   ->where('typeID', $typeID)
                   ->first();

               // dd($existingRecord);
               if ($existingRecord) {
                   
                   $existingRecord->update($save_assignPosition);
               } else {
                   // Create a new record
                   assignPosition_model::create($save_assignPosition);
               }

           }

          // Set active = 0 for records with the specified typeID that are not in the loop
           $voteType = $request->elecType_select;
           assignPosition_model::where('typeID', $voteType)
                           ->whereNotIn('positionID', $request->positionID)
                           ->update(['active' => 0]);



       return response()->json(["status" => 200]);
    }

    public function filterPosition(Request $request){
        $voteType_position = [];
        $voteposition_types = assignPosition_model::with('getElect_position')->where('typeID', $request->typeID)->where('active', 1)->get();

        if($voteposition_types->count() > 0){

            foreach ($voteposition_types as $key => $voteposition_type) {
                $positionID = '';
                $positionName = '';
                $positionDesc = '';
                $position = $voteposition_type->getElect_position;
                if($position){
                    $positionID = $position->id;
                    $positionName =  $position->vote_position;
                    $positionDesc =  $position->position_desc;
                }

                $data = [
                    "assign_id" => $voteposition_type->id,
                    "id" => $positionID,
                    "vote_position" => $positionName,
                    "position_desc" => $positionDesc,
                ];

                $voteType_position[count($voteType_position)] = $data;
            }

            echo json_encode($voteType_position);
        }

    }

}
