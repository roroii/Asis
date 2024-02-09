<?php

namespace App\Models\e_hris_models\document;

use App\Models\tbl\tblemployee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class doc_groups extends Model
{
    use HasFactory;
    protected $connection = 'e-hris';
    protected $table = 'admin_groups';

       /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'desc', 'active', 'head',
    ];

    public function getMembers()
    {
        return $this->hasMany(doc_user_rc_g::class, 'id', 'group_id')->where('active', 1);
    }

    public function getHead()
    {
        return $this->hasOne(tblemployee::class, 'agencyid', 'head')->where('active', 1);
    }
}
