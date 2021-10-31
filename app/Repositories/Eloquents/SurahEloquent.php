<?php
/**
 * Created by PhpStorm.
 * SurahRequest: mohammedsobhei
 * Date: 5/2/18
 * Time: 11:43 PM
 */

namespace App\Repositories\Eloquents;

use App\Events\NewLogCreated;
use App\Http\Resources\SurahResource;
use App\Models\Permission;
use App\Models\Surah;
use App\Repositories\Uploader;

class SurahEloquent extends Uploader
{

    private $model;

    public function __construct(Surah $model)
    {
        $this->model = $model;
    }

    function getAll(array $data)
    {

        $page_size = isset($data['page_size']) ? $data['page_size'] : max_pagination();
        $page_number = isset($data['page_number']) ? $data['page_number'] : 1;
        $collection = $this->model;
        if (isset($data['name']))
            $collection = $collection->where(function ($q) use ($data) {
                $q->where('name', 'LIKE', '%' . $data['name'] . '%')->
                orWhere('name_pure', 'LIKE', '%' . $data['name'] . '%');
            });
        if (isset($data['type']))
            $collection = $collection->where('type', $data['type']);
        if (isset($data['page']))
            $collection = $collection->where('page_number', $data['page']);

        $count = $collection->count();
        $page_count = page_count($count, $page_size);
        $page_number = $page_number - 1;
        $page_number = $page_number > $page_count ? $page_number = $page_count - 1 : $page_number;
        $object = $collection->take($page_size)->skip((int)$page_number * $page_size)->orderByDesc('created_at')->get();
        return response_api(true, 200, null, SurahResource::collection($object), $page_count, $page_number, $count);
    }

    function getById($id)
    {
        // TODO: Implement getById() method.
        $surah = $this->model->find($id);
        if (isset($surah)) {
            if (\request()->segment(1) == 'api') {
                return response_api(true, 200, null, new SurahResource($surah));
            } else {
                return $surah;
            }
        }
        return response_api(false, 422, __('app.not_data_found'), empObj());
    }

    function anyData()
    {
        $surahs = $this->model->orderByDesc('created_at');

        return datatables()->of($surahs)
            ->filter(function ($query) {

                if (request()->filled('name')) {
                    $query->where(function ($q) {
                        $q->where('name', 'LIKE', '%' . request()->get('name') . '%')->
                        orWhere('name_pure', 'LIKE', '%' . request()->get('name') . '%')->
                        orWhere('another_name', 'LIKE', '%' . request()->get('name') . '%');
                    });
                }
                if (request()->filled('type')) {
                    $query->where('type', request()->get('type'));
                }
                if (request()->filled('page_number')) {
                    $query->where('page_number', request()->get('page_number'));
                }
                if (request()->filled('is_active')) {
                    $query->where('is_active', request()->get('is_active'));
                }

            })
            ->editColumn('is_active', function ($surah) {
                if ($surah->is_active)
                    return '<span class="switch switch-outline switch-icon switch-success">
    <label>
     <input type="checkbox" checked="checked" name="select" class="make-switch active" 
            data-id="' . $surah->id . '"/>
     <span></span>
    </label>
   </span>';
                return '<span class="switch switch-outline switch-icon switch-success">
    <label>
     <input type="checkbox" name="select" class="make-switch active"  data-id="' . $surah->id . '"/>
     <span></span>
    </label>';
            })
            ->addColumn('action', function ($surah) {
                $return = '<div class="dropdown dropdown-inline"><a href="javascript:;" class="btn btn-sm btn-clean btn-icon"
                                                                              data-toggle="dropdown"> <i class="la la-cog"></i> </a>
                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                            <ul class="nav nav-hoverable flex-column">
                                                <li class="nav-item"><a class="nav-link" href="' . url(admin_part_url() . '/' . $surah->id) . '"><i class="nav-icon fas fa-book-open"></i><span
                                                                class="nav-text">قائمة الخرائط</span></a></li>
                                                                 <li class="nav-item"><a class="nav-link" href="' . url(admin_part_url() . '/' . $surah->id) . '/tree"><i class="nav-icon fas fa-network-wired"></i><span
                                                                class="nav-text">شجرة الخرائط</span></a></li>
                                                                <li class="nav-item"><a class="nav-link" href="' . url(admin_verse_url() . '/' . $surah->id) . '?is_surah=1"><i class="nav-icon fas fa-quran"></i><span
                                                                class="nav-text">الآيات</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <a href="' . url(admin_surah_url() . '/' . $surah->id . '/edit') . '" class="btn btn-sm btn-clean btn-icon edit-new-mdl" title="Show"> <i class="la la-eye"></i> </a>';
                return $return;
            })->addIndexColumn()
            ->rawColumns(['action', 'is_active'])->toJson();
    }

    function changeActive($id)
    {

        $surah = $this->model->find($id);
        if (isset($surah)) {
            $surah->is_active = !$surah->is_active;
            if ($surah->save()) {
                return response_api(true, 200, null, $surah);
            }
        }
        return response_api(false, 422,null,empObj());

    }

    function update(array $data, $id = null)
    {
        // TODO: Implement update() method.

        $surah = $this->model->find($id);

        if ($surah->save()) {
            /**start logs**/
            if (!session()->get('permission_id'))
                $permission_id = Permission::where('name', 'edit surah')->first()->id;
            else
                $permission_id = session()->get('permission_id');

            event(new NewLogCreated($permission_id, 0, 1));
            /**end logs**/
            return response_api(true, 200, trans('app.success'), $surah);

        }
        return response_api(false, 422, trans('app.error'),empObj());
    }


    function count()
    {
        return $this->model->count();
    }
}
