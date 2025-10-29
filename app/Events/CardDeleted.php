<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CardDeleted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $id;
    public $projectId;

    public function __construct($id, $projectId)
    {
        $this->id = $id;
        $this->projectId = $projectId;
    }

    public function broadcastOn()
    {
        // 📡 pastikan ke channel board.{projectId} sama seperti CardCreated & CardUpdated
        return new Channel("board.{$this->projectId}");
    }

    public function broadcastAs()
    {
        // nama event yang didengar di Echo.listen('CardDeleted')
        return 'CardDeleted';
    }

    public function broadcastWith()
    {
        // data yang dikirim ke Echo
        return [
            'id' => $this->id,
            'projectId' => $this->projectId,
        ];
    }
}
