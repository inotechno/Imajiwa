<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WhiteboardUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $boardId;
    public $canvasData;

    public function __construct($boardId, $canvasData)
    {
        $this->boardId = $boardId;
        $this->canvasData = $canvasData;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('whiteboard.' . $this->boardId);
    }

    public function broadcastAs()
    {
        return 'WhiteboardUpdated';
    }
}
