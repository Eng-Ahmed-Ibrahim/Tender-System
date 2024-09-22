<?php

namespace Modules\Car\Http\Controllers;

use App\Jobs\TranslateText;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Car\Models\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class BrandController extends Controller
{
       /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $brands = Brand::all();
        return view('car::carBrands.create',compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);
    
        $feature = Brand::create($request->all());

        $this->translateAndSave($request->all(), 'store');

    
        // Return a JSON response for AJAX requests
        return response()->json($feature);
    }
    

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('car::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('car::edit');
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
        $feature = Brand::find($id);
    
        if ($feature) {
            $feature->delete();
            return response()->json(['success' => 'Feature deleted successfully']);
        } else {
            return response()->json(['error' => 'Feature not found'], 404);
        }
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
