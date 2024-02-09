<?php

namespace App\Models\ASIS_Models\vote;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ASIS_Models\enrollment\enrollment_list;

class assign_voters extends Model
{
    use HasFactory;

    protected $connection = 'portal';
    protected $table = 'vote_assign_voters';
    protected $primaryKey = 'id';

    protected $fillable = [

        'type_id',
        'prog_code',
        'active'

        ];

        public function get_enrolledList(){
            return $this->hasMany(enrollment_list::class,'studmajor','prog_code');
        }
}
