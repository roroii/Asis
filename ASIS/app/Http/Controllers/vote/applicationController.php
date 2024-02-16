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
use App\Models\ASIS_Models\vote\candidate_parties_model;
use App\Models\ASIS_Models\vote\signatory_model;
use App\Models\ASIS_Models\vote\type_group_model;
use App\Models\ASIS_Models\vote\candidate_parties_member_model;
use App\Models\ASIS_Models\enrollment\enrollment_list;
use App\Models\ASIS_Models\vote\supported_candidate_model;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Carbon\Carbon;
class applicationController extends Controller
{
    public function electionApplication(){

        return view('vote.openApplication_page');

    }


    public function fetch_openVoting_Application_data(){
        $open_application_datas = [];
        $openVotingDatas = voteOpenApplication_Model::with('getVoting_type')->where('active', 1)->latest('created_at')->get();


        if($openVotingDatas->count() > 0){

            $check_employee_admin = auth()->guard('employee_guard')->user();
            $check_student_admin = auth()->guard('web')->user();

            $admin = 0;

            if ($check_employee_admin && $check_employee_admin->role_name == 'Admin') {
                $admin = 1;
                // dd('employee_admin');
                // The user is an employee admin
            } elseif ($check_student_admin) {
                $admin = 0;
                // dd('student');
                // The user is a student admin
            }
            // dd($admin);
            // $dateTimeParts = explode(' ', $open_date);
            foreach ($openVotingDatas as $key => $openVotingData) {

                $openTimeDate = 0;
                //SPLIT OPEN DATE
                    $open_date = $openVotingData->open_date;
                    $open_dateTimeParts = explode(' ', $open_date);
                    $date_open = $open_dateTimeParts[0]; // This will contain "2023-08-01"
                    $time_open = $open_dateTimeParts[1]; // This will contain "12:00:00"

                    // dd( $date_open, $time_open);

                //SPLIT CLOSE DATE
                    $close_date = $openVotingData->close_date;
                    $close_dateTimeParts = explode(' ', $close_date);
                    $date_close = $close_dateTimeParts[0]; // This will contain "2023-08-01"
                    $time_close = $close_dateTimeParts[1]; // This will contain "12:00:00"


                    $currentDateTime = date('Y-m-d H:i:s'); // Get current date and time in "YYYY-MM-DD HH:MM:SS" format


                    if ($currentDateTime >= $open_date &&  $currentDateTime <= $close_date) {
                        $openTimeDate = 1;
                    }else if( $currentDateTime < $open_date) {
                        $openTimeDate = 2;
                    }else{
                        $openTimeDate = 3;
                    }
                    // dd($openTimeDate);

                    $vote_typeName = '';
                    $votingType = $openVotingData->getVoting_type;

                    if ($votingType) {
                        $vote_typeName = $votingType->vote_type;
                    }else{
                        $vote_typeName = 'No Voting Type Relationship';
                    }
                //CHECK IF APPLIED
                    $applied = 1;
                    // dd($admin);
                    if($admin != 1){
                        $check_ifApplied = elect_participants_model::where('type_id', $openVotingData->vote_typeID)->where('participant_id', auth()->user()->studid)->first();

                        
                        if($check_ifApplied){
                            $applied = 1;
                        }else{
                            $applied = 0;
                        }
                    }else{
                        $applied = 0;
                    }
                
                //CHECK IF VOTING IS OPEN
                    $check_ifOpen = open_voting_model::where('open_applicationID', $openVotingData->id)->first();

                    $openVoting_status = '';
                    $voting_date_open = '';
                    $voting_time_open = '';

                    $voting_date_close = '';
                    $voting_time_close = '';
                    if( $check_ifOpen){

                        $openVoting_date = $check_ifOpen->open_date;
                        $closeVoting_date = $check_ifOpen->close_date;

                        $openVoting_dateTimeParts = explode(' ', $openVoting_date);
                        $voting_date_open = $openVoting_dateTimeParts[0];
                        $voting_time_open = $openVoting_dateTimeParts[1];

                        $close_dateTimeParts = explode(' ', $closeVoting_date);
                        $voting_date_close = $close_dateTimeParts[0];
                        $voting_time_close = $close_dateTimeParts[1];

                        if($currentDateTime > $closeVoting_date){
                            $openVoting_status = 'close';
                        }else if($currentDateTime < $closeVoting_date && $currentDateTime > $openVoting_date){
                            $openVoting_status = 'open';
                        }else{
                            $openVoting_status = 'comming';
                        }

                    }else{
                        $openVoting_status = 'no';
                    }
                //APPLICATION DATA
                    $td = [

                        "open_Application_id" => $openVotingData->id,
                        "vote_typeID" => $openVotingData->vote_typeID,
                        "vote_typeName" => $vote_typeName,

                        "openVoting_date" => $voting_date_open,
                        "voting_time_open" => $voting_time_open,
                        "closeVoting_date" => $voting_date_close,
                        "voting_time_close" => $voting_time_close,

                        "openTimeDate" => $openTimeDate,
                        "openVoting_status" => $openVoting_status,
                        "applied" => $applied,


                ];
                    $open_application_datas[count($open_application_datas)] = $td;





                }

                $responseData = [
                    'open_application_datas' => $open_application_datas,
                    'admin' => $admin,

                ];


                echo json_encode($responseData);
        }
    }

