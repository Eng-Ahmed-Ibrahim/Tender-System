<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Jobs\TranslateText;
use Illuminate\Http\Request;

class CategoryController extends Controller
{ 
    


    public function index(Request $request)
    {
        $categoryType = $request->input('category_type', 'all');
        
        $categories = Category::with('children')
            ->when($categoryType === 'main', function ($query) {
                $query->whereNull('parent_id');
            })
            ->when($categoryType === 'sub', function ($query) {
                $query->whereNotNull('parent_id');
            })
            ->get();
        
        return view('backend.categories.index', compact('categories', 'categoryType'));
    }
    
    
        // Show the form for creating a new resource.
        public function create()
        {
            $categories = Category::whereNull('parent_id')->get();
            return view('backend.categories.create', compact('categories'));
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
        
            $category = Category::create($data);
            $this->translateAndSave($data, 'store');
        
            return redirect()->route('categories.index')->with('success', 'Category created successfully.');
        }
        
    
        // Display the specified resource.
        public function show(Category $Category)
        {
            return view('backend.categories.show', compact('Category'));
        }
    
        // Show the form for editing the specified resource.
        public function edit($id)
        {
            $category = Category::find($id);
            $categories = Category::whereNull('parent_id')->get();
    
            return view('backend.categories.edit', compact('category','categories'));
        }
    
        // Update the specified resource in storage.
        public function update(Request $request, Category $Category)
        {
            $request->validate([
                'title' => 'required|string|max:255',
                'parent_id' => 'nullable|exists:categories,id',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate the photo

            ]);
            $data = $request->all();


            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('photos', 'public');
                $data['photo'] = $photoPath; // Save the photo path to the data array
            }
        
    
            $Category->update($data); 
    
            return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
        }
    
        // Remove the specified resource from storage.
        public function destroy(Category $Category)
        {
            $Category->delete();
    
            return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
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
    

