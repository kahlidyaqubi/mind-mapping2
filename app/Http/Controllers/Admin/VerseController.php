<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Part;
use App\Models\Reciter;
use App\Models\Surah;
use App\Models\Verse;
use App\Models\VerseSub;
use App\Repositories\Eloquents\VerseEloquent;
use Illuminate\Http\Request;


class VerseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $verse;

    public function __construct(VerseEloquent $verseEloquent)
    {
        $this->verse = $verseEloquent;
    }

    public function index($part_id)
    {

        $is_surah = \request()['is_surah'] ?? null;;
        if (\request()['is_surah']) {
            $surah = Surah::findOrFail($part_id);
            $part = null;
        } else {
            $part = Part::findOrFail($part_id);
            $surah = $part->surah;
        }

        $links = [
            '#' => 'الآيات',
            url(admin_verse_url()) => 'إدارة الآيات',
        ];

        $data = [
            'title' => '' . $surah->name . '(' . ($part ? $part->number : '') . ') إدارة آيات ',
            'icon' => 'fas fa-book-open',
            'links' => $links,
            'part_id' => $part_id,
            'is_surah' => $is_surah,
        ];
        return view('admin.verses.index', $data);
    }

    public function anyData($part_id)
    {
        return $this->verse->anyData($part_id);
    }

    public function changeActive($id)
    {
        return $this->verse->changeActive($id);
    }

    public function removeImage($id)
    {
        return $this->verse->removeImage($id);
    }

    public function removeSub($id)
    {
        return $this->verse->removeSub($id);
    }

    public function edit($id)
    {

        $verse = $this->verse->getById($id);
        $part = $verse->part();
        $surah = $verse->surah;
        $reciters = Reciter::all();
        $parents = $verse->verse_subs;
        $links = [
            '#' => 'الآيات',
            url(admin_verse_url()) . "/" . ($part ? $part->id : ($surah->id . '?is_surah=1')) => '' . $surah->name . '(' . ($part ? $part->number : '') . ') قائمة آيات',
            url(admin_verse_url() . "/" . $verse->id . "/edit") => 'تعديل محتوى تفسير آية',
        ];
        $data = [
            'title' => '(..' . mb_substr($verse->text, 0, 170, 'utf-8') . ')تعديل محتوى تفسير آية',
            'icon' => 'fas fa-book-open',
            'links' => $links,
            'verse' => $verse,
            'part' => $verse->part(),
            'parents' => $parents,
            'reciters' => $reciters,
        ];
        return view(admin_vw() . '.verses.add_edit', $data);
    }

    public function update(Request $request, $id = null)
    {
        return $this->verse->update($request->all(), $id);
    }

    public function verseSubs($id = null)
    {
        return $this->verse->verseSubs($id);
    }

    public function tree($verse_id)
    {

        $verse = Verse::find($verse_id);
        $subs = $verse->verse_subs->whereNull('parent_id');
        $part = $verse->part();
        $surah = $verse->surah;
        $links = [
            '#' => 'الآيات',
            url(admin_verse_url()) . "/" . ($part ? $part->id : ($surah->id . '?is_surah=1'))  => '' . $surah->name . '(' . ($part ? $part->number : '') . ') قائمة آيات',
            url(admin_verse_url() . "/" . $verse->id . "/tree") => 'شجرة أجزاء الآية',
        ];
        $data = [
            'title' => '(' . $verse->title . ') شجرة أجزاء الآية ',
            'icon' => 'fas fa-network-wired',
            'links' => $links,
            'verse_id' => $verse_id,
            'subs' => $subs,
        ];
        return view('admin.verses.tree', $data);
    }


}

