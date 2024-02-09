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
use App\Models\ASIS_Models\vote\supported_candidate_model;
use App\Models\ASIS_Models\vote\signatory_model;
use App\Models\ASIS_Models\vote\assign_voters;
use App\Models\User;
use Carbon\Carbon;
use PDF;
// use App\Models\ASIS_Models\system\default_setting;
// use App\Models\ASIS_Models\HRIS_model\employee;

class electionResultController extends Controller
{
    public function resultPage(){
        return view('vote.electionResult_page');
    }

    public function filter_type_position($type_id){
        $positionData = [];
        $position_type = assignPosition_model::with('getElect_position')->where('typeID', $type_id)->where('active', 1)->get();

        if($position_type->count() > 0){
            foreach ($position_type as $assigned_position) {
                $positio_name = '';
                if($assigned_position->getElect_position){
                    $positio_name = $assigned_position->getElect_position->vote_position;
                }

                    $td = [

                            "postition_id" => $assigned_position->positionID,
                            "position_name" => $positio_name,

                          ];

                $positionData[count($positionData)] = $td;

            }
            echo json_encode($positionData);
        }



    }

    public function fetch_candidate_by_type($type_id){
        $output = '';
        $contain_data = 0;

        $assign_postion = '';


        $assign_postion = assignPosition_model::with('getElect_position')
                                                ->where('typeID', $type_id)
                                                ->get();


        if ( $assign_postion->count() > 0 ) {

            $check_is_voted = supported_candidate_model::where('type_id', $type_id)->where('active', 1)->get();

            if($check_is_voted->count() > 0){

                $contain_data = 1;

                foreach ($assign_postion as $position) {

                    $position_name = '';
                    if($position->getElect_position){
                        $position_name = $position->getElect_position->vote_position;
                    }

                    $output .= '<div class="intro-y box lg:mt-5">
                        <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                            <h2 class="font-medium text-base mr-auto">
                                '.$position_name.'
                            </h2>
                        </div>
                        <div id="candidate_div" class="grid grid-cols-12 gap-6 mt-5">';



                            $participants = elect_participants_model::with('get_student_applicants', 'get_position')->where('type_id', $type_id)->where('position_id', $position->positionID)->where('active', 1)->get();
                            if($participants->count() > 0){

                                $Count_enrolled_voters = 0;
                                $voter_assign = assign_voters::with('get_enrolledList')->where('type_id', $type_id)->where('active', 1)->get();
                                foreach ($voter_assign as $assign_voter) {
                                    $enrolled_list = $assign_voter->get_enrolledList;
                                    if($enrolled_list->count() > 0){
                                        $Count_enrolled_voters += $enrolled_list->count();
                                    }

                                }

                                // dd($Count_enrolled_voters);
                                foreach ($participants as $participant) {

                                    $candidate_name = '';

                                    if($participant->get_student_applicants){
                                        $candidate_name = $participant->get_student_applicants->fullname;
                                    }else{
                                        $candidate_name = 'No Data Found';
                                    }

                                    $position_name = '';
                                    if($participant->get_position){
                                        $position_name = $participant->get_position->vote_position;
                                    }else{
                                        $position_name = 'No Position Found';
                                    }

                                    $participant_id =  $participant->participant_id;
                                    // $image = get_profile_image($participant_id);
                                    $image = get_candidate_profile_image($participant_id);

                                    $voting_result = supported_candidate_model::where('type_id', $participant->type_id)->where('candidates',  $participant->participant_id)->get();
                                    $vote_count = $voting_result->count();

                                    // $count_voters = User::where('active', 1)->get()->count();;
                                    // $voters_count = $count_voters;

                                    $percent = ($vote_count/$Count_enrolled_voters)*100;

                                    $formatted_percent = number_format($percent, 2);

                                    $progress_bar = $formatted_percent / 100;
                                    $progress_width = min($progress_bar * 100, 100);

                                        $output .= '<div class="intro-y col-span-12 md:col-span-4">
                                                        <div class="box">
                                                            <div class="flex flex-col lg:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                                                            <div class="w-24 h-24 lg:w-24 lg:h-24 image-fit lg:mr-1">
                                                            <img id="previewImage" alt="Selected Image" data-action="zoom" class="rounded-full" src='.$image .'>
                                                        </div>
                                                                <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                                                                    <a href="javascript:;" class="font-medium">'.$candidate_name.'</a>
                                                                    <div class="text-slate-500 text-xs mt-0.5"> For: '.$position_name.'</div>
                                                                </div>
                                                                <div class="mt-6 lg:mt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-0 border-slate-200/60 dark:border-darkmode-400 pt-5 lg:pt-0">

                                                                    <div class="text-center rounded-md w-20 py-3">
                                                                        <div class="font-medium text-primary text-xl">'.$vote_count.'</div>
                                                                        <div class="text-slate-500">Votes</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="flex flex-wrap lg:flex-nowrap items-center justify-center p-5">
                                                                <div class="w-full lg:w-full mb-4 lg:mb-0 mr-auto">
                                                                    <div class="flex text-slate-500 text-xs">
                                                                        <div class="mr-auto">Vote Progress</div>
                                                                        <div>'.  $formatted_percent.'%</div>
                                                                    </div>
                                                                    <div class="progress h-1 mt-2">
                                                                        <div class="progress-bar" style="width: ' . $progress_width . '%; background-color: #1E40AF;"></div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>';

                                }
                            }else{
                                $output .= '<div class="intro-y col-span-12 md:col-span-12">
                                    <div class="box">
                                        <div class="flex flex-col lg:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">

                                            <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0 flex-grow">
                                                <a href="javascript:;" class="font-medium">No Participants Found of this Position</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>';
                            }
                        $output .= '</div>
                    </div>';

                }
            }else{

                $contain_data = 0;

                $output .= '<div id="enrollmentSuccess" class="">
                                <div class="intro-y box py-10 sm:py-20 mt-5 bg-green-100 border-green-200 dark:bg-green-900 dark:border-green-800 animate-fade-in">
                                    <div class="text-center mb-4">
                                        <i class="fas fa-exclamation-triangle fa-beat text-warning h-10 w-10"></i><!-- <i class="fas fa-check-circle text-success text-4xl mx-auto animate-color-change fa-beat"></i> Font Awesome fontawesome.com -->
                                        <h2 class="text-2xl font-semibold mt-2">No Result to This Election </h2>
                                    </div>
                                    <div class="text-center text-green-700 mt-4">

                                    </div>
                                    <div class="flex items-center justify-center mt-6">

                                    </div>
                                </div>
                            </div>';
            }
        }else{
            $output .= '<div id="enrollmentSuccess" class="">

                                <div class="intro-y box py-10 sm:py-20 mt-5 bg-green-100 border-green-200 dark:bg-green-900 dark:border-green-800 animate-fade-in">
                                    <div class="text-center mb-4">
                                        <i class="fas fa-exclamation-triangle fa-beat text-warning h-10 w-10"></i><!-- <i class="fas fa-check-circle text-success text-4xl mx-auto animate-color-change fa-beat"></i> Font Awesome fontawesome.com -->
                                        <h2 class="text-2xl font-semibold mt-2">No Found Position of this Election</h2>
                                    </div>
                                    <div class="text-center text-green-700 mt-4">

                                    </div>
                                    <div class="flex items-center justify-center mt-6">

                                    </div>
                                </div>
                            </div>';


        }


        $response = array("contain_data" => $contain_data, "output" => $output);

        echo json_encode($response);

    }

