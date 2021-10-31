<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Log;

class NotifyUsers extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $log;

    public function __construct($log)
    {
        //
        $this->log = $log;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */


    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {

        $log = Log::with('permission.parent')->with('logable')->find($this->log->id);
        return ['log' => $log];
    }

    public function toBroadcast($notifiable)
    {

        $log = Log::with('permission.parent')->with('logable')->find($this->log->id);
        return ['data' => ['log' => $log, 'link' => $log->path_status ? $log->permission->link : $log->permission->parent->childes->first()->link]];
    }

}
