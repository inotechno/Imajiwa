<?php

namespace App\Events;

use App\Models\BoardCard;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CardUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $card;
    public $projectId;

    public function __construct(BoardCard $card)
    {
        $this->card = $card;
        $this->projectId = $card->project_id;
    }

    public function broadcastOn()
    {
        return new Channel("board.{$this->projectId}");
    }
}
