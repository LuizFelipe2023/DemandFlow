<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserType;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['admin', 'developer', 'user', 'manager'];

        foreach ($types as $type) {
            UserType::firstOrCreate(['name' => $type]);
        }
    }
}