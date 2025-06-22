<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Http\Resources\CountryResource;

class CountryController extends Controller
{
    public function countries()
    {
        $data=CountryResource::collection(Country::all());
        return response()->json([
            'status' => true,
            'message' => 'Countries ',
            'data' => $data
        ]);
    }
    public function cities(Request $request){
        $data= CityResource::collection( City::where("country_id",$request->country_id)->get() );
        return response()->json([
            "status"=>true,
            'message' => 'Cities ',
            "data"=>$data,
        ]);
    }
}
