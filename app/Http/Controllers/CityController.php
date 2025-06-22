<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;

class CityController extends Controller
{

    public function index()
    {
        $cities = City::with('country')->get();
        $countries = Country::all();
        return view('country.cities', compact('cities', 'countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:cities,name',
            'country_id' => 'required|exists:countries,id',
        ]);

        City::create([
            'name' => $request->name,
            'name_ar' => $request->name_ar,
            'country_id' => $request->country_id,
        ]);

        return back()->with('success', __('City created successfully.'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:cities,name,' . $id,
            'country_id' => 'required|exists:countries,id',
        ]);

        $city = City::findOrFail($id);
        $city->update([
            'name' => $request->name,
            'name_ar' => $request->name_ar,
            'country_id' => $request->country_id,
        ]);

        return back()->with('success', __('City updated successfully.'));
    }

    public function destroy($id)
    {
        City::destroy($id);
        return back()->with('success', __('City deleted successfully.'));
    }
}
