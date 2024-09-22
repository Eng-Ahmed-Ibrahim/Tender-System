<?php

namespace Modules\Career\Http\Controllers;

use App\Jobs\TranslateText;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Career\Models\CareerCategory;

class CareerCategoryController extends Controller
{
  public function index()
    {
        $categories = CareerCategory::with('children')->whereNull('parent_id')->get();
        return view('career::careerCategory.index', compact('categories'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        $categories = CareerCategory::whereNull('parent_id')->get();
        return view('career::careerCategory.create', compact('categories'));
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate the photo
        ]);
    
        $data = $request->all();
    
        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $data['photo'] = $photoPath; // Save the photo path to the data array
        }
        CareerCategory::create($data);
        $this->translateAndSave($request->all(), 'store');

        return redirect()->route('careerCategories.index')->with('success', 'Category created successfully.');
    }

    // Display the specified resource.
    public function show(CareerCategory $CareerCategory)
    {
        return view('career::careerCategory.show', compact('CareerCategory'));
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        $category = CareerCategory::find($id);
        $categories = CareerCategory::whereNull('parent_id')->get();

        return view('career::careerCategory.edit', compact('category','categories'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, CareerCategory $careerCategory)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:career_categories,id',
        ]);

        $careerCategory->update($request->all());

        return redirect()->route('careerCategories.index')->with('success', 'Category updated successfully.');
    }

    // Remove the specified resource from storage.
    public function destroy(CareerCategory $careerCategory)
    {
        $careerCategory->delete();

        return redirect()->route('careerCategories.index')->with('success', 'Category deleted successfully.');
    }

    protected function translateAndSave(array $inputs, $operation)
    {
        $languages = ['en', 'fr', 'es', 'ar'];
    
        foreach ($inputs as $key => $value) { 
            if (is_string($value) && !empty($value)) {
                // Dispatch the job for each input value
                dispatch(new TranslateText($key, $value, $languages));
            }
        }
    }
}
