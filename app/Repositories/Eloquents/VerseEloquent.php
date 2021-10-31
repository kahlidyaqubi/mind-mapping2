<?php
/**
 * Created by PhpStorm.
 * VerseRequest: mohammedsobhei
 * Date: 5/2/18
 * Time: 11:43 PM
 */

namespace App\Repositories\Eloquents;

use App\Http\Resources\SimpleVerseSubResource;
use App\Http\Resources\VerseResource;
use App\Models\Part;
use App\Models\VerseSub;
use App\Models\Verse;
use App\Models\VerseSound;
use App\Repositories\Uploader;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class VerseEloquent extends Uploader
{

    private $model;
    private $part;
    private $verseSub;
    private $verseSound;


    public function __construct(Verse $model, Part $part, VerseSound $verseSound, VerseSub $verseSub)
    {
        $this->model = $model;
        $this->part = $part;
        $this->verseSub = $verseSub;
        $this->verseSound = $verseSound;

    }

    function getAll(array $data)
    {
        $page_size = isset($data['page_size']) ? $data['page_size'] : max_pagination();
        $page_number = isset($data['page_number']) ? $data['page_number'] : 1;
        $reciter_id = (isset($data['reciter_id']) && $data['reciter_id']) ? $data['reciter_id'] : null;
        if ($reciter_id)
            session()->flash('reciter_id', $reciter_id);
        if (isset($data['surah_id']))
            $collection = $this->model->where('surah_id', $data['surah_id']);
        elseif (isset($data['part_id'])) {
            $collection = Part::find($data['part_id'])->verses()->select('verses.*');
        } else
            $collection = $this->model;
        if (isset($data['text']))
            $collection = $collection->where(function ($q) use ($data) {
                $q->where('text', 'LIKE', '%' . $data['text'] . '%')->
                orWhere('text_pure', 'LIKE', '%' . $data['text'] . '%');
            });

        $count = $collection->count();
        $page_count = page_count($count, $page_size);
        $page_number = $page_number - 1;
        $page_number = $page_number > $page_count ? $page_number = $page_count - 1 : $page_number;
        $object = $collection->take($page_size)->skip((int)$page_number * $page_size)->orderBy('id')->get();

        return response_api(true, 200, null, VerseResource::collection($object), $page_count, $page_number, $count);
    }

    function getById($id, $data = [])
    {
        // TODO: Implement getById() method.
        $part = $this->model->find($id);
        $reciter_id = (isset($data['reciter_id']) && $data['reciter_id']) ? $data['reciter_id'] : null;
        if (isset($part)) {
            if (\request()->segment(1) == 'api') {
                return response_api(true, 200, null, new VerseResource($part, $reciter_id));
            } else {
                return $part;
            }
        }
        return response_api(false, 422, __('app.not_data_found'), empObj());
    }


    function anyData($part_or_surah_id)
    {
        if (request()->get('is_surah') == 1)
            $verses = $this->model->orderByDesc('created_at')->where('surah_id', $part_or_surah_id);
        else {
            $verses = Part::find($part_or_surah_id)->verses()->select('verses.*')->orderByDesc('created_at');
        }
        return datatables()->of($verses)
            ->filter(function ($query) {

                if (request()->filled('text')) {
                    $query->where(function ($q) {
                        $q->where('text', 'LIKE', '%' . request()->get('text') . '%')->
                        orWhere('text_pure', 'LIKE', '%' . request()->get('text') . '%');
                    });
                }
                if (request()->filled('is_active') || request()['is_active'] === "0") {
                    $query->where('is_active', request()['is_active']);
                }
                if (request()->filled('number')) {
                    $query->where('number', request()['number']);
                }

            })->editColumn('surah', function ($verse) {
                return $verse->surah->name;
            })
            ->editColumn('text', function ($verse) {
                return mb_substr($verse->text, 0, 170, 'utf-8') . "..";
            })
            ->editColumn('is_active', function ($verse) {
                if ($verse->is_active)
                    return '<span class="switch switch-outline switch-icon switch-success">
    <label>
     <input type="checkbox" checked="checked" name="select" class="make-switch active" name="status" data-id="' . $verse->id . '" />
     <span></span>
    </label>
   </span>';
                return '<span class="switch switch-outline switch-icon switch-success">
    <label>
     <input type="checkbox"  name="select" class="make-switch active" name="status" data-id="' . $verse->id . '" />
     <span></span>
    </label>
   </span>';
            })->addColumn('action', function ($verse) {

                return ' <div class="dropdown dropdown-inline"><a href="javascript:;" class="btn btn-sm btn-clean btn-icon"
                                                                              data-toggle="dropdown"> <i class="la la-cog"></i> </a>
                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                            <ul class="nav nav-hoverable flex-column">
                                              <li class="nav-item"><a class="nav-link" href="' . url(admin_verse_url() . '/' . $verse->id) . '/tree"><i class="nav-icon fas fa-network-wired"></i><span
                                                                class="nav-text">شجرة أجزاء الآية</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                <a href="' . url(admin_verse_url() . '/' . $verse->id . '/edit') . '" class="btn btn-sm btn-clean btn-icon" title="Edit Media"> <i class="la la-edit"></i> </a>';
            })->addIndexColumn()
            ->rawColumns(['image', 'action', 'is_active'])->toJson();
    }

    function update(array $data, $id = null)
    {

        $verse = $this->model->find($id);
        if ($verse) {
            DB::beginTransaction();
            try {
                if (isset($data['filepath'])) {
                    $paths = preg_split("/\,/", $data['filepath']);
                    $verse->images()->delete();
                    foreach ($paths as $path) {
                        $verse->images()->create(['image' => ltrim(stristr(parse_url($path)['path'], 'storage/'), 'storage/')]);
                    }
                }

                if (isset($data['sounds'])) {
//
                    $sounds = $data['sounds'] ? array_values(array_filter($data["sounds"], 'myFilter')) : [];
                    if ($sounds)
                        $data['reciter_ids'] = $data['reciter_ids'] ? filterByFileKey($data['reciter_ids'], $data["sounds"]) : [];
                    $reciter_ids = $data['reciter_ids'] ? array_values(array_filter($data["reciter_ids"], 'myFilter')) : [];

                    if ($sounds && count($sounds) == count($reciter_ids)) {
                        for ($i = 0; $i < count($sounds); $i++) {
                            if ($this->verseSound->where('reciter_id', $reciter_ids[$i])->first())
                                $verse_sound = $this->verseSound->where('reciter_id', $reciter_ids[$i])->first();
                            else
                                $verse_sound = $this->verseSound->create([
                                    'verse_id' => $verse->id,
                                    'reciter_id' => $reciter_ids[$i],
                                ]);
                            if (isset($sounds[$i])) {
                                $verse_sound->sound = $this->storeImage('verse_sound', $sounds[$i], 1);
                                $verse_sound->save();
                            }
                        }
                    } else {
                        DB::rollback();
                        return response_api(false, 400, null, []);
                    }
                }
                if (isset($data['texts'])) {

                    $his_ids = $data['his_ids'] ? array_filter($data["his_ids"], 'myFilter') : [];
                    $parent_ids = $data['parent_ids'] ? array_filter($data["parent_ids"], 'myFilter') : [];
                    $from_chars = $data['from_chars'] ? array_filter($data["from_chars"], 'myFilter') : [];
                    $to_chars = $data['to_chars'] ? array_filter($data["to_chars"], 'myFilter') : [];
                    $texts = $data['texts'] ? array_filter($data["texts"], 'myFilter') : [];


                    $images = (isset($data['images']) && $data['images']) ? array_filter($data["images"], 'myFilter') : [];


                    if ($texts && count($texts) == count($from_chars)
                        && count($texts) == count($to_chars)) {
                        foreach ($texts as $i => $value) {
                            $parent_id = (isset($parent_ids[$i]) && isset($his_ids[$i]) && $parent_ids[$i] == $his_ids[$i]) ? null : (isset($parent_ids[$i]) ? $parent_ids[$i] : null);

                            if (isset($his_ids[$i]) && $this->verseSub->where('id', $his_ids[$i])->first()) {
                                $verse_sub = $this->verseSub->where('id', $his_ids[$i])->first();
                                $verse_sub->update(
                                    [
                                        'parent_id' => $parent_id,
                                        'from_char' => $from_chars[$i],
                                        'to_char' => $to_chars[$i],
                                        'text' => $texts[$i],
                                    ]
                                );
                            } else {

                                $verse_sub = $this->verseSub->create([
                                    'verse_id' => $verse->id,
                                    'parent_id' => $parent_id,
                                    'from_char' => $from_chars[$i],
                                    'to_char' => $to_chars[$i],
                                    'text' => $texts[$i],
                                ]);

                            }


                            if (isset($images[$i])) {
                                $verse_sub->image = $this->storeImage('verse_sub', $images[$i], 1);
                                $verse_sub->save();


                            }

                        }


                    }

                } else {
                    DB::rollback();
                    return response_api(false, 400, null, []);
                }
                DB::commit();
                return response_api(true, 200, __('app.success'), $verse);

            } catch
            (\Exception $e) {
                DB::rollback();
                return response_api(false, 400, $e->getMessage(), []);
            }
        }
        return response_api(false, 422, __('app.error'), []);
    }

    function changeActive($id)
    {

        $verse = $this->model->find($id);
        if (isset($verse)) {
            $verse->is_active = !$verse->is_active;
            if ($verse->save()) {
                return response_api(true, 200, null, $verse);
            }
        }
        return response_api(false, 422);
    }


    function removeSub($id)
    {
        $verseSub = $this->verseSub->find($id);
        if (isset($verseSub) && $verseSub->delete()) {
            return response_api(true, 200, __('app.deleted'), []);
        }
        return response_api(false, 422, null, []);
    }

    function removeSound($id)
    {
        $verseSound = $this->verseSound->find($id);
        if (isset($verseSound) && $verseSound->delete()) {
            return response_api(true, 200, __('app.deleted'), []);
        }
        return response_api(false, 422, null, []);
    }

    function count()
    {
        return $this->model->count();
    }

    function verseSubs($id)
    {
        $subs = $this->model->find($id)->verse_subs()->get();

        return SimpleVerseSubResource::collection($subs);
    }
}
