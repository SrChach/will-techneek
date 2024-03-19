<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Mail\RecuperacionPasswordMailer;
use App\Mail\ReuperacionPasswordMailer;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function forgotPassword(Request $request)
    {

        $usuarioFind = User::where('email', $request->email)->first();
        $token = Str::random(64);
        if ($usuarioFind == NULL || $usuarioFind == "") {
            $respuesta['estado'] = false;
            $respuesta['mensaje'] = "Usuario no reconocido";
        } else {
            $user = User::find($usuarioFind->id);
            $user->token = $token;
            $user->save();

            Mail::to($request->email)->send(new RecuperacionPasswordMailer($usuarioFind->id, $token));

            $respuesta['estado'] = true;
            $respuesta['mensaje'] = "Se ha enviado un link de recuperación a tu correo.";
        }

        return response()->json($respuesta);

    }

    public function recuperar($id, $token): View
    {

        return view('auth.cambiarPassword', [
            "id" => $id,
            "token" => $token,
        ]);
    }

    public function cambiarContraseña(Request $request)
    {

        $usuario = User::find($request->idUsuario);
        $usuario->password = Hash::make($request->password);
        $usuario->token = null;
        $usuario->save();

        $respuesta['mensaje'] = "Tu contraseña ha sido actualizada con éxito.";

        return json_encode($respuesta);
    }
}
