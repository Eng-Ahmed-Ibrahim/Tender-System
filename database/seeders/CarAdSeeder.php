<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Car\Models\Cars;
use App\Models\NormalAds;



class CarAdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
        public function run()
    {
        $ad = NormalAds::create([
            'title' => 'Car Ad',
            'country_id' => 64, 
            'cat_id' => 4, 
            'address' => '123 Car Street',
            'description' => 'This is a sample description for a car ad.',
            'price' => 10000.00,
            'is_active' => true,
        ]);

        $photoPath = 'photos/1.jpg';
        $ad->photo = $photoPath;
        $ad->save();

        $images = [
            'images/1.jpg',
            'images/2.jpg',
        ];

        foreach ($images as $imagePath) {
            $ad->images()->create([
                'image_path' => $imagePath,
            ]);
        }

        $car = Cars::create([
            'color' => 'Red',
            'year' => 2020,
            'kilo_meters' => 5000,
            'fuel_type' => 'Gasoline',
            'brand_id' => 1,
            'normal_id' => $ad->id,
        ]);

        $features = [1, 2, 3]; 
        $car->features()->sync($features);
    
    }
}
