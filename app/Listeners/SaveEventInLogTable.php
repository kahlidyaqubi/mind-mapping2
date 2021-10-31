<?php

namespace App\Listeners;

use App\Events\NewLogCreated;
use App\Models\Admin;
use App\Models\Log;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Notification;
use App\Notifications\NotifyUsers;
use Browser;

class SaveEventInLogTable
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewLogCreated $event
     * @return void
     */
    public function handle(NewLogCreated $event)
    {
        $device = '';
        $log = [];

        if (Browser::isMobile()) {
            $device = 'Mobile';
        } elseif (Browser::isTablet()) {
            $device = 'Tablet';
        } elseif (Browser::isDesktop()) {
            $device = 'Desktop';
        } elseif (Browser::isBot()) {
            $device = 'Bot';
        } else {
            $device = '';
        }


        $log['is_notify'] = $event->is_notify;
        $log['ip_address'] = \Request::ip();
        $log['agent'] = Browser::browserName();
        $log['device'] = $device;
        $log['device_platform'] = Browser::platformName();
        $log['permission_id'] = $event->permission_id;
        $log['path_status'] = $event->path_status;
        if (auth()->user()) {
            $log['logable_type'] = (request()->segment(1) == 'admin') ? 'App\Models\Admin' : 'App\Models\User';
            $log['logable_id'] = (request()->segment(1) == 'admin') ? auth()->guard('admin')->user()->id : auth()->guard('web')->user()->id;
        }
        $the_log = Log::create($log);

        if ($event->is_notify) {
            $arr = [];
            if (auth()->guard('admin')->user())
                $arr[0] = auth()->guard('admin')->user()->id;
            $admins = Admin::permission($event->permission_name)/*->whereNotIn('id', $arr)*/
            ->get();
            Notification::send($admins, new NotifyUsers($the_log));

        }
    }
}
