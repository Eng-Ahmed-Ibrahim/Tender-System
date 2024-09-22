<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NormalAds;
use Modules\House\Models\HouseFeature;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Modules\House\Models\House;

class PropertySeeder extends Seeder
{
    public function run()
    {
     


        $ad = NormalAds::create([
            'title' => 'Sample Ad Title',
            'country_id' => 64, // Replace with a valid country ID
            'cat_id' => 5,
            'address' => '123 Sample Address',
            'description' => 'This is a description for the sample ad.',
            'price' => 100.00,
            'is_active' => true,
            'photo' => 'photos/p4.jpg', // Assume you have a sample image in storage
        ]);

      

      
        $images = [
            'images/p2.jpg',  // Real image path
            'images/p3.jpg',  // Real image path
        ];

        foreach ($images as $imagePath) {
            $ad->images()->create([
                'image_path' => $imagePath,
            ]);
        }
        
        

        $house = House::create([
            'normal_id' => $ad->id,
            'room_no' => 3,
            'area' => '120 sqm',
            'location' => 'Sample Location',
            'view' => 'Sea View',
            'building_no' => 'B12',
            'history' => 'Newly renovated',
        ]);

        $features = [1, 2]; 
        $house->features()->sync($features);    
        
    }
}
