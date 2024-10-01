<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $permissions = [
            // Group name: users
            ['name' => 'users.create', 'guard_name' => 'web', 'group_name' => 'users'],
            ['name' => 'users.view', 'guard_name' => 'web', 'group_name' => 'users'],
            ['name' => 'users.edit', 'guard_name' => 'web', 'group_name' => 'users'],
            ['name' => 'users.delete', 'guard_name' => 'web', 'group_name' => 'users'],

            // Group name: customers
            ['name' => 'customers.create', 'guard_name' => 'web', 'group_name' => 'customers'],
            ['name' => 'customers.view', 'guard_name' => 'web', 'group_name' => 'customers'],
            ['name' => 'customers.edit', 'guard_name' => 'web', 'group_name' => 'customers'],
            ['name' => 'customers.delete', 'guard_name' => 'web', 'group_name' => 'customers'],

            // Group name: normalads
            ['name' => 'normalads.create', 'guard_name' => 'web', 'group_name' => 'normalads'],
            ['name' => 'normalads.view', 'guard_name' => 'web', 'group_name' => 'normalads'],
            ['name' => 'normalads.edit', 'guard_name' => 'web', 'group_name' => 'normalads'],
            ['name' => 'normalads.delete', 'guard_name' => 'web', 'group_name' => 'normalads'],

            // Group name: commercialads
            ['name' => 'commercialads.create', 'guard_name' => 'web', 'group_name' => 'commercialads'],
            ['name' => 'commercialads.view', 'guard_name' => 'web', 'group_name' => 'commercialads'],
            ['name' => 'commercialads.edit', 'guard_name' => 'web', 'group_name' => 'commercialads'],
            ['name' => 'commercialads.delete', 'guard_name' => 'web', 'group_name' => 'commercialads'],

            //banners
            ['name' => 'banners.create', 'guard_name' => 'web', 'group_name' => 'banners'],
            ['name' => 'banners.view', 'guard_name' => 'web', 'group_name' => 'banners'],
            ['name' => 'banners.edit', 'guard_name' => 'web', 'group_name' => 'banners'],
            ['name' => 'banners.delete', 'guard_name' => 'web', 'group_name' => 'banners'],

            //popup
            ['name' => 'popup.create', 'guard_name' => 'web', 'group_name' => 'popup'],
            ['name' => 'popup.view', 'guard_name' => 'web', 'group_name' => 'popup'],
            ['name' => 'popup.edit', 'guard_name' => 'web', 'group_name' => 'popup'],
            ['name' => 'popup.delete', 'guard_name' => 'web', 'group_name' => 'popup'],

            // Group name: modules
            ['name' => 'modules.create', 'guard_name' => 'web', 'group_name' => 'modules'],
            ['name' => 'modules.view', 'guard_name' => 'web', 'group_name' => 'modules'],
            ['name' => 'modules.edit', 'guard_name' => 'web', 'group_name' => 'modules'],
            ['name' => 'modules.delete', 'guard_name' => 'web', 'group_name' => 'modules'],

            // Group name: configuration
            ['name' => 'configuration.create', 'guard_name' => 'web', 'group_name' => 'configuration'],
            ['name' => 'configuration.view', 'guard_name' => 'web', 'group_name' => 'configuration'],
            ['name' => 'configuration.edit', 'guard_name' => 'web', 'group_name' => 'configuration'],
            ['name' => 'configuration.delete', 'guard_name' => 'web', 'group_name' => 'configuration'],

            // Group name: roles
            ['name' => 'roles.create', 'guard_name' => 'web', 'group_name' => 'roles'],
            ['name' => 'roles.view', 'guard_name' => 'web', 'group_name' => 'roles'],
            ['name' => 'roles.edit', 'guard_name' => 'web', 'group_name' => 'roles'],
            ['name' => 'roles.delete', 'guard_name' => 'web', 'group_name' => 'roles'],

            // Group name: subscriptions
            ['name' => 'subscriptions.create', 'guard_name' => 'web', 'group_name' => 'subscriptions'],
            ['name' => 'subscriptions.view', 'guard_name' => 'web', 'group_name' => 'subscriptions'],
            ['name' => 'subscriptions.edit', 'guard_name' => 'web', 'group_name' => 'subscriptions'],
            ['name' => 'subscriptions.delete', 'guard_name' => 'web', 'group_name' => 'subscriptions'],

            // Group name: country
            ['name' => 'country.create', 'guard_name' => 'web', 'group_name' => 'country'],
            ['name' => 'country.view', 'guard_name' => 'web', 'group_name' => 'country'],
            ['name' => 'country.edit', 'guard_name' => 'web', 'group_name' => 'country'],
            ['name' => 'country.delete', 'guard_name' => 'web', 'group_name' => 'country'],

            // Group name: currency
            ['name' => 'currency.create', 'guard_name' => 'web', 'group_name' => 'currency'],
            ['name' => 'currency.view', 'guard_name' => 'web', 'group_name' => 'currency'],
            ['name' => 'currency.edit', 'guard_name' => 'web', 'group_name' => 'currency'],
            ['name' => 'currency.delete', 'guard_name' => 'web', 'group_name' => 'currency'],

            // Group name: language
            ['name' => 'language.create', 'guard_name' => 'web', 'group_name' => 'language'],
            ['name' => 'language.view', 'guard_name' => 'web', 'group_name' => 'language'],
            ['name' => 'language.edit', 'guard_name' => 'web', 'group_name' => 'language'],
            ['name' => 'language.delete', 'guard_name' => 'web', 'group_name' => 'language'],

            // Group name: categories
            ['name' => 'categories.create', 'guard_name' => 'web', 'group_name' => 'categories'],
            ['name' => 'categories.view', 'guard_name' => 'web', 'group_name' => 'categories'],
            ['name' => 'categories.edit', 'guard_name' => 'web', 'group_name' => 'categories'],
            ['name' => 'categories.delete', 'guard_name' => 'web', 'group_name' => 'categories'],

            // Group name: bills
            ['name' => 'bills.create', 'guard_name' => 'web', 'group_name' => 'bills'],
            ['name' => 'bills.view', 'guard_name' => 'web', 'group_name' => 'bills'],
            ['name' => 'bills.edit', 'guard_name' => 'web', 'group_name' => 'bills'],
            ['name' => 'bills.delete', 'guard_name' => 'web', 'group_name' => 'bills'],
        ];

        DB::table('permissions')->insert($permissions);
    }
}
