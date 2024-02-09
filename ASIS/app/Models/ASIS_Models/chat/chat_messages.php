<?php

namespace App\Models\ASIS_Models\chat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chat_messages extends Model
{
    protected $connection = 'e-hris';
    protected $table = 'chat_messages';
    protected $primaryKey = 'id';

    protected $fillable =
    [
        'id', 'conversation_id', 'message_text', 'user_id', 'active', 'created_by'
    ];
}
