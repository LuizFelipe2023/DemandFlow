<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
        $adminType = UserType::where('name', 'admin')->first();
        $devType   = UserType::where('name', 'developer')->first();
        $userType  = UserType::where('name', 'user')->first();

        User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'), 
                'email_verified_at' => now(),
                'user_type_id' => $adminType?->id,
            ]
        );

        $users = [
            ['name' => 'João Silva', 'email' => 'joao@empresa.com'],
            ['name' => 'Maria Oliveira', 'email' => 'maria@empresa.com'],
            ['name' => 'Carlos Souza', 'email' => 'carlos@empresa.com'],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'user_type_id' => $devType?->id,
                ]
            );
        }
        
        $allTypeIds = UserType::pluck('id')->toArray();

        User::factory(10)->create([
            'user_type_id' => fn () => fake()->randomElement($allTypeIds),
        ]);
    }
}