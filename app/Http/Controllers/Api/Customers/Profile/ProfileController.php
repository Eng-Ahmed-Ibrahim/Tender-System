<?php

namespace App\Http\Controllers\Api\Customers\Profile;

use App\Models\Customers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customerId = Auth::guard('customer')->id(); 
        
        $customer = Customers::find($customerId);
    
        if (!$customer) {
            return response()->json([
                'message' => 'Customer not found.'
            ], 404);
        }
    
        // Prepare the photo URL
        $photoUrl = $customer->photo ? asset('storage/' . $customer->photo) : asset('assets/images.jpeg');
    
        return response()->json([
            'customer' => [
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'address' => $customer->address,
                'facebook' => $customer->facebook,
                'instgram' => $customer->instgram,
                'twitter' => $customer->twitter,
                'linkedIn' => $customer->linkedIn,
                'youtube' => $customer->youtube,
                'pther' => $customer->other,
                'photo' => $photoUrl, // Return the photo as a full URL
            ]
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
      
    }
    
  
    public function update(Request $request, $id)
    {
        $customerId = Auth::guard('customer')->id();
        $customer = Customers::find($customerId);
    
        if (!$customer) {
            return response()->json([
                'message' => 'Customer not found.'
            ], 404);
        }
    
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:customers,email,' . $customerId,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Validate photo
        ]);
    
        // Handle the photo upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store('photos', 'public'); // Store the file in the 'public/photos' directory
    
            // Update the photo path in the validated data
            $validatedData['photo'] = $photoPath;
    
            // Optionally, delete the old photo if needed
            if ($customer->photo) {
                Storage::disk('public')->delete($customer->photo);
            }
        }
    
        // Update customer data
        $customer->update($validatedData);
    
        // Prepare the photo URL for the response
        $photoUrl = $customer->photo ? asset('storage/' . $customer->photo) : null;
    
        // Return a success response
        return response()->json([
            'message' => 'Customer profile updated successfully.',
            'customer' => [
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'address' => $customer->address,
                'photo' => $photoUrl // Return the photo as a full URL
            ]
        ], 200);
    }
    
    
    
   
    public function destroy(string $id)
    {
        $customerId = Auth::guard('customer')->id(); 
        
        $customer = Customers::find($customerId); 
    
        if (!$customer) {
            
            return response()->json([
                'message' => 'Customer not found.'
            ], 404);
        }
    
        $customer->delete(); 
    
        return response()->json([
            'message' => 'Customer profile deleted successfully.'
        ], 200); 
    }
    
}
