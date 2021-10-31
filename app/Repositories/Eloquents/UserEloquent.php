<?php

namespace App\Repositories\Eloquents;

use App\Http\Resources\UserResource;
use App\Models\FcmToken;
use App\Models\User;
use App\Repositories\Uploader;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mail;

class UserEloquent extends Uploader
{

    private $model, $fcmToken, $notification;

    public function __construct(User $model, FcmToken $fcmToken, NotificationSystemEloquent $notification)
    {
        $this->model = $model;
        $this->fcmToken = $fcmToken;
        $this->notification = $notification;
    }

    // generate access token
    function access_token()
    {

        if (!isset(\request()['username'])) {
            \request()['username'] = \request()['email'];
        }
        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        $response = Route::dispatch($proxy);

        $token_obj = json_decode($response->getContent());
        if (isset($token_obj->error) || !isset($token_obj->access_token)) {
            $statusCode = isset($token_obj->error) ? 401 : 422;
            return response_api(false, $statusCode, __('auth.failed'), empObj());
        }


        \request()->headers->set('Accept', 'application/json');
        \request()->headers->set('Authorization', 'Bearer ' . $token_obj->access_token);
//
        $request = \request()->create(
            'api/profile',
            'GET'
        );
        $response = Route::dispatch($request);

        $data = json_decode($response->getContent());
        $statusCode = json_decode($response->getStatusCode());

        if ($statusCode == 200) {
            $user = $data->items;
        }

        if (!isset($user)) {
            return response_api(false, 422, __('auth.failed'), empObj());
        }

        $user = $this->model->find($user->id);

        $token = empObj();
//
        $token->token_type = $token_obj->token_type;
        $token->expires_in = $token_obj->expires_in;
        $token->access_token = $token_obj->access_token;
        $token->refresh_token = $token_obj->refresh_token;


        if (\request()->filled('device_type')) {
            $device = $this->fcmToken->where('user_id', $user->id)->where('device_id', \request()->get('device_id'))->first();
            if (!isset($device))
                // register device token
                $device = new FcmToken();
            $device->user_id = $user->id;

            if (\request()->filled('device_id'))
                $device->device_id = \request()->get('device_id');
            $device->fcm_token = \request()->get('fcm_token');
            $device->type = \request()->get('device_type');
            $device->status = 'on';

            $device->save();
        }

        return response_api(true, 200, __('app.success'), ['token' => $token, 'user' => new UserResource($user)]);

    }

    // generate refresh token
    function refreshToken()
    {

        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        $response = Route::dispatch($proxy);

        $token_obj = json_decode($response->getContent());
        $statusCode = json_decode($response->getStatusCode());

        if (isset($token_obj->error)) {
            return [
                'status' => false,
                'statusCode' => $statusCode,
                'message' => $token_obj->message,
                'items' => empObj()
            ];
        }
        \request()->headers->set('Accept', 'application/json');
        \request()->headers->set('Authorization', 'Bearer ' . $token_obj->access_token);
//
        $request = \request()->create(
            'api/profile',
            'GET'
        );
//
        $token = empObj();
//
        $token->token_type = $token_obj->token_type;
        $token->expires_in = $token_obj->expires_in;
        $token->access_token = $token_obj->access_token;
        $token->refresh_token = $token_obj->refresh_token;

        $response = Route::dispatch($request);

        $data = json_decode($response->getContent());
        $statusCode = json_decode($response->getStatusCode());

        if ($statusCode == 200) {
            $user = $data->items;
        }

        return response_api(true, 200, __('app.success'), ['token' => $token, 'user' => new UserResource($user)]);
    }

    //table in dashpoard
    function anyData()
    {
        $users = $this->model->whereNotNull('created_at')->orderByDesc('created_at');

        return datatables()->of($users)
            ->filter(function ($query) {

                if (request()->filled('is_active') || request()['is_active'] === "0") {
                    $query->where('is_active', request()['is_active']);
                }
                if (request()->filled('name')) {
                    $query->where('name', 'like', '%' . request()['name'] . '%');
                }
                if (request()->filled('phone')) {
                    $query->where('phone', 'like', '%' . request()['phone'] . '%');
                }
                if (request()->filled('country_id')) {
                    $query->where('country_id', request()->get('country_id'));
                }
            })->editColumn('country_id', function ($user) {
                return $user->country ? $user->country->name : "-";
            })->editColumn('age', function ($user) {
                return $user->age;
            })->editColumn('is_active', function ($user) {
                if ($user->is_active)
                    return '<span class="switch switch-outline switch-icon switch-success">
    <label>
     <input type="checkbox" checked="checked" name="select" class="make-switch active" name="status"
            data-id="' . $user->id . '"/>
     <span></span>
    </label>
   </span>';
                return '<span class="switch switch-outline switch-icon switch-success">
    <label>
     <input type="checkbox" name="select" class="make-switch active" name="status" data-id="' . $user->id . '"/>
     <span></span>
    </label>
   </span>';
            })->addColumn('action', function ($user) {
                return '<a href="' . url(admin_user_url() . '/' . $user->id . '') . '" class="btn btn-sm btn-clean btn-icon edit-new-mdl" title="Edit details"> <i class="la fa-eye"></i> </a>';;
            })->addIndexColumn()
            ->rawColumns(['is_active', 'action'])->toJson();
    }

