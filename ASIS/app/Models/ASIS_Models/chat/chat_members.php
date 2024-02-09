<?php

namespace App\Models\ASIS_Models\chat;

use App\Models\ASIS_Models\HRIS_model\employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chat_members extends Model
{
    protected $connection = 'e-hris';
    protected $table = 'chat_members';
    protected $primaryKey = 'id';

    protected $fillable =
    [
        'id', 'conversation_id', 'user_id', 'status', 'active', 'created_by'
    ];

    public function getUserinfo()
    {
        return $this->hasOne(employee::class, 'agencyid', 'user_id')->where('active', 1);
    }
}
