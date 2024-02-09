<?php

namespace App\Models\ASIS_Models\chat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chat_viewers extends Model
{
    protected $connection = 'e-hris';
    protected $table = 'chat_viewers';
    protected $primaryKey = 'id';

    protected $fillable =
    [
        'id', 'conversation_id', 'message_id', 'user_id', 'seen', 'read', 'created_by', 'created_at', 'updated_at'

    ];

    public function get_conversation()
    {
        return $this->hasOne(chat_conversation::class,'id','conversation_id')->where('active', 1);
    }
}
