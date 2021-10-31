<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Surah extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function parts()
    {
        return $this->hasMany(Part::class, 'surah_id', 'id');
    }

    public function rootParts()
    {
        return $this->hasMany(Part::class, 'surah_id', 'id')->whereNull('parent_id');
    }

    public function verses()
    {
        return $this->hasMany(Verse::class, 'surah_id', 'id');
    }

    public function getVerseCountAttribute()
    {

        return $this->verses()->count();
    }
}
