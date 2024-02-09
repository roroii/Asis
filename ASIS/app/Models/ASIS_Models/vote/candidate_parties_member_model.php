<?php

namespace App\Models\ASIS_Models\vote;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ASIS_Models\vote\candidate_parties_model;

class candidate_parties_member_model extends Model
{
    use HasFactory;
    protected $connection = 'portal';
    protected $table = 'vote_candidate_parties_member';
    protected $primaryKey = 'id';

    protected $fillable = [

        'candidate',
        'parties_id',
        'type_id',
        'active'

        ];

    public function getParties_member(){
        return $this->hasOne(User::class,'studid','candidate');
    }

    public function getParties(){
        return $this->hasOne(candidate_parties_model::class,'id','parties_id');
    }
}
