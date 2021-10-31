<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VerseSub extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['image', 'parent_id', 'text','verse_id','from_char','to_char'];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function getImageAttribute($value)
    {
        if (isset($value))
            return storage_public($value);
        return 'https://mantenimientocode.xyz/images/not-found.jpg';
    }

    public function getNumberAttribute()
    {

        return getVerseSubNumber($this);
    }

    public function childes()
    {
        return $this->hasMany(VerseSub::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(VerseSub::class, 'parent_id');
    }

    public function getTitleAttribute($value)
    {
        return mb_substr($this->text, 0, 170, 'utf-8');
    }

    public function verse()
    {
        return $this->belongsTo(Verse::class);
    }
}
