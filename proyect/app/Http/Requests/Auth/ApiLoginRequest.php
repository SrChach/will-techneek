<?php

namespace App\Http\Requests\Auth;

use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     type="object",
 *     title="Login Request",
 *     @OA\Property(
 *         property="email",
 *         description="Correo del usuario",
 *         type="string",
 *     ),
 *     @OA\Property(
 *         property="password",
 *         description="password del usuario",
 *         type="string"
 *     ),
 *     @OA\Xml(
 *         name="ApiLoginRequest"
 *     )
 * )
 */
class ApiLoginRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }
}
