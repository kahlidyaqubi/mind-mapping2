<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Verse extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['part_id'];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function surah()
    {
        return $this->belongsTo(Surah::class, 'surah_id');
    }

    public function part() // directPart
    {
        return $this->parts()->doesntHave('childes')->first();
    }

    public function parts()
    {
        return $this->belongsToMany(Part::class, 'part_verses');
    }

    public function sounds()
    {
        return $this->hasMany(VerseSound::class, 'verse_id', 'id');
    }

    public function verse_subs()
    {
        return $this->hasMany(VerseSub::class, 'verse_id', 'id');
    }

    public function getTitleAttribute($value)
    {
        return mb_substr($this->text, 0, 170, 'utf-8');
    }
}
