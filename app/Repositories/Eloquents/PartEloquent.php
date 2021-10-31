<?php
/**
 * Created by PhpStorm.
 * PartRequest: mohammedsobhei
 * Date: 5/2/18
 * Time: 11:43 PM
 */

namespace App\Repositories\Eloquents;

use App\Events\NewLogCreated;
use App\Http\Resources\PartResource;
use App\Models\Part;
use App\Models\Permission;
use App\Models\Verse;
use App\Repositories\Uploader;
use Illuminate\Support\Facades\DB;

class PartEloquent extends Uploader
{

    private $model;

    public function __construct(Part $model)
    {
        $this->model = $model;
    }

    function getAll(array $data)
    {


        $page_size = isset($data['page_size']) ? $data['page_size'] : max_pagination();
        $page_number = isset($data['page_number']) ? $data['page_number'] : 1;
        $collection = $this->model->whereNull('parent_id');
        if (isset($data['name']))
            $collection = $collection->where('name', 'LIKE', '%' . $data['name'] . '%');
        if (isset($data['surah_id']))
            $collection = $collection->where('surah_id', $data['surah_id']);

        $count = $collection->count();
        $page_count = page_count($count, $page_size);
        $page_number = $page_number - 1;
        $page_number = $page_number > $page_count ? $page_number = $page_count - 1 : $page_number;
        $object = $collection->take($page_size)->skip((int)$page_number * $page_size)->orderByDesc('created_at')->get();
        if (\request()->segment(1) == 'api') {
            return response_api(true, 200, null, PartResource::collection($object), $page_count, $page_number, $count);
        } else {
            return $collection;
        }
    }

    function getById($id)
    {
        // TODO: Implement getById() method.
        $part = $this->model->find($id);
        if (isset($part)) {
            if (\request()->segment(1) == 'api') {
                return response_api(true, 200, null, new PartResource($part));
            } else {
                return $part;
            }
        }
        return response_api(false, 422, __('app.not_data_found'), empObj());
    }

    function anyData($surah_id)
    {
        $parts = $this->model->whereNull('parent_id')->orderByDesc('created_at');

        return datatables()->of($parts)
            ->filter(function ($query) use ($surah_id) {
                $query->where('surah_id', $surah_id);
                if (request()->filled('is_active')) {
                    $query->where('is_active', request()->get('is_active'));
                }
                if (request()->filled('name')) {
                    $query->where('name', 'like', '%' . request()->get('name') . '%');
                }
            })->editColumn('childes_count', function ($part) {
                return $part->childes->count();
            })
            ->editColumn('number', function ($part) {
                return $part->number;
            })->editColumn('form_verse', function ($part) {
                return $part->form_verse;
            })->editColumn('to_verse', function ($part) {
                return $part->to_verse;
            })->editColumn('image', function ($part) {
                return '<img src="' . $part->image . '" width="50px" height="50px">';
            })->editColumn('video', function ($part) {
                if ($part->video)
                    return '<iframe width="122" height="100" src="' . $part->video . '">
                                                    </iframe>';
                return '-';
            })->editColumn('video2', function ($part) {
                if ($part->video2)
                    return '<iframe width="122" height="100" src="' . $part->video2 . '">
                                                    </iframe>';
                return '-';
            })->editColumn('is_active', function ($part) {
                if ($part->is_active)
                    return '<span class="switch switch-outline switch-icon switch-success">
    <label>
     <input type="checkbox" checked="checked" name="select" class="make-switch active" 
            data-id="' . $part->id . '"/>
     <span></span>
    </label>
   </span>';
                return '<span class="switch switch-outline switch-icon switch-success">
    <label>
     <input type="checkbox" name="select" class="make-switch active"  data-id="' . $part->id . '"/>
     <span></span>
    </label>';
            })
            ->addColumn('action', function ($part) {
                $return = '<div class="dropdown dropdown-inline"><a href="javascript:;" class="btn btn-sm btn-clean btn-icon"
                                                                              data-toggle="dropdown"> <i class="la la-cog"></i> </a>
                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                            <ul class="nav nav-hoverable flex-column">
                                                <li class="nav-item"><a class="nav-link" href="' . url(admin_verse_url() . '/' . $part->id) . '"><i class="nav-icon fas fa-quran"></i><span
                                                                class="nav-text">الآيات</span></a></li>
                                                                 <li class="nav-item"><a class="nav-link add-new-mdl" href="' . url(admin_part_url() . '/' . $part->surah->id . '/create?parent_id=' . $part->id) . '"><i class="nav-icon fas fa-book-open"></i><span
                                                                class="nav-text">إضافة خريطة فرعية</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <a href="' . url(admin_part_url() . '/' . $part->id . '/edit') . '" class="btn btn-sm btn-clean btn-icon edit-new-mdl" title="Edit"> <i class="la la-edit"></i> </a>
                            <a href="' . url(admin_part_url() . '/' . $part->id . '/delete') . '" class="btn btn-sm btn-clean btn-icon delete" title="Delete"> <i class="la la-trash"></i> </a>';
                return $return;
            })->editColumn('parent_id', function ($part) {
                return $part->parent ? $part->parent->title : "هي الجذر";
            })
            ->editColumn('sub_map', function ($part) {
                $childes = $part->childes;
                if ($childes->first())
                    $return = view('admin.parts.table-tree', compact('childes'))->render();
                else
                    $return = "-";
                return $return;

            })->addIndexColumn()
            ->rawColumns(['video', 'video2', 'sub_map', 'image', 'action', 'is_active'])->toJson();
    }

