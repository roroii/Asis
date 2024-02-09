<?php

namespace App\Models\e_hris_models\chat;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chat_conversation extends Model
{
    protected $connection = 'e-hris';
    protected $table = 'chat_conversation';
    protected $primaryKey = 'id';

    protected $fillable =
    [
        'id', 'title', 'description', 'conversation_type', 'class', 'icon', 'last_sent_by', 'active', 'created_by'
    ];

    public function get_members()
    {
        return $this->hasMany(chat_members::class, 'conversation_id', 'id')->where('user_id', '!=' ,Auth::user()->employee)->where('active', 1);
    }

    public function get_im_member()
    {
        return $this->hasMany(chat_members::class, 'conversation_id', 'id')->where('user_id', Auth::user()->employee)->where('active', 1);
    }

    public function chat_messages()
    {
        return $this->hasMany(chat_messages::class,'conversation_id','id')->where('active', 1);
    }

    public function count_message_unseen()
    {
        return $this->hasMany(chat_viewers::class,'conversation_id','id')->where('user_id', Auth::user()->employee)->where('active', 1)->where('read',0);
    }
}