    public function fetch_leaderBoard($type_id){
        $leading = '';
        $assign_postion = assignPosition_model::with('getElect_position')
                                                    ->where('typeID', $type_id)
                                                    ->get();
        if($assign_postion->count() > 0){

            $check_is_voted = supported_candidate_model::where('type_id', $type_id)->where('active', 1)->get();

            if($check_is_voted->count() > 0){
                foreach($assign_postion as $position){
                    $position_name = '';
                    if($position->getElect_position){
                        $position_name = $position->getElect_position->vote_position;
                    }


                    $leading .= '<div class="position-container">
                        <div class="intro-x flex items-center h-10">
                            <h2 class="text-base font-medium truncate mr-5">
                            '.$position_name.'
                            </h2>
                        </div>
                        <div class="mt-5">';

                        $participants = elect_participants_model::with('get_student_applicants', 'get_position')
                                                                ->where('type_id', $type_id)
                                                                ->where('position_id', $position->positionID)
                                                                ->where('active', 1)
                                                                ->get();

                                                                $highestVoteCount = 0; // Initialize with a value lower than any possible vote count
                                                                $participantWithHighestVotes = null;
                                                                $tiedParticipants = [];

                                                                foreach ($participants as $participant) {
                                                                    $voting_result = supported_candidate_model::where('type_id', $type_id)
                                                                        ->where('candidates',  $participant->participant_id)
                                                                        ->get();

                                                                    $vote_count = $voting_result->count();

                                                                    if ($vote_count > $highestVoteCount) {
                                                                        $highestVoteCount = $vote_count;
                                                                        $tiedParticipants = []; // Reset tied participants when a new highest is found
                                                                        $participantWithHighestVotes = $participant;
                                                                    } elseif ($vote_count === $highestVoteCount) {
                                                                        $tiedParticipants[] = $participant;
                                                                    }
                                                                }

                                                                if ($participantWithHighestVotes !== null && empty($tiedParticipants)) {
                                                                    // Participant with the highest votes found

                                                                    $participant_id = $participantWithHighestVotes->participant_id;

                                                                    $candidate = $participantWithHighestVotes->get_student_applicants;
                                                                    if ($candidate) {
                                                                        $participant_name = $candidate->fullname;
                                                                    } else {
                                                                        $participant_name = 'No Data Found';
                                                                    }

                                                                    $image = get_candidate_profile_image($participant_id);

                                                                    $leading .= '<div class="intro-y col-span-12 md:col-span-4">
                                                                                    <div class="box">
                                                                                        <div class="flex flex-col lg:flex-row items-center p-2 border-b border-slate-200/60 dark:border-darkmode-400">
                                                                                            <div class="text-center rounded-md w-20 py-3">
                                                                                                <img alt="Midone - HTML Admin Template" data-action="zoom" src="' . $image . '">
                                                                                            </div>
                                                                                            <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                                                                                                <a href="" class="font-medium">' . $participant_name . '</a>
                                                                                                <div class="text-slate-500 text-xs mt-0.5"></div>
                                                                                            </div>
                                                                                            <div class="mt-6 lg:mt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-0 border-slate-200/60 dark:border-darkmode-400 pt-5 lg:pt-0">

                                                                                                <div class="text-center rounded-md w-20 py-3">
                                                                                                    <div class="font-medium text-success text-xl">'.$highestVoteCount.'</div>
                                                                                                    <div class="text-slate-500">Votes</div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                    </div>
                                                                                </div>';
                                                                } else {
                                                                    if ($highestVoteCount === 0) {
                                                                        $leading .= '<div class="intro-y col-span-12 md:col-span-4">
                                                                                        <div class="box">
                                                                                            <div class="flex flex-col lg:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                                                                                                <div class="w-24 h-24 lg:w-12 lg:h-12 image-fit lg:mr-1">
                                                                                                </div>
                                                                                                <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                                                                                                    <a href="" class="font-medium">No Applicants Found</a>
                                                                                                    <div class="text-slate-500 text-xs mt-0.5"></div>
                                                                                                </div>
                                                                                                <div class="mt-6 lg:mt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-0 border-slate-200/60 dark:border-darkmode-400 pt-5 lg:pt-0">

                                                                                                    <div class="text-center rounded-md w-20 py-3">
                                                                                                        <div class="font-medium text-primary text-xl"></div>
                                                                                                        <div class="text-slate-500"></div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>';
                                                                    } else {
                                                                        $leading .= '<div class="intro-y col-span-12 md:col-span-4">
                                                                                        <div class="box">
                                                                                            <div class="flex flex-col lg:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                                                                                                <div class="w-24 h-24 lg:w-12 lg:h-12 image-fit lg:mr-1">
                                                                                                </div>
                                                                                                <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                                                                                                    <a href="" class="font-medium">Tie Between All Participants</a>
                                                                                                    <div class="text-slate-500 text-xs mt-0.5"></div>
                                                                                                </div>
                                                                                                <div class="mt-6 lg:mt-0 flex-1 flex items-center justify-center px-5 border-t lg:border-0 border-slate-200/60 dark:border-darkmode-400 pt-5 lg:pt-0">

                                                                                                    <div class="text-center rounded-md w-20 py-3">
                                                                                                        <div class="font-medium text-success text-xl">'.$highestVoteCount.'</div>
                                                                                                        <div class="text-slate-500">Votes</div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>';
                                                                    }
                                                                }




                        $leading .= '</div>
                    </div>';

                }
            }
            echo $leading;
        }

    }

