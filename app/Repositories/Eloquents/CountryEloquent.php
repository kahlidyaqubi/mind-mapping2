<?php

namespace App\Repositories\Eloquents;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\CityResource;
use App\Http\Resources\CountryResource;
use App\Http\Resources\CurrencyResource;
use App\Http\Resources\FeatureResource;
use App\Http\Resources\UserResource;
use App\Models\Country;
use App\Models\CountryTranslation;
use App\Models\Language;
use App\Repositories\Repository;
use Excel;
use Illuminate\Support\Facades\DB;

class CountryEloquent
{

    private $model;

    public function __construct(Country $model)
    {
        $this->model = $model;
    }

    function getAll(array $data)
    {

        // TODO: Implement getAll() method.

        $lists = $this->model->where('is_active', 1)->get();
        if (request()->segment(1) == 'api') {
            return response_api(true, 200, null, CountryResource::collection($lists));
        }
        return $lists;
    }

    function getById($id)
    {
        return $this->model->find($id);
    }

    function getByTitle($title)
    {
        // TODO: Implement getById() method.
    }
}
