<?php

namespace App\Models\ASIS_Models\OnlineRequest;
use  App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ASIS_Models\OnlineRequest\student_request;

class attachment_files extends Model
{
    use HasFactory;
    protected $connection = 'portal';
    protected $table = 'attachment_files';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'studid',
        'request_id',
        'folder',
        'filename',
        'created_at',
        'updated_at',

    ];
    

public function get_student_request()
    {
        return $this->HasOne(student_request::class, 'id', 'request_id');
    }    

}
