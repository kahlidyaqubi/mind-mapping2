<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VerseSound extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['sound','reciter_id','verse_id'];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function reciter()
    {
        return $this->belongsTo(Reciter::class, 'reciter_id');
    }

    public function getSoundAttribute($value)
    {
        if (isset($value))
            return storage_public($value);
        return null;
    }
}
