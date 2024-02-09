<?php

namespace App\Models\ASIS_Models\OnlineRequest;
use  App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ASIS_Models\OnlineRequest\office_services;
use App\Models\ASIS_Models\OnlineRequest\admin_User;

class offices extends Model
{
    use HasFactory;
    protected $connection = 'portal';
    protected $table = 'offices';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'office_name',
        'entrydate',
        'active',
        'created_at',
        'updated_at',

    ];

    public function get_office_services()
    {
        return $this->HasOne(office_services::class, 'office_id', 'id');
    }


    public function get_user_office_role(){

        return $this->hasOne(admin_User::class, 'office_id', 'id')->where('active', 1);

    }
    

}
