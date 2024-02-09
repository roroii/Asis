<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class load_have_message implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message_sent_to;
    public $conversation_id;
    public $message_id;
    public $current_user_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message_sent_to, $conversation_id, $message_id, $current_user_id)
    {
        $this->message_sent_to = $message_sent_to;
        $this->conversation_id = $conversation_id;
        $this->message_id = $message_id;
        $this->current_user_id = $current_user_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('channel-have-message');
    }
}