    public function print_vote_result(Request $request){
        // dd($request->all());
        $type_id = $request->type_id;
        $to_print = $request->to_print;

        $election_name = '-- Pangalan ni sa Election';

        $electionType = voteType_model::where('id', $type_id)->first();

        if($electionType){
            $election_name = $electionType->vote_type;
        }else{
            $election_name = 'No Data Found';
        }

        $assign_postions = assignPosition_model::with('getElect_position')
        ->where('typeID', $type_id)
        ->get();


        $signatoryDatas = signatory_model::with('get_signatory')->where('type_id', $type_id)->where('active', 1)->get();


        //PRINT ALL IN PARTICULAR ELECTION TYPE
        if($request->to_print == 1){

        }else{

            //PRINT THE DECLAIRED WINNER
        }
        $from = '';
        $to = '';
        $status_text = '';
        $now = date('m/d/Y g:ia');
        $datetime = Carbon::createFromFormat('m/d/Y g:ia', $now);
        $datetime->setTimezone('Asia/Manila');
        $current_date = $datetime->format('m-d-Y g:iA');

        $filename = 'Voting Result';

        // $long_BondPaper = array(0, 0, 612.00, 936.0);
        $system_image_header ='';
        $system_image_footer ='';

        if(system_settings()){
            $system_image_header = system_settings()->where('key','image_header')->first();
            $system_image_footer = system_settings()->where('key','image_footer')->first();
        }

        // dd($type_id);

        $pdf = PDF::loadView('vote.print_result.print_vote_result',
                    compact('system_image_header', 'system_image_footer',
                            'filename','current_date','status_text','type_id',
                            'to_print','election_name','assign_postions',
                            'signatoryDatas'
                            ))
                    ->setPaper('legal','portrait');

        return $pdf->stream($filename . '.pdf');
    }

}


