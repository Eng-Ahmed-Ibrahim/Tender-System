<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('configurations')->insert([
            [
                'whatsApp' => 1234567890,
                'phone_number' => 9876543210,
                'title' => 'My Website',
                'email' => 'owner@example.com',
                'owner_name' => 'John Doe',
                'logo' => 'path/to/logo.png',
                'terms_condition_en' => 'English Terms and Conditions...',
                'terms_condition_ar' => 'Arabic Terms and Conditions...',
                'refund_policy_en' => 'English Refund Policy...',
                'refund_policy_ar' => 'Arabic Refund Policy...',
                'privacy_policy_en' => 'English Privacy Policy...',
                'privacy_policy_ar' => 'Arabic Privacy Policy...',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more entries here if needed
        ]);
    
    }
}
