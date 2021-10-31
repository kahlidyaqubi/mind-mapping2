<?php
/**
 * Created by PhpStorm.
 * ReciterRequest: mohammedsobhei
 * Date: 5/2/18
 * Time: 11:43 PM
 */

namespace App\Repositories\Eloquents;

use App\Events\NewLogCreated;
use App\Http\Resources\ReciterResource;
use App\Http\Resources\SimpleReciterResource;
use App\Models\Permission;
use App\Models\Reciter;
use App\Repositories\Uploader;
use Illuminate\Support\Facades\Request;

class ReciterEloquent extends Uploader
{

    private $model;


    public function __construct(Reciter $model)
    {
        $this->model = $model;
    }

    function getAll(array $data)
    {


        $collection = $this->model->orderBy('name')->get();


        return response_api(true, 200, null, SimpleReciterResource::collection($collection));
    }

    function anyData()
    {
        $reciters = $this->model->orderByDesc('created_at');

        return datatables()->of($reciters)
            ->filter(function ($query) {

                if (request()->filled('name')) {
                    $query->where('name', 'LIKE', '%' . request()->get('name') . '%');
                }


                if (request()->filled('is_active')) {
                    $query->where('is_active', request()->get('is_active'));
                }

            })->editColumn('is_active', function ($reciter) {
                if ($reciter->is_active)
                    return '<span class="switch switch-outline switch-icon switch-success">
    <label>
     <input type="checkbox" checked="checked" name="select" class="make-switch active" 
            data-id="' . $reciter->id . '"/>
     <span></span>
    </label>
   </span>';
                return '<span class="switch switch-outline switch-icon switch-success">
    <label>
     <input type="checkbox" name="select" class="make-switch active"  data-id="' . $reciter->id . '"/>
     <span></span>
    </label>';
            })
            ->addColumn('action', function ($reciter) {
                $return = '<a href="' . url(admin_reciter_url() . '/' . $reciter->id . '/edit') . '" class="btn btn-sm btn-clean btn-icon edit-new-mdl" title="Edit details"> <i class="la la-edit"></i> </a>
                                    <a href="' . url(admin_reciter_url() . '/' . $reciter->id . '/delete') . '" class="btn btn-sm btn-clean btn-icon delete" title="Delete"> <i class="la la-trash"></i> </a>';
                return $return;
            })->addIndexColumn()
            ->rawColumns(['action', 'is_active'])->toJson();
    }

    function changeActive($id)
    {

        $reciter = $this->model->find($id);
        if (isset($reciter)) {
            $reciter->is_active = !$reciter->is_active;
            if ($reciter->save()) {
                return response_api(true, 200, null, $reciter);
            }
        }
        return response_api(false, 422,null,empObj());

    }

    function create(array $data)
    {
        // TODO: Implement create() method.

        $reciter = new Reciter();
        if (isset($data['name']))
            $reciter->name = $data['name'];
        $reciter->save();
        /**start logs**/
        if (!session()->get('permission_id'))
            $permission_id = Permission::where('name', 'create reciter')->first()->id;
        else
            $permission_id = session()->get('permission_id');

        event(new NewLogCreated($permission_id, 0, 1));
        /**end logs**/
        return response_api(true, 200, trans('app.success'), $reciter);
    }

    function update(array $data, $id = null)
    {
        // TODO: Implement update() method.

        $reciter = $this->model->find($id);

        if (isset($data['name']))
            $reciter->name = $data['name'];

        if ($reciter->save()) {
            /**start logs**/
            if (!session()->get('permission_id'))
                $permission_id = Permission::where('name', 'edit reciter')->first()->id;
            else
                $permission_id = session()->get('permission_id');

            event(new NewLogCreated($permission_id, 0, 1));
            /**end logs**/
            return response_api(true, 200, trans('app.success'), $reciter);

        }
        return response_api(false, 422, trans('app.error'),empObj());
    }

    function delete($id)
    {
        // TODO: Implement delete() method.
        $reciter = $this->model->find($id);

        if ($reciter && $reciter->delete()) {
            /**start logs**/
            if (!session()->get('permission_id'))
                $permission_id = Permission::where('name', 'delete reciter')->first()->id;
            else
                $permission_id = session()->get('permission_id');

            event(new NewLogCreated($permission_id, 0, 1));
            /**end logs**/
            return response_api(true, 200, trans('app.deleted'), []);
        }
        return response_api(false, 422, null, empObj());

    }

    function getById($id)
    {
        return $this->model->find($id);
    }

    function count()
    {
        return $this->model->count();
    }
}
