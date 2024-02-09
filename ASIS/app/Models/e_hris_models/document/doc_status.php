<?php

namespace App\Models\e_hris_models\document;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\rating\ratedDone_model;

class doc_status extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'status_codes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'desc',
        'class',
        'active',
    ];


    public function get_rate_status()
    {
        return $this->hasOne(ratedDone_model::class, 'status', 'id');
    }

}
