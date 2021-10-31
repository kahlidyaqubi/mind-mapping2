<?php
/**
 * Created by PhpStorm.
 * NotificationRequest: mohammedsobhei
 * Date: 5/2/18
 * Time: 11:43 PM
 */

namespace App\Repositories\Eloquents;

use App\Models\Notification;
use App\Models\Log;
use App\Models\Permission;
use App\Repositories\Repository;
use App\Repositories\Uploader;

class NotificationEloquent extends Uploader implements Repository
{

    private $model;

    public function __construct(Notification $model)
    {
        $this->model = $model;
    }

    function anyData()
    {
        $notifications = auth()->guard('admin')->user()->notifications()->orderByDesc('created_at');
        return datatables()->of($notifications)
            ->filter(function ($query) {

                if (request()->filled('read_at') && request()->get('read_at') == 1) {
                    $query->whereNotNull('read_at');
                } elseif (request()->filled('read_at') && request()->get('read_at') == 2) {
                    $query->whereNull('read_at');
                }
                if (request()->filled('date')) {
                    $query->where('created_at', 'like', '%' . request()->get('date') . '%');
                }

            })->addIndexColumn()
            ->editColumn('action', function ($value) {
                $log = $value->data['log'];
                $title = $log['permission']['title'];
                $permission = isset($log["permission"]) ? Permission::find($log["permission"]["id"]) : null;
                if ($log['path_status'])
                    return "<strong class='text-red'><a href='" . $log["permission"]["link"] . "'> $title </a></strong>";
                else
                    return "<strong class='text-red'><a href='" . ($permission->parent ? $permission->parent->childes->first()->link : $permission->parent->link) . "'> $title </a></strong>";


            })->addColumn('type', function ($value) {
                $log = $value->data['log'];
                $name = $log['permission']['name'];
                return $name;
            })
            ->addColumn('ip_address', function ($value) {
                $log = $value->data['log'];
                return isset($log['ip_address']) ? $log['ip_address'] : null;
            })
            ->addColumn('date', function ($value) {
                return isset($value->created_at) ? "<span style='display: none;'> $value->id </span>" . date_format($value->created_at, 'Y-m-d') : null;
            })->addColumn('time', function ($value) {
                return isset($value->created_at) ? date_format($value->created_at, 'H:i') : null;
            })
            ->addColumn('browser', function ($value) {
                $log = $value->data['log'];
                $agentName = isset($log['agent']) ? $log['agent'] : null;
                return $agentName;
            })
            ->editColumn('logable', function ($value) {
                $log = $value->data['log'];
                $user = $log['logable'];
                return (isset($user) && isset($user['name']) ? $user['name'] : "_");
            })
            ->addColumn('ip', function ($value) {
                $log = $value->data['log'];
                $theDevice = isset($log['device']) ? $log['device'] : null;
                $theDevicePlatform = isset($log['device_platform']) ? $log['device_platform'] : null;
                return $theDevice . ' - ' . $theDevicePlatform;
            })
            ->rawColumns(['action', 'date'])->toJson();
    }

    public function read($id)
    {
        $notfe = auth()->guard('admin')->user()->unreadNotifications()->find($id);

        if ($notfe)
            $notfe->markAsRead();

        return response_api(true, 200, __('app.success'), empObj());
    }


    function getAll(array $attributes)
    {
        // TODO: Implement getAll() method.
        return $this->model->all();
    }

    function getById($id)
    {
        // TODO: Implement getById() method.
        return $this->model->find($id);
    }

    function create(array $attributes)
    {
        // TODO: Implement create() method.
    }

    function update(array $attributes, $id = null)
    {
        // TODO: Implement update() method.
    }

    function delete($id)
    {
        $notification = $this->model->find($id);

        if ($notification && $notification->delete()) {
            return response_api(true, 200, trans('app.deleted'), []);
        }
        return response_api(false, 422, null, empObj());


    }

    function count()
    {
        return $this->model->count();
    }
}
