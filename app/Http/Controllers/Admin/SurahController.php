<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Repositories\Eloquents\SurahEloquent;
use Illuminate\Http\Request;

class SurahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $surah;

    public function __construct(SurahEloquent $surahEloquent)
    {
        $this->surah = $surahEloquent;
    }

    public function index()
    {

        $links = [
            '#' => 'السور',
            url(admin_surah_url()) => 'إدارة السور',
        ];
        $countries = Country::all();
        $data = [
            'title' => 'إدارة السور',
            'icon' => 'fas fa-quran',
            'links' => $links,
        ];
        return view('admin.surahs.index', $data);
    }

    public function anyData()
    {
        return $this->surah->anyData();
    }

    public function changeActive($id)
    {
        return $this->surah->changeActive($id);
    }

    public function edit($id)
    {

        $surah = $this->surah->getById($id);
        $view = view()->make(admin_vw() . '.modal', [
            'modal_id' => 'edit-surah',
            'modal_title' => 'هذه السورة غير متوفرة',
            'close_btn' => 'إغلاق',]);
        if ($surah) {
            $view = view()->make(admin_vw() . '.modal', [
                'modal_id' => 'edit-surah',
                'modal_title' => 'عرض السورة',
                //'submit_btn' => 'حفظ',
                'close_btn' => 'إغلاق',

                'form' => [
                    'method' => 'PUT',
                    'url' => url(admin_vw() . '/surahs/' . $id . '/edit'),
                    'form_id' => 'formEdit',

                    'fields' => [
                        'name' => 'text',
                        'type' => 'text',
                        'page_number' => 'text',
                       // 'video' => 'video_link',
                    ],
                    'values' => [
                        'name' => $surah->name,
                        'type' => $surah->type,
                        'page_number' => $surah->page_number,
                       // 'video' => $surah->video,
                    ],
                    'fields_ar' => [
                        'name' => 'الاسم',
                        'type' => 'النوع',
                        'page_number' => 'رقم الصفحة',
                       // 'video' => 'YouTube Link',
                    ],
                    'attribute' => [
                        'name' => 'disabled',
                        'type' => 'disabled',
                        'page_number' => 'disabled',
                      //  'video' => '-',
                    ],
                ]
            ]);
        }
        return $view->render();
    }

    public function update(Request $request, $id = null)
    {
        return $this->surah->update($request->all(), $id);
    }

}

