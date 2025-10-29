<?php

namespace App\Events;

use App\Models\BoardConnector;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class ConnectorCreated implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public $connector;

    public function __construct(BoardConnector $connector)
    {
        $this->connector = $connector;
    }

    public function broadcastOn()
    {
        return new Channel('board.' . $this->connector->project_id);
    }

    public function broadcastAs()
    {
        return 'ConnectorCreated';
    }

    public function broadcastWith()
    {
        return [
            'connector' => [
                'id' => $this->connector->id,
                'from_card_id' => $this->connector->from_card_id,
                'to_card_id' => $this->connector->to_card_id,
                'color' => $this->connector->color,
                'thickness' => $this->connector->thickness,
                'style' => $this->connector->style,
            ],
        ];
    }
}