    public function fetch_applicablePosition_data(Request $request){

        // dd($request->all());
        $applicable_Positions = [];
        $applicable_Position_datas = assignPosition_model::with('getElect_position')->where('typeID', $request->vote_typeID)->where('active', 1)->get();

        if($applicable_Position_datas->count() > 0){

            // $participated = 0;
            // $participated_id = 0;
            // $check_in_participants = elect_participants_model::where('type_id', $request->vote_typeID)->where('participant_id', auth()->user()->studid)->first();

            // if ($check_in_participants) {
            //     $participated = 1;
            //     $participated_id = $check_in_participants->position_id;
            // }

            // dd($participated);
            foreach ($applicable_Position_datas as $key => $applicable_Position_data) {

                // $vote_PositionID = '';
                $vote_PositionName = '';
                $vote_PositionDesc = '';
                $votingPopsition = $applicable_Position_data->getElect_position;

                if ($votingPopsition) {
                    // $vote_PositionID = $votingPopsition->id;
                    $vote_PositionName = $votingPopsition->vote_position;
                    $vote_PositionDesc = $votingPopsition->position_desc;
                }else{
                    $vote_PositionName = 'No Voting Type Relationship';
                    $vote_PositionDesc = 'No Voting Type Relationship';
                }

                $td =   [
                            "assign_id" => $applicable_Position_data->id,
                            "vote_PositionID" => $applicable_Position_data->positionID,
                            "vote_PositionName" => $vote_PositionName,
                            "vote_PositionDesc" => $vote_PositionDesc,
                            // "participated" =>  $participated,
                            // "participated_id" => $participated_id,
                        ];

                $applicable_Positions[count($applicable_Positions)] = $td;

            }
            // dd($applicable_Positions);
            echo json_encode($applicable_Positions);
        }
    }

    public function saveApplied_position(Request $request){

        $checkParty_participants = elect_participants_model::where('type_id', $request->vote_typeID)
                                ->Where('candidate_parties_id', $request->applicant_parties)
                                ->Where('position_id', $request->apply_Position_id)
                                ->Where('active', 1)->exists();

        // dd($request->type_id, $request->applicant_parties, $request->apply_Position_id);

        // $save_participants = new elect_participants_model;
        // $save_participants->open_typeID = $request->open_typeID;
        // $save_participants->type_id = $request->vote_typeID;
        // $save_participants->position_id = $request->apply_Position_id;
        // $save_participants->candidate_parties_id = $request->applicant_parties;
        // $save_participants->participant_id = $request->applicant;

        if($checkParty_participants && $request->applicant_parties != ""){

            return response()->json(['status' => 400]);

        }else{

            elect_participants_model::updateOrCreate(
                [
                    'open_typeID' => $request->open_typeID,
                    'participant_id' => $request->applicant
                ],
                [
                    'type_id' => $request->vote_typeID,
                    'candidate_parties_id' => $request->applicant_parties,
                    'position_id' => $request->apply_Position_id,
                    'active' => 1
                ]
                
            );

            // $save_participants->updateCreate(['participant_id' => $request->applicant, 'type_id' => $request->vote_typeID]);
            return response()->json(['status' => 200]);

        }
       

        


    }

