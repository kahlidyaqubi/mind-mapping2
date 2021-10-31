<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{

    use HasFactory, Notifiable;
    use SoftDeletes;
    use HasApiTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    function isValidEmailAddress($username)
    {
        return filter_var($username, FILTER_VALIDATE_EMAIL);
    }

    public function getYearAttribute($value)
    {
        return Carbon::parse($value)->format('Y');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function linkedSocialAccounts()
    {
        return $this->hasMany(LinkedSocialAccount::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function notifications()
    {
        return $this->belongsToMany(FcmNotification::class, 'fcm_notification_receivers', 'receiver_id', 'notification_id')->whereNull('fcm_notification_receivers.deleted_at');
    }

    public function fcmTokens()
    {
        return $this->hasMany(FcmToken::class, 'user_id', 'id');
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->attributes['birth_date'])->age;
    }

    public function reciter()
    {
        return $this->belongsTo(Reciter::class, 'reciter_id');
    }
}
