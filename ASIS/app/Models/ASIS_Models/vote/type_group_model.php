<?php

namespace App\Models\ASIS_Models\vote;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ASIS_Models\vote\candidate_group_model;

class type_group_model extends Model
{
    use HasFactory;

    protected $connection = 'portal';
    protected $table = 'vote_type_candidate_group';
    protected $primaryKey = 'id';

    protected $fillable = [

        'type_id',
        'group_id',

        ];

        public function getGroup(){
            return $this->hasOne(candidate_group_model::class,'id','group_id');
        }
}