    // sign up user
    function store(array $data)
    {


        $user = new User();

        if (isset($data['name']))
            $user->name = $data['name'];
        if (isset($data['email']))
            $user->email = $data['email'];
        if (isset($data['phone']))
            $user->phone = $data['phone'];
        if (isset($data['birth_date']))
            $user->birth_date = $data['birth_date'];
        if (isset($data['country_id']))
            $user->country_id = $data['country_id'];
        if (isset($data['memorization_level']))
            $user->memorization_level = $data['memorization_level'];
        if (isset($data['reciter_id']))
            $user->reciter_id = $data['reciter_id'];
        if (isset($data['sound_on']))
            $user->sound_on = $data['sound_on'];
        if (isset($data['alert_on']))
            $user->alert_on = $data['alert_on'];
        if (isset($data['repeat_num']))
            $user->repeat_num = $data['repeat_num'];
        if (isset($data['gender']))
            $user->gender = $data['gender'];
        if (isset($data['password']))
            $user->password = bcrypt($data['password']);


        if ($user->save() && \request()->segment(1) == 'api')
            return $this->access_token();
        else
            return response_api(true, 200, __('app.success'), new UserResource($user));


    }

    // edit and complete profile
    function update(array $data, $id = null)
    {
        if ($id)
            $user = User::find($id);
        else
            $user = authApi();
        if (isset($user)) {
            $message = __('app.user_updated');

            if (isset($data['name']))
                $user->name = $data['name'];
            if (isset($data['email']))
                $user->email = $data['email'];
            if (isset($data['phone']))
                $user->phone = $data['phone'];
            if (isset($data['birth_date']))
                $user->birth_date = $data['birth_date'];
            if (isset($data['reciter_id']))
                $user->reciter_id = $data['reciter_id'];
            if (isset($data['country_id']))
                $user->country_id = $data['country_id'];
            if (isset($data['memorization_level']))
                $user->memorization_level = $data['memorization_level'];
            if (isset($data['sound_on']))
                $user->sound_on = $data['sound_on'];
            if (isset($data['alert_on']))
                $user->alert_on = $data['alert_on'];
            if (isset($data['repeat_num']))
                $user->repeat_num = $data['repeat_num'];
            if (isset($data['gender']))
                $user->gender = $data['gender'];
            if (isset($data['password'])) {

                if (Hash::check($data['old_password'], $user->password)) {
                    $user->password = bcrypt($data['password']);
                    $message = __('app.password_updated');
                } else {
                    return response_api(false, 422, __('app.password_not_match'), empObj());
                }

            }
        }
        $user->save();
        $user = $user->fresh();
        return response_api(true, 200, (request()->segment(1) == 'admin') ? __('app.success') : $message, new UserResource($user));

    }


    function getById($id)
    {

        // TODO: Implement getById() method.
        if (!isset($id) && auth()->check())
            $user = auth()->user();
        else
            $user = $this->model->find($id);

        if (\request()->segment(1) == 'api') {
            if (isset($user))
                return response_api(true, 200, null, new UserResource($user));
            else
                return response_api(false, 422, __('app.not_data_found'), empObj());
        } else {
            return $user;
        }
    }


    function changeStatus()
    {

        $user = auth()->user();

        if (isset($user)) {
            $user->is_active = !$user->is_active;
            $user->save();
            $user = auth()->user()->fresh();
            return response_api(true, 200, null, $user);
        }
        return response_api(false, 422, null, empObj());
    }

    public
    function logout($user_id = null)
    {
        if (!isset($user_id)) {
            $user_id = auth()->user()->id;

            $accessToken = auth()->user()->token();
            $token = \request()->user()->tokens->find($accessToken);
            $token->revoke();

        } else {
            $access_token_id = DB::table('oauth_access_tokens')
                ->where('user_id', '=', $user_id)->pluck('id');

            $token = DB::table('oauth_access_tokens')
                ->where('user_id', '=', $user_id)
                ->update(['revoked' => true]);

            DB::table('oauth_refresh_tokens')
                ->whereIn('access_token_id', $access_token_id)
                ->update(['revoked' => true]);
        }
        // token device
        // turn off mobile // registerId : mac address code
        $device_reset = false;
        if (\request()->filled('device_id'))
            $device_reset = $this->fcmToken->where('user_id', $user_id)->where('device_id', \request()->get('device_id'))->update(['status' => 'off']);
        if (\request()->filled('device_type'))
            $device_reset = $this->fcmToken->where('user_id', $user_id)->where('device_type', \request()->get('device_type'))->update(['status' => 'off']);

        if (!$device_reset)
            $this->fcmToken->where('user_id', $user_id)->update(['status' => 'off']);

        if ($token)
            return response_api(true, 200, null, []);
        return response_api(false, 422, null, empObj());
    }

    function changeActive($id)
    {

        $user = $this->model->find($id);
        if (isset($user)) {
            $user->is_active = !$user->is_active;
            if ($user->save()) {
                return response_api(true, 200, null, $user);
            }
        }
        return response_api(false, 422,null,empObj());
    }


    function delete($id)
    {
        $user = $this->model->find($id);

        if (isset($user) && $user->delete())
            return response_api(true, 200, __('app.deleted'), []);
        return response_api(false, 422, __('app.error'), empObj());
    }

}
