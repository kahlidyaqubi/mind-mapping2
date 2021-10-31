<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Eloquents\SettingEloquent;

class SettingController extends Controller
{
    //
    private $setting;

    public function __construct(SettingEloquent $setting)
    {
        $this->setting = $setting;
    }
    //show setting details
    public function show($key = null)
    {
        return $this->setting->getByKey($key);
    }

    public function getLookUps($type = null)
    {
        return $this->setting->getLookUps($type);
    }
}
