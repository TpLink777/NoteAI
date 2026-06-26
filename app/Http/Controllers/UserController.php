<?php

namespace App\Http\Controllers;

use App\Services\UserServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    private $user;

    public function __construct(UserServices $user)
    {
        $this->user = $user;
    }


    public function index()
    {
        try {
            $users = $this->user->getAllUsers();
            return view('pages.dashboard.pages.user.index', compact('users'));
        } catch (\Exception $e) {
            Log::error('Error al obtener los usuarios ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un problema interno en el servidor. Inténtalo más tarde.');
        }
    }

    public function deleteUser($id)
    {
        try {
            $user = $this->user->getUserById($id);

            if (!$user) {
                return redirect()->route('usersPage')->with('error', 'El usuario solicitado no existe en el sistema');
            }

            if ($user->id == auth()->id()) {
                return redirect()->route('usersPage')->with('error', 'No puedes eliminar tu propia cuenta');
            }

            $this->user->deleteUser($user);
            return redirect()->route('usersPage')->with('success', 'Usuario eliminado correctamente');
        } catch (\Exception $e) {
            Log::error('Error al eliminar usuario' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un problema interno en el servidor. Inténtalo más tarde.');
        }
    }
    public function editPage($id)
    {
        try {
            $user = $this->user->getUserById($id);

            if (!$user) {
                return redirect()->route('usersPage')->with('error', 'El usuario solicitado no existe en el sistema');
            }

            return view('pages.dashboard.pages.user.edit', compact('user'));
        } catch (\Exception $e) {
            Log::error('Error al obtener usuario para editar: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un problema interno en el servidor. Inténtalo más tarde.');
        }
    }

    public function updateUser(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $user = $this->user->getUserById($id);

            if (!$user) {
                return redirect()->route('usersPage')->with('error', 'El usuario solicitado no existe en el sistema');
            }

            $this->user->updateUser($id, $validated);
            return redirect()->route('usersPage')->with('success', 'Usuario actualizado correctamente');
        } catch (\Exception $e) {
            Log::error('Error al actualizar usuario: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un problema interno en el servidor. Inténtalo más tarde.');
        }
    }

}
