<?php

namespace App\Models\ASIS_Models\vote;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ASIS_Models\vote\open_voting_model;

class voteType_model extends Model
{
    use HasFactory;
    
    protected $connection = 'portal';
    protected $table = 'vote_type';
    protected $primaryKey = 'id';

    protected $fillable = [

        'vote_type',
        'vote_description',
        'active'

        ];


        public function get_openVoting(){
            return $this->hasOne(open_voting_model::class,'type_id', 'id')->where('active', true);
        }
}
