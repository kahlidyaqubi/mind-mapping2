<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Verse\GetRequest;
use App\Repositories\Eloquents\PartEloquent;
use App\Repositories\Eloquents\ReciterEloquent;
use App\Repositories\Eloquents\SurahEloquent;
use App\Repositories\Eloquents\VerseEloquent;
use Illuminate\Http\Request;

class AppController extends Controller
{
    private $surah;
    private $part;
    private $verse;
    private $reciter;

    public function __construct(SurahEloquent $surahEloquent, PartEloquent $partEloquent, VerseEloquent $verseEloquent, ReciterEloquent $reciterEloquent)
    {
        $this->surah = $surahEloquent;
        $this->part = $partEloquent;
        $this->verse = $verseEloquent;
        $this->reciter = $reciterEloquent;
    }

    public function suras(Request $request)
    {
        return $this->surah->getAll($request->all());
    }

    public function surah($id)
    {
        return $this->surah->getById($id);
    }

    public function part($id)
    {
        return $this->part->getById($id);
    }

    public function verses(GetRequest $request)
    {
        return $this->verse->getAll($request->all());
    }

    public function verse($id, Request $request)
    {
        return $this->verse->getById($id, $request->all());
    }

    public function reciters(Request $request)
    {
        return $this->reciter->getAll($request->all());
    }

}
