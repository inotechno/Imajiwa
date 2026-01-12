<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BoardStateUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $boardId;
    public $state; // JSON document (decoded array or string)
    public $delta; // Array of changes (added, updated, removed)
    public $actorId; // employee id who made the change (optional)

    public function __construct(int $boardId, $state, ?int $actorId = null, $delta = null)
    {
        $this->boardId = $boardId;
        $this->state = $state;
        $this->actorId = $actorId;
        $this->delta = $delta;
    }

    public function broadcastOn()
    {
        // private channel supaya hanya collaborator yang bisa join
        return new PrivateChannel('board.' . $this->boardId);
    }

    public function broadcastWith()
    {
        return [
            'boardId' => $this->boardId,
            'state'   => $this->state,
            'delta'   => $this->delta,
            'actorId' => $this->actorId,
        ];
    }

    public function broadcastAs()
    {
        return 'board.updated';
    }
}
