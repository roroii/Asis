<?php

namespace App\Models\ASIS_Models\vote;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ASIS_Models\vote\voteType_model;

class voteOpenApplication_Model extends Model
{
    use HasFactory;

    protected $connection = 'portal';
    protected $table = 'vote_open_application';
    protected $primaryKey = 'id';

    protected $fillable = [

        'vote_typeID',
        'open_date',
        'close_date',
        'status',
        'active'

        ];
        public function getVoting_type(){
            return $this->hasOne(voteType_model::class,'id','vote_typeID');
        }
}
