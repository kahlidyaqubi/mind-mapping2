<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Models\Country;
use App\Repositories\Eloquents\AdminEloquent;
use Illuminate\Http\Request;
use App\Models\Permission;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $admin;

    public function __construct(AdminEloquent $adminEloquent)
    {
        $this->admin = $adminEloquent;
    }

    public function index()
    {

        $links = [
            '#' => 'مدراء',
            url(admin_admin_url()) => 'إدارة المدراء',
        ];
        $countries = Country::all();
        $data = [
            'title' => 'إدارة المدراء',
            'icon' => 'fas fa-users',
            'links' => $links,
            'countries' => $countries,
        ];
        return view('admin.admins.index', $data);
    }

    public function profile()
    {
        //

        $links = [
            '#' => 'مدراء',
            url(admin_admin_url() . "/profile") => 'بروفايل',
        ];
        $admin = authAdmin();
        $countries = Country::all();
        $data = [
            'title' => $admin->name . ' بروفايل',
            'icon' => 'fas fa-users',
            'links' => $links,
            'countries' => $countries,
            'admin' => $admin,
        ];
        return view('admin.admins.edit', $data);
    }

    public function anyData()
    {
        return $this->admin->anyData();
    }

    public function changeActive($id)
    {
        return $this->admin->changeActive($id);
    }


    public function edit($id)
    {

        $admin = $this->admin->getById($id);
        $countries = Country::all();
        $view = view()->make(admin_vw() . '.modal', [
            'modal_id' => 'edit-admin',
            'modal_title' => 'هذا المدير غير موجود',
            'close_btn' => 'إغلاق',]);
        if ($admin) {
            $view = view()->make(admin_vw() . '.modal', [
                'modal_id' => 'edit-admin',
                'modal_title' => 'تعديل ' . $admin->name . ' مدير',
                'submit_btn' => 'حفظ',
                'close_btn' => 'إغلاق',

                'form' => [
                    'method' => 'PUT',
                    'url' => url(admin_vw() . '/admins/' . $id . '/edit'),
                    'form_id' => 'formEdit',

                    'fields' => [
                        'name' => 'text',
                        'email' => 'email',
                        'password' => 'password',
                        'phone' => 'text',
                        'photo' => 'image',
                    ],
                    'values' => [
                        'name' => $admin->name,
                        'phone' => $admin->phone,
                        'email' => $admin->email,
                        'password' => '',
                        'photo' => $admin->photo,
                    ],
                    'fields_ar' => [
                        'name' => 'الاسم',
                        'phone' => 'الهاتف',
                        'email' => 'البريد الإلكتروني',
                        'password' => 'كلمة المرور',
                        'photo' => 'الصورة',
                    ]
                ]
            ]);
        }
        return $view->render();
    }

    public function update(AdminRequest $request, $id = null)
    {
        if ($request->segment(3) == 'profile')
            $id = authAdmin()->id;
        return $this->admin->update($request->all(), $id);
    }

    public function create()
    {
        $countries = Country::all();
        $view = view()->make(admin_vw() . '.modal', [
            'modal_id' => 'add-admin',
            'modal_title' => 'إضافة مدير',
            'submit_btn' => 'حفظ',
            'close_btn' => 'إغلاق',
            'form' => [
                'method' => 'POST',
                'url' => url(admin_vw() . '/admins/create'),
                'form_id' => 'formAdd',
                'fields' => [
                    'name' => 'text',

                    'phone' => 'text',
                    'email' => 'email',
                    'password' => 'password',
                    'photo' => 'image',
                ],
                'fields_ar' => [
                    'name' => 'الإسم',
                    'phone' => 'الهاتف',
                    'email' => 'البريد الإلكتروني',
                    'password' => 'كلمة المرور',
                    'photo' => 'الصورة',
                ]

            ]
        ]);

        $html = $view->render();

        return $html;
    }

    public function store(AdminRequest $request)
    {
        return $this->admin->create($request->all());
    }

    public function delete($id)
    {
        return $this->admin->delete($id);
    }

    public function permission($id)
    {
        $admin = $this->admin->getById($id);

        if ($admin) {
            $all_permissions = Permission::where('parent_id', 0)->withCount('childes')->get()->sortByDesc('childes_count');
            $links = [
                '#' => 'مدراء',
                url(admin_admin_url()) => 'إدارة المدراء',
                url(admin_admin_url()) . "/" . $id . "/permissions" => 'صلاحيات المدير',
            ];
            $data = [
                'title' => $admin->name . 'صلاحيات',
                'icon' => 'fas fa-users',
                'links' => $links,
                'admin' => $admin,
                'all_permissions' => $all_permissions,
            ];
            return view('admin.admins.permissions', $data);
        } else
            return redirect('/not-found');
    }

    public function permissionPost($id, Request $request)
    {
        return $this->admin->permissionPost($id, $request->get('permissions'));
    }

    public function logs($id)
    {
        $admin = authAdmin();
        $permissions = Permission::all();
        if ($id == $admin->id) {

            $links = [
                '#' => 'مدراء',
                url(admin_admin_url()) => 'إدارة المدراء',
                url(admin_admin_url()) . "/" . $id . "/logs" => $admin->name . ' سجلات',
            ];
            $data = [
                'title' => $admin->name . ' سجلات',
                'icon' => 'fas fa-users',
                'links' => $links,
                'admin' => $admin,
                'permissions' => $permissions,
            ];
            return view('admin.admins.logs', $data);
        } else
            return redirect('/not-found');
    }

    public function logsData($id)
    {
        return $this->admin->logsData($id);
    }

}

