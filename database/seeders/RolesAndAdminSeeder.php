<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolesAndAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //! creacion de los roles
        $adminRole = Role::create(['name' => 'admin']);

        //! creacion del usuario administrador
        User::create([
            'name' => 'Stiven Gomez Mazo',
            'email' => env('EMAIL_ADMIN'),
            'password' => Hash::make(env('PASSWORD_ADMIN')),
            'email_verified_at' => now()->format('Y-m-d H:i:s'),
        ])->assignRole($adminRole);
    }
}
