<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NormalAds;
use Modules\Electronics\Models\Mobiles;


class AdsAndMobilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          $ad = NormalAds::create([
            'title' => 'Sample Ad Title',
            'country_id' => 64, // Replace with a valid country ID
            'cat_id' => 14,
            'address' => '123 Sample Address',
            'description' => 'This is a description for the sample ad.',
            'price' => 100.00,
            'is_active' => true,
            'photo' => 'photos/mobile3.jpg', // Assume you have a sample image in storage
        ]);

        $images = [
            'images/mobile2.jpg',  // Real image path
            'images/mobile3.jpg',  // Real image path
        ];

        foreach ($images as $imagePath) {
            $ad->images()->create([
                'image_path' => $imagePath,
            ]);
        }
        
        
        Mobiles::create([
            'storage' => '128GB',
            'ram' => '8GB',
            'disply_size' => '6.5 inches',
            'sim_no' => 2,
            'status' => 'New',
            'normal_id' => $ad->id,
        ]);
    }
}
