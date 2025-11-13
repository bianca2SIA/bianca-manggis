<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateFirstUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data['name']     = 'Admin';
        $data['email']    = 'bianca24si@mahasiswa.pcr.ac.id';
        $data['password'] = Hash::make('bianca');
        User::create($data);
    }
}
