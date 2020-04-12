<?php

namespace App\Events;

use App\Answer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AnswerCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $newAnswer;

    /**
     * Create a new event instance.
     *
     * @param Answer $answer
     */
    public function __construct(Answer $answer)
    {
        $this->newAnswer = $answer;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {

        return new PrivateChannel('channel-name');
    }
}
