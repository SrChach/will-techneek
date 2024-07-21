<?php

namespace App\Http\Controllers\Auth;

use App\Application\User as ApplicationUser;
use App\Exceptions\UserException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginRegisterController extends Controller
{
    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     */
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nombre' => 'required|string|max:250',
            'apellidos' => 'sometimes|string|max:250',
            'email' => 'required|string|email:rfc,dns|max:250|unique:users,email',
            'password' => 'required|string|min:8|confirmed'
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);
        }

        $user = ApplicationUser::create($request->nombre, $request->apellidos, $request->email, $request->password);

        $data['token'] = $user->createToken($request->email)->plainTextToken;
        $data['user'] = $user;

        $response = [
            'status' => 'success',
            'message' => 'User is created successfully.',
            'data' => $data,
        ];

        return response()->json($response, 201);
    }

    /**
     * Authenticate the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * @OA\Post(
     *      path="/api/login",
     *      tags={"Auth"},
     *      summary="Login de Usuarios",
     *      description="Devuelve un token a partir de los datos de autenticacion",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/User")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Login Exitoso",
     *          @OA\JsonContent(),
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Credenciales invalidas",
     *          @OA\JsonContent(),
     *      )
     * )
     */
    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);
        }

        $user = ApplicationUser::getAuthenticated($request->email, $request->password);

        $data['token'] = $user->createToken($request->email)->plainTextToken;
        $data['user'] = $user;
        
        $response = [
            'message' => 'User is logged in successfully.',
            'data' => $data,
        ];

        return response()->json($response, 200);
    }

    /**
     * Log out the user from application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'User is logged out successfully'
            ], 200);
    }

}
