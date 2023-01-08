<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Faker\Provider\Uuid;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::factory()->create([
            'id' => Uuid::uuid(),
            'name' => 'Administrator',
            'email' => 'admin@rezahartono.my.id',
            'password' => Hash::make('admin'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'status' => 'active',
        ]);

        Role::insert([
            'id' => Uuid::uuid(),
            'name' => 'Super Admin',
            'description' => 'This is a super admin role for handle all moddule, etc.',
            'access_type' => 'all',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Role::insert([
            'id' => Uuid::uuid(),
            'name' => 'Admin',
            'description' => 'This is a admin role for handle all moddule, etc. with min settings',
            'access_type' => 'custom',
            'access' => json_encode([]),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
