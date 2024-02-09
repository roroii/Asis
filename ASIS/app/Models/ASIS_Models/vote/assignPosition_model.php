<?php

namespace App\Models\ASIS_Models\vote;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ASIS_Models\vote\votePosition_model;

class assignPosition_model extends Model
{
    use HasFactory;
    protected $connection = 'portal';
    protected $table = 'vote_assign_position';
    protected $primaryKey = 'id';

    protected $fillable = [

        'typeID',
        'positionID',
        'active'

        ];

        public function getElect_position(){
            return $this->hasOne(votePosition_model::class,'id','positionID');
        }
}
