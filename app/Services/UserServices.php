<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserServices
{

    public function getAllUsers()
    {
        return User::query()->paginate(10);
    }

    public function getUserById($id)
    {
        return User::find($id);
    }


    public function deleteUser(User $user)
    {
        return $user->delete();
    }

    public function updateUser($id, array $data)
    {
        $user = $this->getUserById($id);
        $user->update([
            'name' => $data['name'],
            'updated_at' => now()
        ]);
        return $user;
    }

    public function createUser(array $data)
    {
        return  User::create([
            "name" => $data['name'],
            "email" => $data['email'],
            "password" => $data['password'],
            'email_verified_at' => now(),
        ])->assignRole('user');
    }

    //! funcion para actualizar la contraseña del usuario por su email
    public function updatePassword(string $email, string $newPassword): bool
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return false;
        }

        $user->update([
            'password' => Hash::make($newPassword),
            'updated_at' => now(),
        ]);

        return true;
    }
}
