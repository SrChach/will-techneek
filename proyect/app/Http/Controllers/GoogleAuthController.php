<?php

namespace App\Http\Controllers;

use App\Models\EstadosUsuarios;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        //? se obtienen los datos de google del usuario
        $user_google = Socialite::driver('google')->stateless()->user();
        //dd($user_google);

        //? se crea o actualizan los datos del usuario.
        $user = User::where('email', $user_google->email)->first();
        /*$user = User::updateOrCreate([
            'email' => $user_google->email,
        ], [
            'idGoogle' => $user_google->id,
            'foto' => $user_google->user['picture'],
        ]);*/

        if ($user != NULL) {
            $user->idGoogle = $user_google->id;
            $user->save();
        }
        else {
            $user = User::create([
                'idRol' => Roles::ALUMNO,
                'idStatus' => EstadosUsuarios::VERIFICAR_CORREO,
                'nombre' => $user_google->name,
                'apellidos' => "",
                'email' => $user_google->email,
                'password' => Hash::make("sistema2023"),
            ]);
        }

        //! determina si el usuario esta logueado para asi iniciar sesión o no
        if (!Auth::check()) {
            Auth::login($user);
        }

        return redirect()->route('dashboard');
    }
}
