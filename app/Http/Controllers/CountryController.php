<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class CountryController extends BaseController
{
    protected $modelClass = Country::class;
    protected $viewPrefix = 'backend.countries';
    protected $routePrefix = 'countries';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:countries,code', // Ensure unique validation for 'code'
        ];
    }


    public function updateCountrySession(Request $request)
    {
        $countryId = $request->input('country_id');

        $request->session()->put('country_id', $countryId);
    
        return redirect()->back();
    }

    

}