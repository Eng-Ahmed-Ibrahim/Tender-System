<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadServices
{
    public function handleFileUpload(Request $request, array $validatedData)
    {
        if ($request->hasFile('photo')) {
            $validatedData['photo'] = $request->file('photo')->store('photos', 'public');
        }
        
        return $validatedData;
    }

    public function handleImageUploads(Request $request, $model)
    {
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $image) {
                $imagePath = $image->store('normal_ads_images', 'public');
                // Save each image record to the database
                $model->images()->create([
                    'image_path' => $imagePath,
                ]);
            }
        }
    }
}
