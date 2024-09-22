<?php

namespace Modules\Electronics\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Modules\Electronics\Models\Devices;
use Modules\Electronics\Models\Mobiles;
use Modules\Electronics\Models\PhoneImage;
use Modules\Electronics\Models\Electronics;
use Modules\Electronics\Models\DevicesImage;
use Modules\Electronics\Models\PhoneFeatures;

class ElectronicsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('electronics::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('electronics::create',compact('categories'));
    }
    public function categoryCreate(Request $request, $catId)
    {
       
        return view('electronics::create', compact('catId'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'title' => 'required|string',
            'cat_id' => 'required|exists:categories,id',
        ]);

        $electronics = Electronics::create([
            'title' => $request->title,
            'cat_id' => $request->cat_id,
        ]);

        if ($request->type == 'mobile') {
            $request->validate([
                'storage' => 'required|string',
                'ram' => 'required|string',
                'disply_size' => 'required|string',
                'sim_no' => 'required|integer',
                'description' => 'required',
                'mobile_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $mobile = Mobiles::create([
                'title' => $request->title,
                'type' => 'mobile',
                'elec_id' => $electronics->id,
            ]);


            $mobileFeatures = PhoneFeatures::create([

                'storage' => $request->storage,
                'ram' => $request->ram,
                'disply_size' => $request->disply_size,
                'sim_no'=>$request->sim_no,
                'status'=>$request->status,
                'description'=>$request->description,
                'mobile_id'=>$mobile->id,


            ]);





            if($request->hasFile('mobile_images')) {
                foreach ($request->file('mobile_images') as $file) {
                    $path = $file->store('public/mobiles');
                    PhoneImage::create([
                        'mobile_id' => $mobile->id,
                        'photo_path' => Storage::url($path),
                    ]);
                }
            }
        } else if ($request->type == 'device') {
            $request->validate([
                'status' => 'required|in:new,used',
                'description' => 'required|string',
                'device_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $device = Devices::create([
                'title' => $request->title,
                'elec_id' => $electronics->id,
                'status' => $request->status,
                'description' => $request->description,
            ]);

            if($request->hasFile('device_images')) {
                foreach ($request->file('device_images') as $file) {
                    $path = $file->store('public/devices');
                    DevicesImage::create([
                        'device_id' => $device->id,
                        'photo_path' => Storage::url($path),
                    ]);
                }
            }
        }

        return redirect()->route('electronics.create')->with('success', 'Electronics created successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('electronics::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('electronics::edit');
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
