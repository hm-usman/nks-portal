<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Chat;

class MessengerText implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    public $chat;
    
    public $channel;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Chat $chat, $channel)
    {
        $this->user = $user;

        $this->chat = $chat;

        $this->channel = $channel;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return [new PresenceChannel('MessengerTextSent-'.$this->chat->receiver_id)];
    }

    public function broadcastWith()
    {
        $this->chat->load('sender');

        return ["chat" => $this->chat];
    }

}
