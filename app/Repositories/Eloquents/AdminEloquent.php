<?php
/**
 * Created by PhpStorm.
 * UserRequest: mohammedsobhei
 * Date: 5/2/18
 * Time: 11:43 PM
 */

namespace App\Repositories\Eloquents;

use App\Models\Admin;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Request;
use App\Events\NewLogCreated;
use App\Models\Permission;
use App\Repositories\Uploader;

class AdminEloquent extends Uploader implements Repository
{

    private $model;

    public function __construct(Admin $model)
    {
        $this->model = $model;
    }

    function anyData()
    {
        $admins = $this->model->orderByDesc('created_at');

        return datatables()->of($admins)
            ->filter(function ($query) {

                if (request()->filled('name')) {
                    $query->where('name', 'LIKE', '%' . request()->get('name') . '%');
                }

                if (request()->filled('email')) {
                    $query->where('email', 'LIKE', '%' . request()->get('email') . '%');
                }

                if (request()->filled('phone')) {
                    $query->where('phone', 'LIKE', '%' . request()->get('phone') . '%');
                }

                if (request()->filled('is_active')) {
                    $query->where('is_active', request()->get('is_active'));
                }

            })->editColumn('photo', function ($admin) {
                return '<img src="' . $admin->photo . '" width="50px" height="50px">';
            })
            ->editColumn('is_active', function ($admin) {
                if ($admin->is_active)
                    return '<span class="switch switch-outline switch-icon switch-success">
    <label>
     <input type="checkbox" checked="checked" name="select" class="make-switch active" 
            data-id="' . $admin->id . '"/>
     <span></span>
    </label>
   </span>';
                return '<span class="switch switch-outline switch-icon switch-success">
    <label>
     <input type="checkbox" name="select" class="make-switch active"  data-id="' . $admin->id . '"/>
     <span></span>
    </label>';
            })
            ->addColumn('action', function ($admin) {
                $return = '<div class="dropdown dropdown-inline"><a href="javascript:;" class="btn btn-sm btn-clean btn-icon"
                                                                              data-toggle="dropdown"> <i class="la la-cog"></i> </a>
                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                            <ul class="nav nav-hoverable flex-column">
                                                <li class="nav-item"><a class="nav-link" href="' . url(admin_admin_url() . '/' . $admin->id . '/permissions') . '"><i class="nav-icon fas fas fa-box-open"></i><span
                                                                class="nav-text">الصلاحيات</span></a></li>
                                                  </ul>
                                        </div>
                                    </div>
                                    <a href="' . url(admin_admin_url() . '/' . $admin->id . '/edit') . '" class="btn btn-sm btn-clean btn-icon edit-new-mdl" title="Edit details"> <i class="la la-edit"></i> </a>
                                    <a href="' . url(admin_admin_url() . '/' . $admin->id . '/delete') . '" class="btn btn-sm btn-clean btn-icon delete" title="Delete"> <i class="la la-trash"></i> </a>';
                return $return;
            })->addIndexColumn()
            ->rawColumns(['photo', 'action', 'is_active'])->toJson();
    }

    function changeActive($id)
    {

        $admin = $this->model->find($id);
        if (isset($admin)) {
            $admin->is_active = !$admin->is_active;
            if ($admin->save()) {
                return response_api(true, 200, null, $admin);
            }
        }
        return response_api(false, 422,null,empObj());

    }

    function getAll(array $data)
    {
        // TODO: Implement getAll() method.
        return $this->model->all();
    }

    function getById($id)
    {
        // TODO: Implement getById() method.
        return $this->model->find($id);
    }

    function create(array $data)
    {
        // TODO: Implement create() method.

        $admin = new Admin();
        if (isset($data['name']))
            $admin->name = $data['name'];
        if (isset($data['email']))
            $admin->email = $data['email'];
        if (isset($data['phone']))
            $admin->phone = $data['phone'];

        if (isset($data['password']))
            $admin->password = bcrypt($data['password']);

        if (isset($data['photo'])) {
            // remove previous photo
            $this->removeImage($admin->photo);
            $admin->photo = $this->storeImage('admins', 'photo');
        }

        $admin->save();
        /**start logs**/
        if (!session()->get('permission_id'))
            $permission_id = Permission::where('name', 'create admin')->first()->id;
        else
            $permission_id = session()->get('permission_id');

        event(new NewLogCreated($permission_id, 0, 1));
        /**end logs**/
        return response_api(true, 200, trans('app.success'), $admin);
    }

    function update(array $data, $id = null)
    {
        // TODO: Implement update() method.

        $admin = $this->model->find($id);

        if (isset($data['name']))
            $admin->name = $data['name'];
        if (isset($data['email']))
            $admin->email = $data['email'];

        if (isset($data['phone']))
            $admin->phone = $data['phone'];

        if (isset($data['password']))
            $admin->password = bcrypt($data['password']);

        if (isset($data['photo'])) {
            // remove previous photo
            $this->removeImage($admin->photo);
            $admin->photo = $this->storeImage('admins', 'photo');
        }

        if ($admin->save()) {
            /**start logs**/
            if (!session()->get('permission_id'))
                $permission_id = Permission::where('name', 'edit admin')->first()->id;
            else
                $permission_id = session()->get('permission_id');

            event(new NewLogCreated($permission_id, 0, 1));
            /**end logs**/
            return response_api(true, 200, trans('app.success'), $admin);

        }
        return response_api(false, 422, trans('app.error'),empObj());
    }

    function delete($id)
    {
        // TODO: Implement delete() method.
        $admin = $this->model->find($id);

        if ($admin && $admin->delete()) {
            /**start logs**/
            if (!session()->get('permission_id'))
                $permission_id = Permission::where('name', 'delete admin')->first()->id;
            else
                $permission_id = session()->get('permission_id');

            event(new NewLogCreated($permission_id, 0, 1));
            /**end logs**/
            return response_api(true, 200, trans('app.deleted'), []);
        }
        return response_api(false, 422, null, empObj());

    }

    public function permissionPost($id, $permissions)
    {
        $admin = $this->model->find($id);

        if ($admin) {
            $admin->syncPermissions($permissions);
            /**start logs**/
            if (!session()->get('permission_id'))
                $permission_id = Permission::where('name', 'permission admin')->first()->id;
            else
                $permission_id = session()->get('permission_id');

            event(new NewLogCreated($permission_id, 0, 1));
            /**end logs**/
            return response_api(true, 200, trans('app.success'), []);
        } else {
            return response_api(false, 422, null, empObj());
        }
    }


    function logsData($id)
    {
        $logs = $this->model->find($id)->logs()->orderByDesc('created_at');
        return datatables()->of($logs)
            ->filter(function ($query) use ($id) {
                $query->where('logable_id', $id)
                    ->where('logable_type', "App\Models\Admin");
                if (request()->filled('permission_id')) {
                    $query->where('permission_id', request()->get('permission_id'));
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


    function count()
    {
        return $this->model->count();
    }


}
