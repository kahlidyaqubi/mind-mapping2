<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReciterRequest;
use App\Repositories\Eloquents\ReciterEloquent;


class ReciterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $reciter;

    public function __construct(ReciterEloquent $reciterEloquent)
    {
        $this->reciter = $reciterEloquent;
    }

    public function index()
    {

        $links = [
            '#' => 'القراء',
            url(admin_reciter_url()) => 'إدارة القراء',
        ];
        $data = [
            'title' => 'إدارة القراء',
            'icon' => 'fas fa-microphone-alt',
            'links' => $links,
        ];
        return view('admin.reciters.index', $data);
    }

    public function anyData()
    {
        return $this->reciter->anyData();
    }

    public function changeActive($id)
    {
        return $this->reciter->changeActive($id);
    }

    public function edit($id)
    {

        $reciter = $this->reciter->getById($id);
        $view = view()->make(admin_vw() . '.modal', [
            'modal_id' => 'edit-reciter',
            'modal_title' => 'هذا القارئ غير متوفر',
            'close_btn' => 'إغلاق',]);
        if ($reciter) {
            $view = view()->make(admin_vw() . '.modal', [
                'modal_id' => 'edit-reciter',
                'modal_title' => 'تعديل  قارئ',
                'submit_btn' => 'حفظ',
                'close_btn' => 'إغلاق',

                'form' => [
                    'method' => 'PUT',
                    'url' => url(admin_vw() . '/reciters/' . $id . '/edit'),
                    'form_id' => 'formEdit',

                    'fields' => [
                        'name' => 'text',
                    ],
                    'values' => [
                        'name' => $reciter->name,
                    ],
                    'fields_ar' => [
                        'name' => 'الاسم',
                    ]
                ]
            ]);
        }
        return $view->render();
    }

    public function update(ReciterRequest $request, $id = null)
    {
        return $this->reciter->update($request->all(), $id);
    }

    public function create()
    {
        $view = view()->make(admin_vw() . '.modal', [
            'modal_id' => 'add-reciter',
            'modal_title' => 'إضافة قارئ',
            'submit_btn' => 'حفظ',
            'close_btn' => 'إغلاق',
            'form' => [
                'method' => 'POST',
                'url' => url(admin_vw() . '/reciters/create'),
                'form_id' => 'formAdd',
                'fields' => [
                    'name' => 'text',
                ],
                'fields_ar' => [
                    'name' => 'الاسم',
                ]

            ]
        ]);

        $html = $view->render();

        return $html;
    }

    public function store(ReciterRequest $request)
    {
        return $this->reciter->create($request->all());
    }

    public function delete($id)
    {
        return $this->reciter->delete($id);
    }
}

