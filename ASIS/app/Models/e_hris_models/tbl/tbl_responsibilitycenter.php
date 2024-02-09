<?php

namespace App\Models\e_hris_models\tbl;

use App\Models\ASIS_Models\HRIS_model\employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_responsibilitycenter extends Model
{
    use HasFactory;

    protected $connection = 'e-hris';
    protected $table = 'responsibilitycenter';
    protected $primaryKey = 'responid';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'responid','centername', 'descriptions', 'department', 'head', 'accounts','created_by',
    ];

    public function sub_employeeinf()
    {
        return $this->hasOne(employee::class, 'agencyid', 'head')->where('active', 1);
    }

    public function rc_head()
    {
        return $this->hasOne(employee::class, 'agencyid', 'head')->where('active', 1);
    }
}
