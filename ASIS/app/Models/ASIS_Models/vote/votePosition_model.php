<?php

namespace App\Models\ASIS_Models\vote;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class votePosition_model extends Model
{
    use HasFactory;

      
    protected $connection = 'portal';
    protected $table = 'vote_position';
    protected $primaryKey = 'id';

    protected $fillable = [

        'vote_position',
        'position_desc',
        'active'

        ];

       
}
