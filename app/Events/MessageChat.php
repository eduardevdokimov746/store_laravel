<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageChat implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_name;
    public $message;
    public $time;
    public $hash;
    private $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($hash, $user_name, $message, $time, $user)
    {
        $this->hash = $hash;
        $this->user_name = $user_name;
        $this->message = $message;
        $this->time = $time;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chat.' . $this->hash);
    }

    public function broadcastWith()
    {
        return [
            'user_name' => $this->user_name,
            'message' => $this->message,
            'time' => $this->time,
            'user' => $this->user
        ];
    }


}
