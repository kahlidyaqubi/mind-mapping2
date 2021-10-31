<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FcmNotification extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receivers()
    {
        return $this->belongsToMany(User::class, 'fcm_notification_receivers', 'notification_id', 'receiver_id')->whereNull('fcm_notification_receivers.deleted_at');
    }
}
