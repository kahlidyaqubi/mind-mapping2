<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PartRequest;
use App\Models\Part;
use App\Models\Surah;
use App\Repositories\Eloquents\PartEloquent;


class PartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $part;

    public function __construct(PartEloquent $partEloquent)
    {
        $this->part = $partEloquent;
    }

    public function index($surah_id)
    {

        $surah = Surah::find($surah_id);
        $links = [
            '#' => 'الخرائط',
            url(admin_part_url()) => 'إدارة الخرائط',
        ];
        $data = [
            'title' => '(' . $surah->name . ') إدارة خرائط ',
            'icon' => 'fas fa-book-open',
            'links' => $links,
            'surah_id' => $surah_id,
        ];
        return view('admin.parts.index', $data);
    }

    public function tree($surah_id)
    {

        $surah = Surah::find($surah_id);
        $maps = $surah->parts->whereNull('parent_id');
        $links = [
            '#' => 'الخرائط',
            url(admin_part_url()) => 'شجرة الخرائط',
        ];
        $data = [
            'title' => '(' . $surah->name . ') شجرة خرائط ',
            'icon' => 'fas fa-network-wired',
            'links' => $links,
            'surah_id' => $surah_id,
            'maps' => $maps,
        ];
        return view('admin.parts.tree', $data);
    }

    public function anyData($surah_id)
    {
        return $this->part->anyData($surah_id);
    }

    public function changeActive($id)
    {
        return $this->part->changeActive($id);
    }

    public function edit($id)
    {

        $part = $this->part->getById($id);
        $parts = Part::select('id', 'surah_id')->where('id', '!=', $id)->get();
        $surah = $part->surah;
        $view = view()->make(admin_vw() . '.modal', [
            'modal_id' => 'edit-part',
            'modal_title' => 'هذه الخريطة غير متوفرة',
            'close_btn' => 'إغلاق',]);
        if ($part) {
            $view = view()->make(admin_vw() . '.modal', [
                'modal_id' => 'edit-part',
                'modal_title' => 'تعديل  خريطة ' . $part->number,
                'submit_btn' => 'حفظ',
                'close_btn' => 'إغلاق',

                'form' => [
                    'method' => 'PUT',
                    'url' => url(admin_vw() . '/maps/' . $id . '/edit'),
                    'form_id' => 'formEdit',

                    'fields' => [
                        'surah_id' => 'hidden',
                        'name' => 'text',
                        'form_verse' => 'number',
                        'to_verse' => 'number',
                        'video' => 'video_link',
                        'video2' => 'video_link',
                        'image' => 'image',
                    ],
                    'values' => [
                        'surah_id' => $part->surah_id,
                        'name' => $part->name,
                        'form_verse' => $part->form_verse,
                        'to_verse' => $part->to_verse,
                        'image' => $part->image,
                        'video' => $part->video,
                        'video2' => $part->video2,
                    ],
                    'fields_ar' => [
                        'surah_id' => 'SurahId',
                        'name' => 'الاسم',
                        'form_verse' => 'من الآية',
                        'to_verse' => 'إلى الآية',
                        'image' => 'الصورة',
                        'video' => 'فيديو اليوتيوب',
                        'video2' => 'الفيديو الثاني',
                    ],
                    'attribute' => [
                        'form_verse' => 'min=1 max=' . $surah->verse_count . '',
                        'to_verse' => 'min=1 max=' . $surah->verse_count . '',
                        'video' => '-',
                    ],
                ]
            ]);
        }
        return $view->render();
    }

    public function update(PartRequest $request, $id = null)
    {
        return $this->part->update($request->all(), $id);
    }

    public function create($surah_id)
    {
        $parts = Part::select('id', 'name', 'surah_id')->get();
        $surah = Surah::find($surah_id);
        $parent_id = request()->get('parent_id') ?? '';
        $parent = Part::find($parent_id);
        $view = view()->make(admin_vw() . '.modal', [
            'modal_id' => 'add-part',
            'modal_title' => ($parent ? "إضافة خريطة فرعية إلى " . $parent->title : 'إضافة خريطة'),
            'submit_btn' => 'حفظ',
            'close_btn' => 'إغلاق',
            'form' => [
                'method' => 'POST',
                'url' => url(admin_vw() . '/maps/' . $surah->id . '/create'),
                'form_id' => 'formAdd',
                'fields' => [
                    'surah_id' => 'hidden',
                    'name' => 'text',
                    'form_verse' => 'number',
                    'to_verse' => 'number',
                    'parent_id' => 'hidden',
                    'video' => 'video_link',
                    'video2' => 'video_link',
                    'image' => 'image',
                ],
                'values' => [
                    'surah_id' => $surah_id,
                    'parent_id' => $parent_id ?? null,
                ],
                'fields_ar' => [
                    'surah_id' => 'SurahId',
                    'name' => 'الاسم',
                    'form_verse' => 'من الآية',
                    'to_verse' => 'إلى الآية',
                    'parent_id' => 'الجذر',
                    'image' => 'الصورة',
                    'video' => 'فيديو يوتيوب',
                    'video2' => 'الفيديو الثاني',
                ],
                'attribute' => [
                    'form_verse' => 'min=1 max=' . $surah->verse_count . '',
                    'to_verse' => 'min=1 max=' . $surah->verse_count . '',
                    'video' => '-',
                ],

            ]
        ]);

        $html = $view->render();
        return $html;
    }

    public function store(PartRequest $request)
    {
        return $this->part->create($request->all());
    }

    public function delete($id)
    {
        return $this->part->delete($id);
    }
}

