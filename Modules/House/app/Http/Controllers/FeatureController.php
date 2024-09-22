<?php

namespace Modules\House\Http\Controllers;

use App\Jobs\TranslateText;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\House\Models\Feature;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('house::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $features = Feature::all();
        return view('house::houseFeatures.create',compact('features'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        Feature::create($request->all());

        $this->translateAndSave($request->all(),'store');

        return redirect()->back()->with('success', 'Feature created successfully.');
    }


    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('house::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Feature $feature)
    {
        return view('house::housefeatures.edit', compact('feature'));
    }

    /**
     * Update the specified feature in storage.
     */
    public function update(Request $request, Feature $feature)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $feature->update($request->all());

        return redirect()->route('house-features.create')->with('success', 'Feature updated successfully.');
    }

    /**
     * Remove the specified feature from storage.
     */
    public function destroy(Feature $feature)
    {
        $feature->delete();

        return redirect()->route('features.index')->with('success', 'Feature deleted successfully.');
    }


    protected function translateAndSave(array $inputs, $operation)
    {
        $languages = ['en', 'fr', 'es', 'ar', 'de', 'tr', 'it', 'ja', 'zh', 'ur'];
    
        foreach ($inputs as $key => $value) { 
            if (is_string($value) && !empty($value)) {
                dispatch(new TranslateText($key, $value, $languages));
            }
        }
    }
    
}
