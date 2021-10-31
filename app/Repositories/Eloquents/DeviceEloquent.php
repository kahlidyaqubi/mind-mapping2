<?php

namespace App\Repositories\Eloquents;

use App\Models\FcmToken;

class DeviceEloquent
{

    private $model;

    public function __construct(FcmToken $model)
    {
        $this->model = $model;
    }

    function getReceiverToken($receiver_id)
    {
        $token_android = $this->model->where('user_id', $receiver_id)->where('status', 'on')->where('type', 'android')->pluck('fcm_token')->toArray();
        $token_ios = $this->model->where('user_id', $receiver_id)->where('status', 'on')->where('type', 'ios')->pluck('fcm_token')->toArray();
        return [$token_android, $token_ios];
    }


    function refreshFcmToken(array $data)
    {
        $device = $this->model->where('user_id', auth()->user()->id)->where('device_id', $data['device_id'])->first();
        if (isset($device)) {
            $device->fcm_token = $data['fcm_token'];
            if ($device->save())
                return response_api(true, 200, __('app.success'), []);
        }
        return response_api(false, 422, __('app.not_data_found'), empObj());
    }

}
