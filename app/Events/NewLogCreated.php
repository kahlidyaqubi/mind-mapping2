<?php

namespace App\Events;

use App\Models\Permission;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewLogCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $permission_id, $path_status, $is_notify;

    public function __construct($permission_id, $path_status, $is_notify)
    {
        $this->permission_id = $permission_id;
        $this->path_status = $path_status;
        $this->is_notify = $is_notify;
        $permission = Permission::find($permission_id);
        $this->permission_name = $permission->name;
        $this->path_status = $path_status;
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
