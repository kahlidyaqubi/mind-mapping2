<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reciter extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }


    public function sounds()
    {
        return $this->hasMany(VerseSound::class, 'reciter_id', 'id');
    }
}