    public function set_openVoting_date(Request $request){

        // dd($request->all());
        $open_Application_id = $request->open_Application_id;
        $typeID = $request->voteTypeID;
        $openDate = $request->openDate;
        $closeDate = $request->closeDate;
        $openTime = $request->openTime;
        $closeTime = $request->closeTime;

        open_voting_model::updateOrCreate(
            ['type_id' => $typeID],
            [
                'open_applicationID' =>  $open_Application_id,
                'open_date' => $openDate . '-' . $openTime,
                'close_date' => $closeDate . '-' . $closeTime,
                'status' => 1
            ]
        );
        return response()->json(["status" => 200]);


    }

    public function changeSelectApplicant(Request $request){
       
        $parties = [];
        $check_ifApplied = elect_participants_model::where('type_id', $request->typeID)->where('participant_id', $request->applicant_id)->where('active', 1)->first();

        $applied = 0;
        $participated_id = 0;
        $candidate_parties_id = '';
        if($check_ifApplied){
            $applied = 1;
            $participated_id = $check_ifApplied->position_id;
            $candidate_parties_id = $check_ifApplied->candidate_parties_id;
        }


        $check_member_parties = candidate_parties_member_model::with('getParties')->where('candidate', $request->applicant_id)->where('active', 1)->get();


        if ($check_member_parties->count() > 0) {

            foreach ($check_member_parties as $party) {

                $parties_name = '';
                if($party->getParties) {
                    $parties_name = $party->getParties->parties;
                }else{
                    $parties_name = 'No Parties';
                }
                $td = [
                        'parties_id' => $party->parties_id,
                        'parties_name' => $parties_name,
                ];

                $parties[count($parties)] = $td;
            }



        }else{
            $td = [
                'parties_id' => 0,
                'parties_name' => 'No Parties',
            ];

            $parties[count($parties)] = $td;
        }

        $responseData = [
            'parties' => $parties,
            'applied' => $applied,
            'participated_id' => $participated_id,
            'candidate_parties_id' => $candidate_parties_id
        ];

        echo json_encode($responseData);


    }

