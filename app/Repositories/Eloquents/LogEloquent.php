<?php
/**
 * Created by PhpStorm.
 * LogRequest: mohammedsobhei
 * Date: 5/2/18
 * Time: 11:43 PM
 */

namespace App\Repositories\Eloquents;

use App\Models\Log;
use App\Repositories\Repository;
use App\Repositories\Uploader;

class LogEloquent extends Uploader implements Repository
{

    private $model;

    public function __construct(Log $model)
    {
        $this->model = $model;
    }

    function anyData()
    {
        $logs = $this->model->orderByDesc('created_at');
        return datatables()->of($logs)
            ->filter(function ($query) {

                if (request()->filled('permission_id')) {
                    $query->where('permission_id', request()->get('permission_id'));
                }
                if (request()->filled('admin_id')) {
                    $query->where('logable_id', request()->get('admin_id'))
                        ->where('logable_type', "App\Models\Admin");
                }
                if (request()->filled('date')) {
                    $query->where('created_at', 'like', '%' . request()->get('date') . '%');
                }
                if (request()->filled('agent')) {
                    $query->where('agent', 'like', '%' . request()->get('agent') . '%');
                }

            })->addIndexColumn()
            ->editColumn('action', function ($value) {

                $title = $value->permission->title;
                if (!($value->path_status) && $value->permission->parent)
                    return "<strong class='text-red'><a href='" . $value->permission->parent->childes->first()->link . "'> $title  </a></strong>";
                else
                    return "<strong class='text-red'><a href='" . $value->permission->link . "'> $title  </a></strong>";


            })->addColumn('type', function ($value) {
                $name = $value->permission->name;
                return $name;
            })
            ->addColumn('ip_address', function ($value) {
                return isset($value->ip_address) ? $value->ip_address : null;
            })
            ->addColumn('date', function ($value) {
                return isset($value->created_at) ? "<span style='display: none;'> $value->id </span>" . date_format($value->created_at, 'Y-m-d') : null;
            })->addColumn('time', function ($value) {
                return isset($value->created_at) ? date_format($value->created_at, 'H:i') : null;
            })
            ->editColumn('logable', function ($value) {
                $user = $value->logable;
                return ($user->name ?? "-");
            })
            ->addColumn('browser', function ($value) {
                $agentName = isset($value->agent) ? $value->agent : null;
                return $agentName;
            })
            ->addColumn('ip', function ($value) {
                $theDevice = isset($value->device) ? $value->device : null;
                $theDevicePlatform = isset($value->device_platform) ? $value->device_platform : null;
                return $theDevice . ' - ' . $theDevicePlatform;
            })
            ->rawColumns(['action', 'date'])->toJson();
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
        // TODO: Implement delete() method.
    }

    function count()
    {
        return $this->model->count();
    }
}
