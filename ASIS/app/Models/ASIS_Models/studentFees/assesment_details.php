<?php

namespace App\Models\ASIS_Models\studentFees;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ASIS_Models\studentFees\semcoding;
use App\Models\ASIS_Models\studentFees\fees;

class assesment_details extends Model
{
    use HasFactory;

    protected $connection = 'spamast_digos_srgb';
    protected $table = 'ass_details';
    protected $primaryKey = 'oid';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
            'sy', 'sem','studid','feecode','amt'
    ];

    /*get the semester of the school year*/
    public function getSemcoding()
    {
        return $this->hasOne(semcoding::class,'semcode','sem');
    }

    /*Get the feecode description of*/
    public function getFeecodeDesc()
    {
        return $this->hasone(fees::class,'feecode','feecode');
    }

}
