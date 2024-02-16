<?php

namespace App\Http\Controllers\vote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ASIS_Models\vote\voteType_model;
use App\Models\ASIS_Models\vote\votePosition_model;
use App\Models\ASIS_Models\vote\voteOpenApplication_Model;
use App\Models\ASIS_Models\vote\assignPosition_model;
use App\Models\ASIS_Models\vote\elect_participants_model;
use App\Models\ASIS_Models\vote\supported_candidate_model;
use App\Models\ASIS_Models\vote\open_voting_model;
use App\Models\ASIS_Models\vote\signatory_model;
use App\Models\ASIS_Models\vote\candidate_parties_member_model;
use App\Models\ASIS_Models\enrollment\enrollment_list;
use App\Models\ASIS_Models\posgres\portal\srgb\program;
use App\Models\ASIS_Models\posgres\enrollment\srgb\semstudent;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

use App\Models\ASIS_Models\vote\assign_voters;

class voteController extends Controller
{
    //
     // ========= VOTING PARTICIPANT  ========== //

     public function election_voting(){

        return view('vote.electionParticipants_page');

    }

    public function fetchElectionVoting(){
        $voting_typeData = [];

        $check_to_enrroledList = enrollment_list::where('studid', auth()->user()->studid)->first();

        if ($check_to_enrroledList) {
            $studMajor = trim($check_to_enrroledList->studmajor);
            $ElectionParticipantsDatas = open_voting_model::with('getVoting_type')
                ->where('active', 1)
                ->latest('created_at')->get();

            if ($ElectionParticipantsDatas->count() > 0) {
                foreach ($ElectionParticipantsDatas as $ElectionParticipantsData) {
                    $voteType = $ElectionParticipantsData->getVoting_type;

                    if ($voteType) {
                        $election_exist = assign_voters::where('type_id', $ElectionParticipantsData->type_id)->where('prog_code', $studMajor)->where('active', 1)->exists();
                        if ($election_exist) {
                            $getCandidates_data = supported_candidate_model::where('type_id', $ElectionParticipantsData->type_id)->get();
                            $count_candidate_date = $getCandidates_data->count();

                            $this_candidate = ($count_candidate_date > 0) ? 1 : 0;

                            $is_voted = supported_candidate_model::where('type_id', $ElectionParticipantsData->type_id)
                                ->where('supported_by', auth()->user()->studid)
                                ->count() > 0 ? 1 : 0;

                            $check_vote_closeDate = $ElectionParticipantsData->close_date;
                            $check_vote_openDate = $ElectionParticipantsData->open_date;
                            $currentDateTime = date('Y-m-d H:i:s');

                            $openVoting_status = '';
                            if ($currentDateTime > $check_vote_closeDate) {
                                $openVoting_status = 'end';
                            } else if ($currentDateTime < $check_vote_closeDate && $currentDateTime > $check_vote_openDate) {
                                $openVoting_status = 'open';
                            } else {
                                $openVoting_status = 'coming';
                            }

                            $vote_typeName = $voteType->vote_type ?: 'No Longer in Voting Type';

                            $td = [
                                "vote_typeID" => $ElectionParticipantsData->type_id,
                                "Vote_typeName" => $vote_typeName,
                                "is_voted" => $is_voted,
                                "openVoting_status" => $openVoting_status,
                                "this_candidate" => $this_candidate,
                            ];

                            $voting_typeData[] = $td;
                        }
                    }
                }
            }
        }

        echo json_encode($voting_typeData);
    }

