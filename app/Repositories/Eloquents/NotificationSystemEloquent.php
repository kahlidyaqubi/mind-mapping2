<?php

namespace App\Repositories\Eloquents;

use App\Models\FcmNotification;
use App\Models\FcmNotificationReceiver;
use App\Models\FcmToken;
use App\Models\User;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Message\Topics;

class NotificationSystemEloquent
{

    private $devices_id;

    public function sendNotification($sender_id, $receiver_id, $action_id, $action) //$object
    {

        $receiver = User::find($receiver_id);
        if ($sender_id != $receiver_id
            && $receiver->is_active == 1) {

            $tokens = FcmToken::getReceiverToken($receiver_id);//

            $this->devices_id = FcmToken::getDevices($receiver_id);
            if (count($tokens) > 0) {

                $data = [
                    'sender_id' => $sender_id,
                    'receiver_id' => $receiver_id,
                    'action_id' => $action_id,
                    'action' => $action,
                ];
                $notification = $this->create($data);

                $message = $this->getActionTrans($action);
                $title = $this->getTitle($action);

                $notification->text = $notification;
                $notification->title = $title;

                $badge = $this->getCountUnseen($receiver_id);
                try {
                    if (count($tokens[0]) > 0 || count($tokens[1]) > 0 || count($this->devices_id) > 0)
                        $fcm_object = $this->FCM(config('app.name'), $message, $notification, $tokens, $badge, $action);
                } catch (\Throwable $e) { // For PHP 7
                    // handle $e
                } catch (\Exception $e) { // For PHP 5
                    // handle $e
                }
            }
        }
    }

    public function FCM($title, $body, $data, $tokens, $badge, $action)
    {

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 20);

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($body)
            ->setSound('default')->setBadge($badge);
        $data->title = $title;

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['data' => $data]);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        if (count($tokens[0]) > 0) {
            // You must change it to get your tokens
            // android
            $downstreamResponse = FCM::sendTo($tokens[0], $option, null, $data);
        }
        if (count($tokens[1]) > 0) {
            //ios
            $downstreamResponse = FCM::sendTo($tokens[1], $option, $notification, $data);
        }

        //return Array - you must remove all this tokens in your database
        $downstreamResponse->tokensToDelete();

        //return Array (key : oldToken, value : new token - you must change the token in your database )
        $downstreamResponse->tokensToModify();

        //return Array - you should try to resend the message to the tokens in the array
        $downstreamResponse->tokensToRetry();

        // return Array (key:token, value:error) - in production you should remove from your database the tokens present in this array
        $downstreamResponse->tokensWithError();

        // return Array (key:token, value:error) - in production you should remove from your database the tokens
        $object = [
            'numberSuccess' => $downstreamResponse->numberSuccess(),
            'numberFailure' => $downstreamResponse->numberFailure(),
            'numberModification' => $downstreamResponse->numberModification(),
        ];

        return $object;
    }

    public function FCM_Topic($body, $data)
    {
        $notificationBuilder = new PayloadNotificationBuilder(config('app.name'));
        $notificationBuilder->setBody($body)
            ->setSound('default');


        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['data' => $data]);
        $data = $dataBuilder->build();

        $notification = $notificationBuilder->build();

        $topic = new Topics();
        $topic->topic('EzGetNotification');

        $topicResponse = FCM::sendToTopic($topic, null, $notification, $data);

        $object = [
            'numberSuccess' => $topicResponse->isSuccess(),
            'numberFailure' => $topicResponse->shouldRetry(),
            'numberModification' => $topicResponse->error(),
        ];

        return response_api(true, 200, null, $object);
    }

    public function getActionTrans($action)
    {
        switch ($action) {

            default:
                return __(notification_trans() . '.chat'); //chat user // action_id : auth id
        }
    }

    public function getTitle($action)
    {
        switch ($action) {

            case 'rate':
                return __(notification_trans() . '.title.rate');
            default:
                return __(notification_trans() . '.title.chat'); //chat user // action_id : auth id
        }
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

    public function getCountUnseen($receiver_id)
    {
        $notifications_id = FcmNotificationReceiver::where('receiver_id', $receiver_id)->pluck('notification_id');
        return FcmNotification::whereIn('id', $notifications_id)->where('seen', 0)->count();
    }
}
