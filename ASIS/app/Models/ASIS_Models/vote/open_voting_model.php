<?php

namespace App\Models\ASIS_Models\vote;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ASIS_Models\vote\voteType_model;

class open_voting_model extends Model
{
    use HasFactory;
    protected $connection = 'portal';
    protected $table = 'vote_open_voting';
    protected $primaryKey = 'id';

    protected $fillable = [
        'open_applicationID',
        'type_id',
        'open_date',
        'close_date',
        'status',
        'active'

        ];
        public function getVoting_type(){
            return $this->hasOne(voteType_model::class,'id','type_id');
        }
}
