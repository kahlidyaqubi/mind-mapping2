<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Eloquents\CountryEloquent;

class ConstantController extends Controller
{
    //
    private $country;

    public function __construct(CountryEloquent $countryEloquent)
    {
        $this->country = $countryEloquent;
    }

    //get all active countries
    public function countries()
    {
        return $this->country->getAll([]);
    }

}
