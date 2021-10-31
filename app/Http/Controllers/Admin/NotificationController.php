<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NotificationRequest;
use App\Models\Admin;
use App\Models\Permission;
use App\Models\User;
use App\Repositories\Eloquents\NotificationEloquent;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $notification;

    public function __construct(NotificationEloquent $notificationEloquent)
    {
        $this->notification = $notificationEloquent;
    }

    public function index()
    {
        //

        $links = [
            '#' => 'الإشعارات',
            url(admin_log_url()) => 'إدارة الإشعارات',
        ];
        $data = [
            'title' => 'الإشعارات',
            'icon' => 'fa fa-notifications',
            'links' => $links,
        ];
        return view(admin_vw() . '.notifications.index', $data);
    }

    public function anyData()
    {
        return $this->notification->anyData();
    }

    public function delete($id)
    {
        return $this->notification->delete($id);
    }

    public function read($id)
    {
        return $this->notification->read($id);
    }

}
