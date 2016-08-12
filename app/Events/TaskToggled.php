<?php

namespace App\Events;

use App\Task;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TaskToggled implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

		public $task;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;

				$this->dontBroadcastToCurrentUser();
		}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return ['tasks'];
    }
}
