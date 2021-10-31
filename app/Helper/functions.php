<?php

use App\Models\OrderOperation;
use \Illuminate\Support\Facades\DB;


function getSettingByKey($key)
{
    $setting = \App\Models\Setting::where('key', $key)->first();
    if (isset($setting)) {
        return $setting->value;
    }
}

function firebaseData($id)
{
    $serviceAccount = (new \Kreait\Firebase\Factory())->withServiceAccount(__DIR__ . '/firebase-db.json');
    $database = $serviceAccount->createDatabase();

    $c = $database->getReference('driver_location/' . $id)->getvalue();
    $rr = json_encode($c, true);
    $rr = json_decode($rr, true);

    if (isset($rr))
        return $rr;
}

function firebase_connection()
{
    $serviceAccount = (new \Kreait\Firebase\Factory())->withServiceAccount(__DIR__ . '/firebase-db.json');
    $database = $serviceAccount->createDatabase();

    return $database;
}

function convetYoutubeLinkToEmbed($link)
{
    return preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i", "https://www.youtube.com/embed/$1", $link);

}


function getPartNumber($part)
{

    $parts = $part->surah->parts;

    $the_part_id = $part->id;
    $i = 1;
    $the_i = 1;


    $parts = $parts->sort(function ($a, $b) {
        return (
            ($a->verses->min('number') < $b->verses->min('number'))
            &&
            $a->parent_id != $b->id

        ) ? -1 : 1;
    });

    $parts = $parts->sort(function ($a, $b) {
        if ($a->verses->min('number') == $b->verses->min('number'))
            return (
            ($a->verses->max('number') > $b->verses->max('number'))
            ) ? -1 : 1;
        else
            return (
                ($a->verses->min('number') < $b->verses->min('number'))
                &&
                $a->parent_id != $b->id

            ) ? -1 : 1;
    });

    foreach ($parts as $key => $part) {
        if ($part->id == $the_part_id)
            $the_i = $i;
        $i++;
    }
    return $the_i;
}

function getVerseSubNumber($verseSub)
{


    $verseSubs = $verseSub->verse->verse_subs;

    $verseSub_id = $verseSub->id;

    $i = 1;
    $the_i = 1;


    $verseSubs = $verseSubs->sort(function ($a, $b) {
        return (
            ($a->from_char < $b->from_char)
            &&
            $a->parent_id != $b->id

        ) ? -1 : 1;
    });

    $verseSubs = $verseSubs->sort(function ($a, $b) {
        if ($a->from_char == $b->from_char)
            return (
            ($a->to_char > $b->to_char)
            ) ? -1 : 1;
        else
            return (
                ($a->from_char < $b->from_char)
                &&
                $a->parent_id != $b->id

            ) ? -1 : 1;
    });



    foreach ($verseSubs as $key => $verseSub) {
        if ($verseSub->id == $verseSub_id)
            $the_i = $i;
        $i++;
    }
    return $the_i;
}
