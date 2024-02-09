<?php

namespace App\Models\ASIS_Models\OnlineRequest;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ASIS_Models\enrollment\enrollment_list;
use App\Models\ASIS_Models\posgres\enrollment\srgb\semstudent;
use App\Models\ASIS_Models\OnlineRequest\offices;
use App\Models\ASIS_Models\OnlineRequest\admin_User;

class student_request extends Model
{
    use HasFactory;
    protected $connection = 'portal';
    protected $table = 'student_request';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'studid',
        'claim_date',
        'office',
        'request_type',
        'purpose',
        'no_of_copies',
        'status',
        'active',
        'message',
        'created_at',
        'updated_at',

    ];


public function get_student_fullname()
    {
        return $this->hasone(enrollment_list::class, 'studid', 'studid');
    }

public function get_AdminUser()
    {

        return $this->hasone(admin_User::class, 'office_id', 'office');
    }    


public function get_semstudent()
    {
        return $this->hasone(semstudent::class, 'studid', 'studid');
    }


public function get_offices()
    {
    
        return $this->hasone(offices::class, 'id', 'office');

    }


public function get_attachment_files()
    {
        return $this->HasOne(attachment_files::class, 'request_id', 'id');
    }    


}