    public function loadCandidateList(Request $request) {
        $candidateProfile = '';
        $candidateList = '';

        $employee_admin = auth()->guard('employee_guard')->user() ? true : false;

        if(!$employee_admin){

            $check_ifCandidate = elect_participants_model::where('type_id', $request->type_id)
            ->where('participant_id', auth()->user()->studid)
            ->where('active', true)->exists();
            // $participants = elect_participants_model::where('type_id', $request->type_id)->where('active', true)->get();
            // dd($participants);
            if($check_ifCandidate){
                $participants = enrollment_list::where('studid', auth()->user()->studid)->where('active', true)->first();
            if($participants){

                $pa = elect_participants_model::with('get_position')->where('participant_id', $participants->studid)->where('active', true)->first();
                $position = $pa->get_position ? $pa->get_position : null;

                $position = $pa->get_position;

                $img_src = get_candidate_profile_image($participants->studid);
                $candidate_party = candidateParty($participants->studid);
                $party_name = 'No Parties';
                if($candidate_party){
                    $party_name = $candidate_party->parties;
                }

                $candidateProfile .= '<div class="flex flex-col lg:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                <div class="w-24 h-24 lg:w-24 lg:h-24 image-fit lg:mr-1">
                    <img id="previewImage" alt="Selected Image" class="rounded-full" src='.$img_src .'>
                <label for="fileInput">
                    <div class="absolute mb-1 mr-1 flex items-center justify-center bottom-0 right-0 bg-primary rounded-full p-2 cursor-pointer" title="Change Profile">
                        <i class="fa-solid fa-camera w-4 h-4 text-white"></i>
                        <input id="fileInput" name="fileInput" hidden type="file" accept="image/*" onchange="previewFile()">
                    </div>
                </label>
                </div>
                <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                <a href="javascript:;" class="font-large">'.$participants->fullname.'</a> 
                <div class="text-slate-500 text-xs mt-0.5">'.$party_name.'</div>
                </div>
                <div class="flex -ml-2 lg:ml-0 lg:justify-end mt-3 lg:mt-0">
                <a href="javascript:;" class="flex items-center justify-center zoom-in tooltip">'.$position->vote_position.' </a>

                </div>
                </div>';
            }
            }else{
                $candidateProfile = '';
            }
            $participantsss = elect_participants_model::with('get_student_applicants', 'get_position')->where('type_id', $request->type_id)->get();

            // Filter out the participant matching the authenticated user's studid
            $filteredParticipants = $participantsss->filter(function ($participant) {
                return $participant->participant_id != auth()->user()->studid;
            });
            $candidateList .= '<div class="box p-5 rounded-md">
                    
            '.$candidateProfile.'

            <div class="px-4 pb-3 overflow-y-auto h-half-screen">
            <table class="table table-striped">
            <thead>

                <th class="whitespace-nowrap !py-5">Candidate Name</th>
                <th class="whitespace-nowrap text-right">Position Applied</th>
                <th class="whitespace-nowrap text-center">Status</th>

            </thead>
            <tbody>';

            foreach($filteredParticipants as $participant){
            
                $participated = $participant->get_student_applicants;
                $position = $participant->get_position;

                $img_src = get_candidate_profile_image($participant->participant_id);

                $candidate_party = candidateParty($participant->participant_id);
                $party_name = 'No Parties';
                if($candidate_party){
                    $party_name = $candidate_party->parties;
                }

                $active = 'Inactive';
                $color = 'danger';
                $checked = '';
                if($participant->active == 1){
                    $active = 'Active';
                    $color = 'success';
                    $checked = 'checked';
                }

                $positionname = 'Position Not Exists';
                if( $position){
                    $positionname =$position->vote_position;
                }

                $candidateList .= '<tr>

                    <td class="!py-4">

                        <div class="flex items-center">
                            <div class="w-10 h-10 image-fit zoom-in">
                                <img alt="Midone - HTML Admin Template" data-action="zoom" class="rounded-lg border-2 border-white shadow-md tooltip" src="'.$img_src .'">
                            </div>
                            <div class="ml-4">
                                <a href="javascript:;" class="font-medium whitespace-nowrap">'.$participated->fullname.'</a> 
                                <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">Group: '. $party_name.'</div>
                            </div>
                        </div>

                    </td>

                    <td class="text-right">'.$positionname.'</td>

                    <td class="whitespace-nowrap text-right">

                        <div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
                            <label class="form-check-label text-'.$color.'" for="inactivecandidate">'.$active.'</label>
                           
                        </div>
                    
                    </td>
                    
                </tr>';
            }

            $candidateList .= '</tbody>
            </table>
            </div>
            </div>';

        }else{

            $participantsss = elect_participants_model::with('get_student_applicants', 'get_position')->where('type_id', $request->type_id)->get();

            $candidateList .= '<div class="box p-5 rounded-md">
                    
            '.$candidateProfile.'

            <div class="px-4 pb-3 overflow-y-auto h-half-screen">
            <table class="table table-striped">
            <thead>

                <th class="whitespace-nowrap !py-5">Candidate Name</th>
                <th class="whitespace-nowrap text-right">Position Applied</th>
                <th class="whitespace-nowrap text-center">Status</th>

            </thead>
            <tbody>';

            foreach($participantsss as $participant){
            
                $participated = $participant->get_student_applicants;
                $position = $participant->get_position;

                $img_src = get_candidate_profile_image($participant->participant_id);

                $candidate_party = candidateParty($participant->participant_id);
                $party_name = 'No Parties';
                if($candidate_party){
                    $party_name = $candidate_party->parties;
                }

                $active = 'Inactive';
                $color = 'danger';
                $checked = '';
                if($participant->active == 1){
                    $active = 'Active';
                    $color = 'success';
                    $checked = 'checked';
                }

                $positionname = 'Position Not Exists';
                if( $position){
                    $positionname =$position->vote_position;
                }

                
                $check_if_vote_start = open_voting_model::where('type_id', $request->type_id)->first();

                $now = now()->setTimezone('Asia/Manila');
                $current_date = $now->format('m-d-Y g:iA');
                
                $encrypted_typeID = '';
                $encrypted_participantID = '';
                $inactivecandidate = '';
                $disabled = '';
                
                if (!$check_if_vote_start || ($check_if_vote_start && $current_date > $check_if_vote_start->open_date)) {
                    $checkSupported_participants = supported_candidate_model::where('type_id', $participant->type_id)
                        ->where('candidates', $participant->participant_id)
                        ->where('position_id', $participant->position_id)
                        ->where('active', 1)
                        ->exists();
                
                    if (!$checkSupported_participants) {
                        $encrypted_typeID = Crypt::encryptString($request->type_id);
                        $encrypted_participantID = Crypt::encryptString($participant->participant_id);
                        $inactivecandidate = 'inactivecandidate';                        
                    } else {
                        $disabled = 'disabled';
                    }
                }else{
                    $disabled = 'disabled';
                }
                

                
                   

                $candidateList .= '<tr>

                    <td class="!py-4">

                        <div class="flex items-center">
                            <div class="w-10 h-10 image-fit zoom-in">
                                <img alt="Midone - HTML Admin Template" data-action="zoom" class="rounded-lg border-2 border-white shadow-md tooltip" src="'.$img_src .'">
                            </div>
                            <div class="ml-4">
                                <a href="javascript:;" class="font-medium whitespace-nowrap">'.$participated->fullname.'</a> 
                                <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">Group: '. $party_name.'</div>
                            </div>
                        </div>

                    </td>

                    <td class="text-right">'.$positionname.'</td>

                    <td class="whitespace-nowrap text-right">

                        <div class="form-check form-switch w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0">
                            <label class="form-check-label text-'.$color.'" for="inactivecandidate">'.$active.'</label>
                            <input id="'.$inactivecandidate.'" data-t="'.$encrypted_typeID.'" value="'.$encrypted_participantID.'" class="form-check-input mr-0 ml-3" type="checkbox" '.$checked.' '.$disabled.'>
                        </div>
                    
                    </td>
                    
                </tr>';
            }

            $candidateList .= '</tbody>
            </table>
            </div>
            </div>';
            
        }

        echo $candidateList;
        
       

    }

