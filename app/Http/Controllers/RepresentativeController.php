<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Representative;
use Illuminate\Support\Facades\Storage;

class RepresentativeController extends Controller
{
    public function index() {
        $representatives = Representative::all();
        return view('backend.representative.index', compact('representatives'));
    }

    public function create() { 
        return view('backend.representative.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'phone' => 'required|numeric',
            'whatsapp' => 'required|numeric',
        ]);
        $countryId = $request->session()->get('country_id');

        // Create a new representative record
        $representative = new Representative();
        $representative->name = $request->input('name');
        $representative->phone = $request->input('phone');
        $representative->whatsapp = $request->input('whatsapp');
        $representative->country_id = $countryId;

        if ($request->hasFile('photo')) {
            $representative->photo = $request->file('photo')->store('photos');
        }

        $representative->save();

        return response()->json(['success' => 'Data saved successfully.']);
    }

    public function edit($id)
    {
        $representative = Representative::findOrFail($id);
        return view('backend.representative.edit', compact('representative'));
    }

    public function update(Request $request, $id)
    {
        $representative = Representative::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'phone' => 'required|numeric',
            'whatsapp' => 'required|numeric',
        ]);

        $representative->name = $request->input('name');
        $representative->phone = $request->input('phone');
        $representative->whatsapp = $request->input('whatsapp');

        if ($request->hasFile('photo')) {
            // Delete the old photo if it exists
            if ($representative->photo) {
                Storage::delete($representative->photo);
            }
            $representative->photo = $request->file('photo')->store('photos','public');
        }

        $representative->save();

        return redirect()->route('representative.index');
    }

    public function destroy($id)
{
    // Find the representative by ID or fail if not found
    $representative = Representative::findOrFail($id);

    // Delete the representative's photo if it exists
    if ($representative->photo) {
        // Delete the photo from storage
        Storage::delete($representative->photo);
    }

    // Delete the representative record from the database
    $representative->delete();

    // Return a JSON response indicating success
    return redirect()->back();

}

}
