<?php

namespace App\Events;

use App\Models\Category;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DoorprizeDrawn implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $category;
    public $winners;

    /**
     * Create a new event instance.
     */
    public function __construct($winners, Category $category)
    {
        $this->winners = $winners;
        $this->category = $category;
    }

    /**
     * Tentukan channel broadcast-nya.
     */
    public function broadcastOn()
    {
        return new Channel('doorprize-channel');
    }

    /**
     * Nama event yang dikirim ke frontend.
     */
    public function broadcastAs()
    {
        return 'doorprize.drawn';
    }
}