    public function uploadParticipants_profile(Request $request){
        // dd($request->all());
        try {
            // dd($request->hasFile('fileInput'));
            if ($request->hasFile('fileInput')) {
                $image = $request->file('fileInput');
                $originalName = $image->getClientOriginalName();
        
                // Sanitize the filename if needed
                // $cleanedName = Str::slug(pathinfo($originalName, PATHINFO_FILENAME));
        
                $timestamp = time();
                $uniqueId = uniqid();
                $newFilename = $originalName;    
                $type_id = $request->type_id;
        
                // Store the file
                $image->storeAs('candidate_profile', $newFilename, 'uploads');

                elect_participants_model::where('participant_id', auth()->user()->studid)->update(['profile' => $newFilename]);
        
                // You can store the $imagePath in your database or return it as a JSON response
                return response()->json(['status' => 200, 'type_id' => $type_id]);
            }
        
            return response()->json(['error' => 'No file uploaded.'], 400);
        } catch (\Exception $e) {
            // Handle exceptions
            dd($e);
        }
    }

    public function handleActiveCandidate(Request $request){

        $type_id = $request->type_id;
        $participant = $request->participant;
        $isChecked = $request->isCheck;

        try {

            $decrypted_type_id = Crypt::decryptString($type_id);
            $decrypted_participant = Crypt::decryptString($participant);
            $elect = elect_participants_model::where('participant_id', $decrypted_participant)
            ->where('type_id', $decrypted_type_id);
            
            if($isChecked == "true"){
                
                $elect->update(['active' => 1]);
            }else{
                
                $elect->update(['active' => 0]);
            }

            return response()->json(['status' => 200, 'type_id' => $decrypted_type_id]);

        } catch (DecryptException $e) {
            dd($e);
        }
        
    }


}
