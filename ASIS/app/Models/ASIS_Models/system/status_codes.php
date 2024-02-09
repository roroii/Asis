<?php

namespace App\Models\ASIS_Models\system;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\rating\ratedDone_model;

class status_codes extends Model
{
    use HasFactory;
    protected $connection = 'portal';
    protected $table = 'status_codes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'desc',
        'class',
        'code',
        'stag',
        'tag_for',
        'active',
    ];


//    public function get_rate_status()
//    {
//        return $this->hasOne(ratedDone_model::class, 'status', 'id');
//    }

}
