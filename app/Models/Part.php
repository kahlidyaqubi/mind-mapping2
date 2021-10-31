<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Part extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($part) {
            $part->verses()->update(['part_id' => null]);
        });
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }
    public function getYearAttribute($value)
    {
        return Carbon::parse($value)->format('Y');
    }
    public function surah()
    {
        return $this->belongsTo(Surah::class, 'surah_id');
    }

    public function verses()
    {
        return $this->belongsToMany(Verse::class, 'part_verses');
    }

    public function partVerses()
    {
        return $this->hasMany(PartVerse::class);
    }

    public function getImageAttribute($value)
    {
        if (isset($value))
            return storage_public($value);
        return 'https://mantenimientocode.xyz/images/not-found.jpg';
    }

    public function getTitleAttribute($value)
    {
        return $this->name . " - " . $this->number . "(" . $this->form_verse . "-" . $this->to_verse . ")";
    }

    public function getNumberAttribute()
    {

        return getPartNumber($this);
    }

    public function getFormVerseAttribute()
    {

        return $this->verses()->orderBy('number')->first()->number;
    }

    public function getToVerseAttribute()
    {

        return $this->verses()->orderByDesc('number')->first()->number;
    }

    public function childes()
    {
        return $this->hasMany(Part::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Part::class, 'parent_id');
    }
}
