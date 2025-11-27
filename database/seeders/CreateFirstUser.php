<?php
namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateFirstUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat akun admin pertama
        User::create([
            'name'     => 'Admin',
            'email'    => 'bianca24si@mahasiswa.pcr.ac.id',
            'password' => Hash::make('bianca'),
        ]);

        // Seeder data dummy sebanyak 100 user
        $faker = Faker::create();

        for ($i = 0; $i < 100; $i++) {
            User::create([
                'name'              => $faker->name(),
                'email'             => $faker->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password'          => Hash::make('password123'),
                'remember_token'    => Str::random(10),
            ]);
        }
    }
}
