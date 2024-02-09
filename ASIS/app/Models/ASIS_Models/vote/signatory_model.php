<?php

namespace App\Models\ASIS_Models\vote;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class signatory_model extends Model
{
    use HasFactory;
    protected $connection = 'portal';
    protected $table = 'vote_signatory';
    protected $primaryKey = 'id';

    protected $fillable = [

        'type_id',
        'signatory',
        'sig_description',
        'status',
        'active'

        ];

        public function get_signatory(){
            return $this->hasOne(User::class,'studid','signatory');
        }
}
