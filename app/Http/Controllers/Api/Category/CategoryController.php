<?php

namespace App\Http\Controllers\Api\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function MainCategory()

    {
        $categories = Category::whereNull('parent_id')->get();
    
        return CategoryResource::collection($categories);
    }
      public function SubCategory($cat_id)
    
    {
        $categories = Category::where('parent_id',$cat_id)->get();
    
        return CategoryResource::collection($categories);
    }
    
   
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
