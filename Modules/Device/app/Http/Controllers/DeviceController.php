<?php

namespace Modules\Device\Http\Controllers;

use App\Models\Category;
use App\Models\NormalAds;
use App\Models\CommercialAd;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ads = NormalAds::whereHas('devices')->paginate(10);
        $categories = Category::where('parent_id',20)->get();
        return view('device::device.index',compact('ads','categories'));
    }
    
    public function commercial(){

        $commercialAds  = CommercialAd::Where('cat_id',20)->paginate(10);
        $categories = Category::where('id',13)->first();

        return view('device::device.commercial',compact('commercialAds','categories'));


    }
    public function create(Request $request)
    {
        $cat_id = $request->cat_id;

        $categories =Category::where('parent_id',$cat_id)->get();

        return view('device::device.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('device::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('device::edit');
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
}
