<?php

namespace App\Models\e_hris_models\document;

use App\Models\ASIS_Models\HRIS_model\employee;
use App\Models\tbl\tbl_responsibilitycenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class doc_user_rc_g extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'user_rc_g';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type','type_id', 'user_id', 'rc_id', 'group_id', 'active',
    ];

    public function getUserinfo()
    {
        return $this->hasOne(employee::class, 'agencyid', 'user_id')->where('active', 1);
    }

    public function getOffice()
    {
        return $this->hasOne(tbl_responsibilitycenter::class, 'responid', 'type_id')->where('active', 1);
    }

    public function getGroup()
    {
        return $this->hasOne(doc_groups::class, 'id', 'type_id')->where('active', 1);
    }

}