    function changeActive($id)
    {

        $part = $this->model->find($id);
        if (isset($part)) {
            $part->is_active = !$part->is_active;
            if ($part->save()) {
                return response_api(true, 200, null, $part);
            }
        }
        return response_api(false, 422,null,empObj());

    }

    function update(array $data, $id = null)
    {
        // TODO: Implement update() method.

        $part = $this->model->find($id);
        DB::beginTransaction();
        try {
            if (isset($data['image'])) {
                // remove previous photo
                $this->removeImage($part->image);
                $part->image = $this->storeImage('parts', 'image');
            }

            if (isset($data['video']))
                $part->video = convetYoutubeLinkToEmbed($data['video']);
            if (isset($data['video2']))
                $part->video2 = convetYoutubeLinkToEmbed($data['video2']);
            if (isset($data['name']))
                $part->name = $data['name'];
            if (isset($data['parent_id']))
                $part->parent_id = $data['parent_id'];

            if ($part->save()) {
                $verses_ids = Verse::where('surah_id', $part->surah_id)->whereBetween('number', [$data['form_verse'], $data['to_verse']])
                    ->pluck('id')->toArray();
                $part->verses()->sync($verses_ids);
                Part::doesntHave('verses')->delete();

                /**start logs**/
                if (!session()->get('permission_id'))
                    $permission_id = Permission::where('name', 'edit part')->first()->id;
                else
                    $permission_id = session()->get('permission_id');

                event(new NewLogCreated($permission_id, 0, 1));
                /**end logs**/
                DB::commit();
                return response_api(true, 200, trans('app.success'), $part);

            } else
                return response_api(false, 422, trans('app.error'),empObj());
        } catch
        (\Exception $e) {
            DB::rollback();
            return response_api(false, 400, $e->getMessage(), empObj());
        }
    }

    function create(array $data)
    {

        // TODO: Implement update() method.

        DB::beginTransaction();
        try {
            $part = new Part();

            if (isset($data['surah_id']))
                $part->surah_id = $data['surah_id'];
            if (isset($data['image'])) {
                $part->image = $this->storeImage('parts', 'image');
            }
            if (isset($data['video']))
                $part->video = convetYoutubeLinkToEmbed($data['video']);
            if (isset($data['video2']))
                $part->video2 = convetYoutubeLinkToEmbed($data['video2']);
            if (isset($data['name']))
                $part->name = $data['name'];
            if (isset($data['parent_id']))
                $part->parent_id = $data['parent_id'];
            if ($part->save()) {

                $verses_ids = Verse::where('surah_id', $data['surah_id'])->whereBetween('number', [$data['form_verse'], $data['to_verse']])
                    ->pluck('id')->toArray();
                $part->verses()->sync($verses_ids);
                Part::doesntHave('verses')->delete();
                /**start logs**/
                if (!session()->get('permission_id'))
                    $permission_id = Permission::where('name', 'edit part')->first()->id;
                else
                    $permission_id = session()->get('permission_id');

                event(new NewLogCreated($permission_id, 0, 1));
                /**end logs**/
                DB::commit();
                return response_api(true, 200, trans('app.success'), $part);

            } else
                return response_api(false, 422, trans('app.error'),empObj());
        } catch (\Exception $e) {
            DB::rollback();
            return response_api(false, 400, $e->getMessage(), empObj());
        }
    }

    function delete($id)
    {
        // TODO: Implement delete() method.
        $part = $this->model->find($id);
        $part->partVerses()->delete();
        if ($part && $part->delete()) {
            /**start logs**/
            if (!session()->get('permission_id'))
                $permission_id = Permission::where('name', 'delete part')->first()->id;
            else
                $permission_id = session()->get('permission_id');

            event(new NewLogCreated($permission_id, 0, 1));
            /**end logs**/
            return response_api(true, 200, trans('app.deleted'), empObj());
        }
        return response_api(false, 422, null, []);

    }

    function count()
    {
        return $this->model->count();
    }
}