    public function fetch_openVoting_type_position(Request $request){

            $typePosition = '';

            $is_voted = 0;
            $check_isVoted = supported_candidate_model::where('type_id', $request->type_id)->where('supported_by', auth()->user()->studid)->get();
            $check_isVoted_count = $check_isVoted->count();

            $getTyposition = assignPosition_model::with('getElect_position')->where('typeID', $request->type_id)->get();

            
            if($check_isVoted_count > 0){

                $is_voted = 1;                

            }else{

                $is_voted = 0;
            }

            if($getTyposition->count() > 0){
                foreach ($getTyposition as $type_position) {

                    $positionName = '';
                    if($type_position->getElect_position){
                        $positionName = $type_position->getElect_position->vote_position;
                    }
                    $clr_selection = '';
                    if($is_voted != 1){
                        $clr_selection = '<a id="'.$type_position->positionID.'" data-position-name="'.$positionName.'" href="javascript:;"  class="revert_vote zoom-in">
                            <i class="fa fa-undo text-success" aria-hidden="true"></i>
                            <span id="clr_selection" class="text-slate-500 underline  text-small">Clear Selection</span>
                        </a>';
                    }


                    $typePosition .= ' <div class="border border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                            <div id="vote_position_div" style="font-size: 12px" class="font-medium text-base font-bold text-md flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5">
                                                <i data-lucide="chevron-down" class="w-4 h-4 mr-2"></i>
                                                '.$positionName.'
                                                <span class="ml-auto">
                                                    '.$clr_selection.'
                                                </span>
                                            </div>
                                            <div class="mt-2">

                                                <div class="w-full mt-3 xl:mt-0 flex-1">
                                                    <div class="grid grid-cols-12 gap-6 mt-5">';


                                                        if ($is_voted == 1) {
                                                            $getCandidates = supported_candidate_model::with('getCandidate')->where('type_id', $request->type_id)->where('position_id', $type_position->positionID)->where('supported_by', auth()->user()->studid)->first();

                                                            if ($getCandidates) {

                                                                $participant_id =  $getCandidates->candidates;
                                                                $image = get_profile_image($participant_id);

                                                                $check_parties = elect_participants_model::with('get_parties')->where('participant_id', $participant_id)->where('type_id',$request->type_id)->where('active', 1)->first();
                                                                $parties_name = '';
                                                                if( $check_parties){

                                                                    if($check_parties->candidate_parties_id != 0){

                                                                        if( $check_parties->get_parties){
                                                                            $parties_name = $check_parties->get_parties->parties;
                                                                        }else{
                                                                            $parties_name = 'parties no found';
                                                                        }

                                                                    }else{
                                                                        $parties_name = 'Independent';
                                                                    }
                                                                }

                                                                    $candidateName = '';
                                                                    if($getCandidates->getCandidate){
                                                                        $candidateName = $getCandidates->getCandidate->fullname;
                                                                    }

                                                                    $typePosition .= ' <div  for="'.$positionName.'-'.$getCandidates->participant_id.'" class="candidate_div intro-y col-span-12 md:col-span-6 cursor-pointer zoom-in">
                                                                        <div class="box">
                                                                            <div class="flex flex-col lg:flex-row items-center p-5">
                                                                                <div class="w-24 h-24 lg:w-12 lg:h-12 image-fit lg:mr-1">
                                                                                    <img alt="Midone - HTML Admin Template" data-action="zoom" class="zoomed-image rounded-full" src="'. $image.'" style="z-index: 1000;">
                                                                                </div>
                                                                                <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                                                                                    <a id="'.$getCandidates->participant_id.'" href="javascript:;" class="font-medium candidateName">'.$candidateName.'</a>
                                                                                    <div class="text-slate-500 text-xs mt-0.5">Parties: '.$parties_name.'</div>
                                                                                </div>
                                                                                <div class="flex mt-4 lg:mt-0">
                                                                                    <input id="'.$positionName.'-'.$getCandidates->participant_id.'"
                                                                                     class="form-check-input" type="radio"
                                                                                     name="'.$type_position->positionID.'"
                                                                                     data-position-name="'.$positionName.'"
                                                                                     data-candidate-name="'.$candidateName.'"
                                                                                     value="'.$getCandidates->participant_id.'" checked disabled>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>';

                                                            }else{
                                                                $typePosition .= '<div style="font-size: 10px" class="intro-y col-span-12 md:col-span-4 ml-5">

                                                                                            <label class="form-check-label">You Choose None to this Position </label>
                                                                                    </div>';
                                                            }

                                                        }else{

                                                            $getCandidates = elect_participants_model::with('get_student_applicants')->where('type_id', $request->type_id)->where('position_id', $type_position->positionID)->get();
                                                            if ($getCandidates->count() > 0) {



                                                                foreach ( $getCandidates as $candidate) {

                                                                    $participant_id =  $candidate->participant_id;
                                                                    // $image = get_profile_image($participant_id);
                                                                    $img_src = get_candidate_profile_image($participant_id);


                                                                    $candidateName = '';
                                                                    if($candidate->get_student_applicants){
                                                                        $candidateName = $candidate->get_student_applicants->fullname;
                                                                    }

                                                                    $check_parties = elect_participants_model::with('get_parties')->where('participant_id', $participant_id)->where('type_id',$request->type_id)->where('active', 1)->first();
                                                                    $parties_name = '';
                                                                    if( $check_parties){

                                                                        if($check_parties->candidate_parties_id != 0){

                                                                            if( $check_parties->get_parties){
                                                                                $parties_name = $check_parties->get_parties->parties;
                                                                            }else{
                                                                                $parties_name = 'parties no found';
                                                                            }

                                                                        }else{
                                                                            $parties_name = 'Independent';
                                                                        }
                                                                    }


                                                                    $typePosition .= '<div id="'.$positionName.'-'.$candidate->participant_id.'" class="candidate_div intro-y col-span-12 md:col-span-6 cursor-pointer zoom-in">
                                                                        <div class="box">
                                                                            <div class="flex flex-col lg:flex-row items-center p-5">
                                                                                <div class="w-24 h-24 lg:w-12 lg:h-12 image-fit lg:mr-1">
                                                                                    <img alt="Midone - HTML Admin Template" data-action="zoom" class="zoomed-image rounded-full" src="'.$img_src.'">
                                                                                </div>
                                                                                <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                                                                                    <a id="'.$participant_id.'" href="javascript:;" class="font-medium candidateName">'.$candidateName.'</a>
                                                                                    <div class="text-slate-500 text-xs mt-0.5">'.$parties_name.'</div>
                                                                                </div>
                                                                                <div class="flex mt-4 lg:mt-0">
                                                                                    <input id="'.$positionName.'-'.$candidate->participant_id.'"
                                                                                        class="form-check-input" type="radio"
                                                                                        name="'.$type_position->positionID.'"
                                                                                        data-position-name="'.$positionName.'"
                                                                                        data-candidate-name="'.$candidateName.'"
                                                                                        value="'.$candidate->participant_id.'">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>';
                                                                }
                                                            }else{
                                                                $typePosition .= '<div style="font-size: 10px" class="intro-y col-span-12 md:col-span-4 text-align-center">
                                                                                        <label class="ml-5">No Candidate Applied for this Position</label>
                                                                                </div>';
                                                            }

                                                        }




                                            $typePosition .= '</div>
                                                </div>

                                            </div>
                                        </div>';
                }

                echo $typePosition;
            }






    }

    public function save_selected_applicants(Request $request) {

        // dd($request->request->all());

        foreach ($request->except('_token', 'voteTypeID', 'position_id') as $position => $candidateId) {

            $saveSupported_candidate = new supported_candidate_model;
            $saveSupported_candidate->type_id = $request->voteTypeID;
            $saveSupported_candidate->position_id = $position; // Use the current position ID
            $saveSupported_candidate->candidates = $candidateId;
            $saveSupported_candidate->supported_by = auth()->user()->studid;
            $saveSupported_candidate->save();
        }

        return response()->json(['status' => 200]);
    }
}
