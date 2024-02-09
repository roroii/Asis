<?php

namespace App\Models\ASIS_Models\vote;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ASIS_Models\vote\voteType_model;
use App\Models\ASIS_Models\enrollment\enrollment_list;
use App\Models\ASIS_Models\vote\votePosition_model;
use App\Models\ASIS_Models\vote\candidate_parties_model;
use App\Models\User;

class elect_participants_model extends Model
{
    use HasFactory;
    protected $connection = 'portal';
    protected $table = 'vote_election_participants';
    protected $primaryKey = 'id';

    protected $fillable = [

        'type_id',
        'open_typeID',
        'position_id',
        'candidate_parties_id',
        'participant_id',
        'active',
        'profile'

        ];

        public function getVote_Type(){
            return $this->hasOne(voteType_model::class,'id','type_id');
        }
        public function get_student_applicants(){
            return $this->hasOne(User::class,'studid','participant_id');
        }

        public function get_position(){
            return $this->hasOne(votePosition_model::class,'id','position_id');
        }
        public function get_parties(){
            return $this->hasOne(candidate_parties_model::class,'id','candidate_parties_id');
        }
}
