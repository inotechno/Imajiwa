<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WhiteboardUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $boardId;
    public array $snapshot;
    public ?int $userId;

    public function __construct(int $boardId, array $snapshot, ?int $userId = null)
    {
        $this->boardId  = $boardId;
        $this->snapshot = $snapshot;
        $this->userId   = $userId;
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel("whiteboard.{$this->boardId}");
    }

    public function broadcastAs(): string
    {
        return 'WhiteboardUpdated';
    }
}
