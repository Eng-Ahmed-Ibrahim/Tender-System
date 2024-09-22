<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NormalAds;
use Modules\Bike\Models\Bike;

class BikeAdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
 public function run()
    {
        // Step 1: Create a sample NormalAd for a bike
        $ad = NormalAds::create([
            'title' => 'Dinasor motor',
            'country_id' => 64, // Assuming you have a country with ID 1
            'cat_id' => 10, // Assuming category ID 2 exists for bikes
            'address' => 'Riyadh, Saudi Arabia',
            'description' => 'A well-maintained Yamaha FZ bike, 2019 model with low mileage.',
            'price' => 1500.00,
            'is_active' => true,
        ]);

        // Step 2: Handle the main photo (make sure the photo exists in public/storage/photos)
        $photoPath = 'photos/images.jpeg'; // The real path to your bike's main photo
        $ad->photo = $photoPath;
        $ad->save();

        // Step 3: Handle additional images (stored in public/storage/images)
        $images = [
            'images/bike2.jpeg',  // Real image path
            'images/bike3.jpeg',  // Real image path
        ];

        foreach ($images as $imagePath) {
            $ad->images()->create([
                'image_path' => $imagePath,
            ]);
        }

        // Step 4: Create and associate the Bike details
        $bike = Bike::create([
            'model' => 'FZ',
            'year' => 2019,
            'kilo_meters' => 12000,
            'normal_id' => $ad->id,  // Associate this bike with the created ad
        ]);

        // Step 5: Attach bike features (assuming feature IDs 1, 2, 3 exist)
        $features = [1, 2, 3]; // Replace with actual feature IDs for the bike
        $bike->features()->sync($features);
    }
}
