<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LogRequest;
use App\Models\Admin;
use App\Models\Permission;
use App\Models\User;
use App\Repositories\Eloquents\LogEloquent;
use Illuminate\Http\Request;

class LogController extends Controller
{
    //

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $log;

    public function __construct(LogEloquent $logEloquent)
    {
        $this->log = $logEloquent;
    }

    public function index()
    {
        //
        $admins = Admin::all();
        $permissions = Permission::all();

        $links = [
            '#' => 'السجلات',
            url(admin_log_url()) => 'إدارة السجلات',
        ];
        $data = [
            'title' => 'إدارة السجلات',
            'icon' => 'fas fa-clipboard-list',
            'links' => $links,
            'admins' => $admins,
            'permissions' => $permissions,
        ];
        return view(admin_vw() . '.logs.index', $data);
    }

    public function anyData()
    {
        return $this->log->anyData();
    }


}
