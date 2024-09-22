<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert parent categories
        $electronicsId = DB::table('categories')->insertGetId([
            'title' => 'Electronics',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $fashionId = DB::table('categories')->insertGetId([
            'title' => 'Fashion',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $homeAppliancesId = DB::table('categories')->insertGetId([
            'title' => 'Home Appliances',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $sportsId = DB::table('categories')->insertGetId([
            'title' => 'Sports & Outdoors',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $booksId = DB::table('categories')->insertGetId([
            'title' => 'Books',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $automotiveId = DB::table('categories')->insertGetId([
            'title' => 'Automotive',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert subcategories for Electronics
        DB::table('categories')->insert([
            [
                'title' => 'Mobile Phones',
                'parent_id' => $electronicsId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Laptops',
                'parent_id' => $electronicsId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Televisions',
                'parent_id' => $electronicsId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Cameras',
                'parent_id' => $electronicsId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Wearable Technology',
                'parent_id' => $electronicsId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Insert subcategories for Fashion
        DB::table('categories')->insert([
            [
                'title' => 'Men\'s Clothing',
                'parent_id' => $fashionId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Women\'s Clothing',
                'parent_id' => $fashionId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Shoes',
                'parent_id' => $fashionId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Accessories',
                'parent_id' => $fashionId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Jewelry',
                'parent_id' => $fashionId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Insert subcategories for Home Appliances
        DB::table('categories')->insert([
            [
                'title' => 'Refrigerators',
                'parent_id' => $homeAppliancesId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Washing Machines',
                'parent_id' => $homeAppliancesId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Kitchen Appliances',
                'parent_id' => $homeAppliancesId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Air Conditioners',
                'parent_id' => $homeAppliancesId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Vacuum Cleaners',
                'parent_id' => $homeAppliancesId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Insert subcategories for Sports & Outdoors
        DB::table('categories')->insert([
            [
                'title' => 'Fitness Equipment',
                'parent_id' => $sportsId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Outdoor Gear',
                'parent_id' => $sportsId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Sports Apparel',
                'parent_id' => $sportsId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Cycling',
                'parent_id' => $sportsId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Camping & Hiking',
                'parent_id' => $sportsId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Insert subcategories for Books
        DB::table('categories')->insert([
            [
                'title' => 'Fiction',
                'parent_id' => $booksId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Non-Fiction',
                'parent_id' => $booksId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Children\'s Books',
                'parent_id' => $booksId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Academic',
                'parent_id' => $booksId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Comics & Graphic Novels',
                'parent_id' => $booksId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Insert subcategories for Automotive
        DB::table('categories')->insert([
            [
                'title' => 'Car Parts & Accessories',
                'parent_id' => $automotiveId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Motorcycle Parts',
                'parent_id' => $automotiveId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Car Care',
                'parent_id' => $automotiveId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Tools & Equipment',
                'parent_id' => $automotiveId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Tires & Wheels',
                'parent_id' => $automotiveId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
