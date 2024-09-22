<?php

namespace Modules\Bike\Http\Controllers;

use App\Jobs\TranslateText;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Modules\Bike\Models\BikeFeature;
use Illuminate\Http\RedirectResponse;

class BikeFeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('bike::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $features = BikeFeature::all();
        return view('bike::bikeFeatures.create',compact('features'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        BikeFeature::create($request->all());
        $this->translateAndSave($request->all(), 'store');

        return redirect()->back()->with('success', 'Feature created successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('bike::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('bike::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    
    protected function translateAndSave(array $inputs, $operation)
{
    $languages = ['en', 'fr', 'es', 'ar', 'de', 'tr', 'it', 'ja', 'zh', 'ur'];

    foreach ($inputs as $key => $value) { 
        if (is_string($value) && !empty($value)) {
            // Dispatch the job for each input value
            dispatch(new TranslateText($key, $value, $languages));
        }
    }
}

}
