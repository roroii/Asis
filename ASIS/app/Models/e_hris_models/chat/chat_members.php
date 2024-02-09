<?php

namespace App\Models\e_hris_models\chat;

use App\Models\tbl\tblemployee;
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
        return $this->hasOne(tblemployee::class, 'agencyid', 'user_id')->where('active', 1);
    }
}
