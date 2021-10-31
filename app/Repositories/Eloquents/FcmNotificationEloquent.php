<?php

namespace App\Repositories\Eloquents;

use App\Http\Resources\FcmNotificationResource;
use App\Models\FcmNotification;
use App\Models\FcmNotificationReceiver;
use App\Models\User;
use App\Repositories\Repository;

class FcmNotificationEloquent implements Repository
{

    public $model, $receiverModel, $notificationSystem, $user, $device;

    public function __construct(FcmNotification $model, FcmNotificationReceiver $receiverModel,
                                DeviceEloquent $device, User $user, NotificationSystemEloquent $notificationSystem)
    {
        $this->model = $model;
        $this->receiverModel = $receiverModel;
        $this->notificationSystem = $notificationSystem;
        $this->user = $user;
        $this->device = $device;
    }

    function anyData()
    {
        $notifications = $this->model->where('action', 'public')->orderByDesc('created_at');

        return datatables()->of($notifications)
            ->filter(function ($query) {
            })
            ->editColumn('message', function ($notification) {
                return $notification->message;
            })->addColumn('delete', function ($notification) {


                return '<a href="' . url(admin_vw() . '/notifications/' . $notification->id) . '" class="btn btn-circle btn-icon-only red delete" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </a>';
            })->addIndexColumn()
            ->rawColumns(['delete'])->toJson();
    }

    function getList(array $data)
    {
        $page_size = isset($data['page_size']) ? $data['page_size'] : max_pagination(10);
        $page_number = isset($data['page_number']) ? $data['page_number'] : 1;
        $collection = $this->model->where('action', '<>', 'chat');
        $count = $collection->count();

        $page_count = page_count($count, $page_size);
        $page_number = $page_number - 1;
        $page_number = $page_number > $page_count ? $page_number = $page_count - 1 : $page_number;
        $object = $collection->take($page_size)->skip((int)$page_number * $page_size)->orderBy('created_at', 'desc')->get();

        return $object;
    }

    function getAll(array $data)
    {
        // TODO: Implement getAll() method.
        $page_size = isset($data['page_size']) ? $data['page_size'] : max_pagination();
        $page_number = isset($data['page_number']) ? $data['page_number'] : 1;

        $notification_id = $this->receiverModel->where('receiver_id', auth()->user()->id)->pluck('notification_id');
        $collection = $this->model->where('action', '<>', 'chat')->whereIn('id', $notification_id);
        $count = $collection->count();

        // seen all my notification
        $collection->update(['seen' => 1]);

        $page_count = page_count($count, $page_size);
        $page_number = $page_number - 1;
        $page_number = $page_number > $page_count ? $page_number = $page_count - 1 : $page_number;
        $object = $collection->take($page_size)->skip((int)$page_number * $page_size)->orderBy('created_at', 'desc')->get();

        if (request()->segment(1) == 'api' || request()->ajax()) {
            if (count($object) > 0) {
                return response_api(true, 200, null, FcmNotificationResource::collection($object), $page_count, $page_number, $count);
            }
            return response_api(false, 422, __('app.not_data_found'), empObj());
        }
        return $object;
    }

    public function getCountUnseen($receiver_id, $is_response = false)
    {
        $notifications_id = $this->receiverModel->where('receiver_id', $receiver_id)->pluck('notification_id');
        $count_notification = $this->model->whereIn('id', $notifications_id)->where('seen', 0)->count();

        if ($is_response)
            return response_api(true, 200, null, ['count_unseen_notification' => $count_notification]);
        return $count_notification;
    }

    function getById($id)
    {
        // TODO: Implement getById() method.
        return $this->model->find($id);
    }

    function create(array $data)
    {
        // TODO: Implement create() method.

        $notification = new FcmNotification();
        $notification->sender_id = $data['sender_id'];
        $notification->action = $data['action'];
        $notification->action_id = $data['action_id'];
        if ($notification->save()) {
            $receiver_notification = new FcmNotificationReceiver();
            $receiver_notification->notification_id = $notification->id;
            $receiver_notification->receiver_id = $data['receiver_id'];
            $receiver_notification->save();

            return $notification;
        }

        return null;
    }

    function update(array $data, $id = null)
    {
        // TODO: Implement update() method.

    }

    function postChatNotification(array $data)
    {
        $receiver = $this->user->find($data['user_id']);
        if (isset($receiver)) {

            $data = [
                'sender_id' => auth()->user()->id,
                'action_id' => auth()->user()->id,
                'action' => 'chat',
            ];

            $chat_notification = $this->model->where('sender_id', auth()->user()->id)->where('action_id', $receiver->id)->where('action', 'chat')->first();

            if (isset($chat_notification))
                $notification = $this->save_chat_notification($data, $chat_notification->id);
            else
                $notification = $this->save_chat_notification($data);

            $badge = $this->getCountUnseen($receiver->id);
            $tokens = $this->device->getReceiverToken($receiver->id);//
            $notification = $this->model->find($notification->id);

            $data = $this->notificationSystem->FCM(config('app.name'), $this->notificationSystem->getActionTrans('chat'), $notification, $tokens, $badge, ''); //$sender_name . ' ' .

            if ($data['numberSuccess'] > 0)
                return response_api(true, 200, __('app.notification_send'), $data);
            return response_api(false, 422, __('app.notification_not_send'), empObj());
        }

        return response_api(false, 422, null, empObj());
    }

    function unseen_chat_notification($receiver_id)
    {
        return $this->model->where('action_id', $receiver_id)->where('action', 'chat')->where('seen', 0)->count();
    }

    function save_chat_notification(array $data, $id = null)
    {
        // TODO: Implement create() method.
        $notification = $this->model->find($id);
        if (!isset($notification))
            $notification = new FcmNotification();
        $notification->sender_id = $data['sender_id'];
        $notification->action = $data['action'];
        $notification->action_id = $data['action_id'];
        $notification->seen = 0;

        if ($notification->save())
            return $notification;
        return null;
    }

    function sendPublicNotification(array $data)
    {
        // TODO: Implement getById() method.
        $notification = new FcmNotification();
        $notification->sender_id = null;
        $notification->action = 'public';
        $notification->message = $data['message'];
        $notification->action_id = null;
        $notification->seen = 0;
        $notification->save();
        return $this->notificationSystem->FCM_Topic($data['message'], $notification);
    }

    function delete($id)
    {
        // TODO: Implement delete() method.
        $notification = $this->model->find($id);
        if (isset($notification) && $notification->delete())
            return response_api(true, 200, __('app.success'), []);
        return response_api(false, 422, null, empObj());
    }
}
