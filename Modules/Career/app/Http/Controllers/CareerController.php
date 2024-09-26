<?php

namespace Modules\Career\Http\Controllers;

use App\Models\Category;
use App\Models\NormalAds;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\AdLimitServices;
use Modules\Career\Models\Careers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Modules\Career\Models\CareerCategory;

class CareerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ads = NormalAds::whereHas('careers')->get();

        return view('career::index',compact('ads'));
    }
    public function create(Request $request)
    {

        $cat_id = $request->cat_id;

    

        $categories =Category::where('parent_id',11)->get();
    

        return view('career::create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'You must be logged in to post an ad.');
        }
    
        $user = Auth::user();
    
        if ($user->role_id === 2) {

            $this->processAd($request);
            
    
            return redirect()->route('career.index')->with('success', 'Career created successfully.');
        } else {
        //    $adLimitService = new AdLimitServices();
    
         //   if (!$adLimitService->canPostAd('normal')) {
           //     return redirect()->back()->with('error', 'You have reached your ad posting limit.');
           // }
    
            $this->processAd($request);
    
    
            return redirect()->route('career.index')->with('success', 'Career created successfully.');
        }
    }
    

    protected function processAd(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cat_id' => 'required|exists:categories,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'experience_year' => 'required|string',
            'experience_level' => 'required|string',
            'cv_file' => 'required|file|mimes:pdf,doc,docx',
        ]);
    
        $countryId = $request->session()->get('country_id');
    
        $ad = new NormalAds([
            'title' => $validatedData['title'],
            'country_id' => $countryId,
            'cat_id' => $validatedData['cat_id'],
            'address' => $validatedData['address'],
            'description' => $validatedData['description'],
            'price' => 0,
            'is_active' => true, 
        ]);
        $ad->save();
    
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $ad->photo = $photoPath;
            $ad->save(); 
        }
    
       
        $path = $request->file('cv_file')->store('cv_files','public');

        Careers::create([
            'experience_year' => $request->experience_year,
            'experience_level' => $request->experience_level,
            'cv_file' => $path,
            'normal_id' =>$ad->id
        ]);
      
    
      
    
        return redirect()->route('carrer.index')->with('success', __('Car ad created successfully.'));
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('career::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Careers $career)
    {
        $categories = CareerCategory::all();
        return view('career::edit', compact('career', 'categories'));
    }

    public function update(Request $request, Careers $career)
    {


        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'cat_id' => 'required|exists:career_categories,id',
            'experience_year' => 'required|string',
            'experience_level' => 'required|string',
            'cv_file' => 'nullable|file|mimes:pdf,doc,docx',
        ]);

        $data = $request->only(['title', 'description', 'is_active', 'cat_id', 'experience_year', 'experience_level']);

        if ($request->hasFile('cv_file')) {
            $path = $request->file('cv_file')->store('cv_files','public');
            $data['cv_file'] = $path;
        }

        $career->update($data);

        return redirect()->route('career.index')->with('success', 'Career updated successfully.');
    }

    public function destroy(Careers $career)
    {
        $career->delete();
        return redirect()->route('careers.index')->with('success', 'Career deleted successfully.');
    }
}
