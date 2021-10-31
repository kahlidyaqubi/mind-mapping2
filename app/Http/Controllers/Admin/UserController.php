<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Repositories\Eloquents\UserEloquent;

class UserController extends Controller
{
    //

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $user;

    public function __construct(UserEloquent $userEloquent)
    {
        $this->user = $userEloquent;
    }

    public function index()
    {
        //
        $links = [
            '#' => 'المستخدمين',
            url(admin_user_url()) => 'إدارة المستخدمين',
        ];
        $countries = Country::all();
        $data = [
            'title' => 'إدارة المستخدمين',
            'icon' => 'fas fa-users',
            'links' => $links,
            'countries' => $countries,
        ];
        return view(admin_vw() . '.users.index', $data);
    }

    public function anyData()
    {
        return $this->user->anyData();
    }

    public function changeActive($id)
    {
        return $this->user->changeActive($id);
    }

    public function show($id)
    {

        $user = $this->user->getById($id);
        $countries = Country::all();
        $view = view()->make(admin_vw() . '.modal', [
            'modal_id' => 'show-Users',
            'modal_title' => 'هذا المستخدم غير متوفر',
            'close_btn' => 'إغلاق',]);
        if ($user) {
            $view = view()->make(admin_vw() . '.modal', [
                'modal_id' => 'show-Users',
                'modal_title' => 'عرض المستخدم',
                'close_btn' => 'إغلاق',

                'form' => [
                    'method' => 'PUT',
                    'url' => url(admin_vw() . '/Users/' . $id . '/edit'),
                    'form_id' => 'formEdit',

                    'fields' => [
                        'name' => 'text',
                        'email' => 'email',
                        'password' => 'password',
                        'phone' => 'text',
                        'age' => 'number',
                        'memorization_level' => ['keeper','new'],
                        'country_id' => $countries,

                    ],
                    'values' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                        'age' => $user->age,
                        'memorization_level' =>  $user->memorization_level,
                        'country_id' => $user->country_id,
                        'photo' => $user->photo,

                    ],
                    'attribute' => [
                        'name' => 'disabled',
                        'email' => 'disabled',
                        'password' => 'disabled',
                        'phone' => 'disabled',
                        'age' => 'disabled',
                        'memorization_level' => 'disabled',
                        'country_id' => 'disabled',
                        'photo' => 'disabled',
                    ],
                    'fields_ar' => [
                        'name' => 'الاسم',
                        'email' => 'البريد الإلكتروني',
                        'password' => 'كلمة المرور',
                        'photo' => ['الصورة', '(256*256)'],
                        'phone' => 'الهافت',
                        'age' => 'العمر',
                        'memorization_level' => 'مستوى الحفظ',
                        'country_id' => 'الدولة',
                    ]
                ]
            ]);

        }
        return $view->render();
    }

    public function delete($id)
    {
        return $this->user->delete($id);
    }

}
