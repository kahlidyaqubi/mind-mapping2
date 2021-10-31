<?php

namespace App\Models;

use App\Support\Translateable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use HasFactory;
    use SoftDeletes;

 public function getPhotoAttribute($value)
    {
        if (isset($value))
            return storage_public($value);
        return 'https://mantenimientocode.xyz/images/not-found.jpg';
    }
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    

}
