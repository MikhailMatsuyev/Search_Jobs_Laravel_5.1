<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\SubCategories;
use App\Tags;

class APIController extends Controller
{

    public function getSubCategories($category_id = 0)
    {

        if ($category_id == null || $category_id == 0) {
            return SubCategories::all();
        }

        return SubCategories::where('parent_id', $category_id)->get();
    }

    public function getTags()
    {
        return Tags::lists('title');
    }


    public function getCities($id)
    {


        $state = \DB::table('states')->where('name', $id)->first();


        $cities = \DB::table('cities')->where('state_id', $state->id)->get();


        return $cities;

    }

    public function getAdminStates($id)
    {


        $country = \DB::table('countries')->where('name', $id)->first();


        $states = \DB::table('states')->where('country_id', $country->id)->get();


        return $states;

    }


    public function getKeywords()
    {

        $id = \Input::get('query');

        $keywords = \DB::table('keywords')->where('keyword', 'LIKE', '%' . $id . '%')->lists('keyword');

        return ['suggestions' => $keywords];

    }

    public function getCountries()
    {

        $id = \Input::get('query');

        $countries = \DB::table('countries')->where('name', 'LIKE', '%' . $id . '%')->lists('name');

        return ['suggestions' => $countries];

    }

    public function getStates()
    {

        $id = \Input::get('query');

        $country = \Input::get('country');

        if (is_null($country) || strlen($country) == 0) {
            $states = \DB::table('states')->where('name', 'LIKE', '%' . $id . '%')->lists('name');
        } else {
            $country_list = \DB::table('countries')->where('name', $country)->first();
            $states = \DB::table('states')->where('country_id', $country_list->id)->where('name', 'LIKE', '%' . $id . '%')->lists('name');
        }


        $pattern = [];

        foreach ($states as $state) {
            $n = new \stdClass();
            $n->value = $state;
            $n->date = $state;

            $pattern[] = $n;
        }


        return ['suggestions' => $pattern];

    }

    public function getcity()
    {

        $id = \Input::get('query');

        $state = \Input::get('state');

        if (is_null($state) || strlen($state) == 0) {
            $cities = \DB::table('cities')->where('name', 'LIKE', '%' . $id . '%')->lists('name');
        } else {
            $state_list = \DB::table('states')->where('name', $state)->first();
            $cities = \DB::table('cities')->where('state_id', $state_list->id)->where('name', 'LIKE', '%' . $id . '%')->lists('name');
        }


        $pattern = [];

        foreach ($cities as $city) {
            $n = new \stdClass();
            $n->value = $city;
            $n->date = $city;

            $pattern[] = $n;
        }


        return ['suggestions' => $pattern];

    }


}