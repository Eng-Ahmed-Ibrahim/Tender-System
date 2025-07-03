<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\BaseController;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::orderBy("id", "DESC")->get();
        return view("country.index", compact('countries'));
    }
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|unique:countries,name",
            "name_ar" => "required|unique:countries,name_ar",
            "currency" => "required|string|max:3", // Assuming currency is a 3-letter code
            "currency_ar" => "required|string", // Assuming currency is a 3-letter code
        ]);
        Country::create([
            "name" => $request->name,
            "name_ar" => $request->name_ar,
            "currency"=>$request->currency,
            "currency_ar"=>$request->currency_ar,

        ]);
        session()->flash("success", __("Created Successfully"));
        return back();
    }

    public function update(Request $request, $id)
    {
        $country = Country::findOrFail($id);

        $request->validate([
            'name' => [
                'required',
                Rule::unique('countries')->ignore($country->id)
            ]
        ]);

        $country->update([
            'name' => $request->name,
            'name_ar' => $request->name_ar,
            'currency' => $request->currency,
            'currency_ar' => $request->currency_ar,
        ]);

        session()->flash('success', __('Updated Successfully'));
        return back();
    }
    public function delete( $id)
    {
        $country = Country::findOrFail($id);
        $country->delete();
        session()->flash('success', __('Deleted Successfully'));
        return back();
    }
}
