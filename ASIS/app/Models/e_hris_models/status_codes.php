<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\rating\ratedDone_model;

class status_codes extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'status_codes';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'desc',
        'class',
        'code',
        'stag',
        'active',
    ];

    public function get_interStatus(){
        return $this->hasMany(ratedDone_model::class, 'status', 'id');
    }
}
