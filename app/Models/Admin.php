<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable, HasRoles;

    protected $guard = 'admin';

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'country_id', 'photo'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

  

    public function logs()
    {
        return $this->morphMany(Log::class, 'logable');
    }

    public function getPhotoAttribute($value)
    {
        if (isset($value))
            return storage_public($value);
        return 'https://mantenimientocode.xyz/images/not-found.jpg';
    }
}
