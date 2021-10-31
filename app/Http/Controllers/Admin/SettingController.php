<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use App\Models\Country;
use App\Repositories\Eloquents\SettingEloquent;
use Illuminate\Http\Request;

class SettingController extends Controller
{
   private $setting;

    public function __construct(SettingEloquent $settingEloquent)
    {
        $this->setting = $settingEloquent;
    }

    public function index()
    {
        //

        $links = [
            '#Setting' => 'الاعدادات',
            url(admin_setting_url()) => 'إدارة الإعدادت',
        ];
        $countries = Country::all();
        $data = [
            'title' => 'إدارة الإعدادات',
            'icon' => 'fas fa-cogs',
            'countries' => $countries,
            'links' => $links,
        ];
        return view(admin_vw() . '.settings.index', $data);
    }

    public function anyData()
    {
        return $this->setting->anyData();
    }

    public function create()
    {
        $links = [
            '#Setting' => 'الإعدادات',
            url(admin_setting_url()) => 'إدارة الإعدادات',
            url(admin_setting_url() . "/create") => 'إضافة إعداد',
        ];
        $data = [
            'title' => 'إضافة إعداد',
            'icon' => 'fas fa-cogs',
            'links' => $links,
        ];
        return view(admin_vw() . '.settings.add_edit', $data);
    }

    public function store(SettingRequest $request)
    {
        return $this->setting->create($request->all());
    }

    public function update($id, SettingRequest $request)
    {
        return $this->setting->update($request->all(), $id);
    }

    public function edit($id)
    {
        $setting = $this->setting->getById($id);
        if ($setting) {
            $links = [
                '#Setting' => 'الإعدادات',
                url(admin_setting_url()) => 'إدارة الإعدادات',
                url(admin_setting_url() . "/" . $setting->id . "/edit") => 'تعديل ' . $setting->key. ' إعداد',
            ];
            $data = [
                'title' => 'تعديل ' . $setting->key . ' إعداد',
                'icon' => 'fas fa-cogs',
                'links' => $links,
                'setting' => $setting,
            ];
            return view(admin_vw() . '.settings.add_edit', $data);
        }
        return redirect('/not-found');
    }

    public function changeActive(Request $request, $id)
    {
        return $this->setting->changeActive($id);
    }

    public function delete($id)
    {

        return $this->setting->delete($id);
    }

}
