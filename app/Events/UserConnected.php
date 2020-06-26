<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserConnected implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $hash;
    public $user_name;
    public $message;
    public $broadcastQueue = 'sockets';

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($hash, $user_name, $message)
    {
        $this->hash = $hash;
        $this->user_name = $user_name;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('main');
    }

    public function broadcastWith()
    {
        return [
            'hash' => $this->hash,
            'user_name' => $this->user_name,
            'message' => $this->message
        ];
    }
}
