<?php

namespace App\Repositories\Eloquents;


use App\Http\Resources\SettingResource;
use App\Models\Setting;
use App\Repositories\Uploader;
use Illuminate\Support\Facades\DB;

class SettingEloquent extends Uploader
{

    private $model;

    public function __construct(Setting $model)
    {
        $this->model = $model;
    }

    function getLookUps($type = null)
    {
        $data = [];


        $data = new \stdClass();
        $settings = $this->model->all();
        foreach ($settings as $key => $val) {
            $item = json_decode($val->value);
            if (!isset($item))
                $item = $val->value;
            $photo = $val->photo;
            $data->{$val->key} = ['value' => $item, 'photo' => $photo];
        }

        $settings = $data;
        return response_api(true, 200, null, $settings);
    }

    function getByKey($key)
    {
        // TODO: Implement getById() method.
        if (!isset($key))
            return response_api(true, 200, null, SettingResource::collection($this->model->all()));
        $setting = $this->model->where('key', $key)->first();
        return isset($setting) ? response_api(true, 200, null, new SettingResource($setting)) : response_api(false, 422, __('app.not_data_found'), empObj());
    }

    function getAll(array $data)
    {
        // TODO: Implement getAll() method.
        return $this->model->all();
    }

    function getLast($last)
    {
        // TODO: Implement getAll() method.
        return $this->model->orderByDesc('created_at')->limit($last)->get();
    }

    function getById($id)
    {
        // TODO: Implement getById() method.
        return $this->model->find($id);
    }

    function anyData()
    {
        $settings = $this->model->orderByDesc('created_at');
        return datatables()->of($settings)
            ->filter(function ($query) {
                if (request()->filled('value')) {
                    $query->where('value', 'like', '%' . request()->get('value') . '%');

                }
                if (request()->filled('key')) {
                    $query->where('key', 'like', '%' . request()->get('key') . '%');
                }

            })->editColumn('photo', function ($admin) {
                return '<img src="' . $admin->photo . '" width="50px" height="50px">';
            })->editColumn('is_active', function ($setting) {
                if ($setting->is_active)
                    return '<span class="switch switch-outline switch-icon switch-success">
    <label>
     <input type="checkbox" checked="checked" name="select" class="make-switch active" name="status" data-id="' . $setting->id . '" />
     <span></span>
    </label>
   </span>';
                return '<span class="switch switch-outline switch-icon switch-success">
    <label>
     <input type="checkbox"  name="select" class="make-switch active" name="status" data-id="' . $setting->id . '" />
     <span></span>
    </label>
   </span>';
            })->addColumn('action', function ($setting) {

                return '
                                    <a href="' . url(admin_setting_url() . '/' . $setting->id . '/edit') . '" class="btn btn-sm btn-clean btn-icon" title="Edit details"> <i class="la la-edit"></i> </a>
                                    <a href="' . url(admin_setting_url() . '/' . $setting->id . '/delete') . '" class="btn btn-sm btn-clean btn-icon delete" title="Delete"> <i class="la la-trash"></i> </a>';
            })->addIndexColumn()
            ->rawColumns(['photo', 'is_active', 'action'])->toJson();
    }

    function changeActive($id)
    {
        $setting = $this->model->find($id);
        if (isset($setting)) {
            $setting->is_active = !$setting->is_active;
            if ($setting->save()) {
                return response_api(true, 200, null, $setting);
            }
        }
        return response_api(false, 422);
    }

    function create(array $data)
    {

        $setting = new Setting();

        if (isset($data['key']))
            $setting->key = $data['key'];

        if (isset($data['value']))
            $setting->value = $data['value'];


        if (isset($data['photo'])) {
            $setting->photo = $this->storeImage('settings', 'photo');
        }
        $setting->save();
        return response_api(true, 200, __('app.success'), $setting);


    }

    function update(array $data, $id = null)
    {
        $setting = $this->model->find($id);
        if ($setting) {
            if (isset($data['key']))
                $setting->key = $data['key'];

            if (isset($data['value']))
                $setting->value = $data['value'];


            if (isset($data['photo'])) {
                // remove previous photo
                $this->removeImage($setting->photo);
                $setting->photo = $this->storeImage('settings', 'photo');
                $setting->save();
            }
            return response_api(true, 200, __('app.success'), $setting);
        } else
            return response_api(false, 422, __('app.error'), []);
    }

    function delete($id)
    {
        $setting = $this->model->find($id);
        if (isset($setting) && $setting->delete()) {
            return response_api(true, 200, __('app.deleted'), []);
        }
        return response_api(false, 422, __('app.error'), []);
    }

    function count()
    {
        return $this->model->count();
    }
}
