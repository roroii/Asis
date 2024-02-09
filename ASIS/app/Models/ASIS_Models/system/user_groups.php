<?php

namespace App\Models\ASIS_Models\system;

use App\Models\ASIS_Models\HRIS_model\employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_groups extends Model
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
        return $this->hasMany(user_rc_group::class, 'id', 'group_id')->where('active', 1);
    }

    public function getHead()
    {
        return $this->hasOne(employee::class, 'agencyid', 'head')->where('active', 1);
    }
}
