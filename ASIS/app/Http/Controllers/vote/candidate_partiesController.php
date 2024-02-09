<?php

namespace App\Http\Controllers\vote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

use App\Models\ASIS_Models\vote\candidate_parties_model;
use App\Models\ASIS_Models\vote\candidate_parties_member_model;

class candidate_partiesController extends Controller
{
    public function election_parties_page(){
        return view('vote.candidate_parties_page');
    }

    public function add_candidateParties_page(Request $request){
        // dd($request->all());
        try {
            $saverated = new candidate_parties_model;
            $saverated->parties = $request->input('parties_name');
            $saverated->desc = $request->input('partiesDescription');

            // dd($request->parties_id);
            if ($request->parties_id !== null) {

                $paties_id = Crypt::decryptString($request->parties_id);

                $voteType = candidate_parties_model::where('id', $paties_id);
                if ($voteType) {
                    $voteType->update([
                        'parties' => $request->input('parties_name'),
                        'desc' => $request->input('partiesDescription'),
                    ]);
                    return response()->json(['status' => 'updated']);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Candidate Parties not found']);
                }
            } else {

                $saverated->save();
                return response()->json(['status' => 'saved']);
            }
        } catch (DecryptException $e) {
            dd($e);
        }

    }

    public function load_candidateParties_page(){
        try {
            $parties = [];
            $candidateParties = candidate_parties_model::where('active', 1)->latest('created_at')->get();

            if($candidateParties->count() > 0){
                foreach($candidateParties as $party) {

                    $parties_member = candidate_parties_member_model::where('parties_id', $party->id)->where('active', 1)->get();
                    $parties_memberCount = 0;
                    if($parties_member->count() > 0){
                        $parties_memberCount = $parties_member->count();
                    }

                    $paties_id = Crypt::encryptString($party->id);
                    $parties_td = [
                        'id' => $paties_id,
                        'parties' => $party->parties,
                        'desc' => $party->desc,
                        'parties_memberCount' => $parties_memberCount,
                    ];
                    $parties[count($parties)] = $parties_td;
                }

                echo json_encode($parties);
            }
        } catch (DecryptException $e) {
            dd($e);
        }

    }

    public function add_partiesMember(Request $request){
        // dd($request->all());
        try {
            // Decrypt party_id
            $party_id = Crypt::decryptString($request->partiesss_id);

            // Initialize an array to store candidate IDs
            $candidate_member_ids = [];

            if (is_array($request->candidate_member_id)) {
                foreach ($request->candidate_member_id as $key => $candidate_member_id) {

                    // Store candidate IDs in the array
                    $candidate_member_ids[] = $candidate_member_id;

                    $save_party_member = [
                        "parties_id" => $party_id,
                        "candidate" => $candidate_member_id,
                        "active" => 1,
                    ];

                    $existingRecord = candidate_parties_member_model::where('candidate', $candidate_member_id)
                        ->where('parties_id', $party_id)
                        ->first();

                    if ($existingRecord) {
                        $existingRecord->update($save_party_member);
                    } else {
                        candidate_parties_member_model::create($save_party_member);
                    }
                }
            }

            // Set active = 0 for records with the specified party_id that are not in the loop
            // dd($candidate_member_ids);
            candidate_parties_member_model::where('parties_id', $party_id)
                ->whereNotIn('candidate', $candidate_member_ids)
                ->update(['active' => 0]);

            return response()->json(["status" => 200, "parties_id" => $party_id]);

        } catch (DecryptException $e) {
            // Handle decryption exception
            return response()->json(["status" => 500, "error" => "Decryption failed"]);
        }
    }

    public function get_partiesMember(Request $request){
        // dd($request->all());
        try {
            $members = [];
            $decripted_parties_id = Crypt::decryptString($request->parties_id);
            $parties_member = candidate_parties_member_model::with('getParties_member')->where('parties_id', $decripted_parties_id)->where('active', 1)->get();

            if($parties_member->count() > 0){
                foreach($parties_member as $member) {
                    $mebers_name = '';
                    if($member->getParties_member){
                        $members_name = $member->getParties_member->fullname;
                    }
                    $party_member_id = Crypt::encryptString($member->id);
                    $candidate_member_id = $member->candidate;
                    $members_td = [
                        'party_member_id' => $party_member_id,
                        'candidate_member_id' => $candidate_member_id,
                        'members_name' => $members_name,
                    ];
                    $members[count($members)] = $members_td;
                }
                echo json_encode($members);
            }
        } catch (DecryptException $e) {
            dd($e);
        }
    }
}
