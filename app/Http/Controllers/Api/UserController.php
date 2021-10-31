<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\CreateRequest;
use App\Http\Requests\Api\User\UpdateUserRequest;
use App\Http\Requests\Api\User\VerificationRequest;
use App\Repositories\Eloquents\UserEloquent;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    private $user;

    public function __construct(UserEloquent $user)
    {
        $this->user = $user;
    }

    public function login(Request $request)
    {
        return $this->user->access_token();
    }

    public function refreshToken()
    {
        return $this->user->refreshToken();
    }

    public function create(CreateRequest $request)
    {
        return $this->user->store($request->all());
    }

    public function update(UpdateUserRequest $request)
    {
        return $this->user->update($request->all());
    }


    public function profile($id = null)
    {
        return $this->user->getById($id);
    }

    public function changeStatus()
    {
        return $this->user->changeStatus();
    }

    public function confirmCode(VerificationRequest $request)
    {
        return $this->user->confirmCode($request->all());
    }

    public function logout()
    {
        return $this->user->logout();
    }

}
