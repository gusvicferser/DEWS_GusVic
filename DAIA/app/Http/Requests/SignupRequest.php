<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class SignupRequest extends FormRequest
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
            'user_name' => ['required', 'string', 'min:5', 'max:30', 'unique:users'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'birthday' => ['required', 'date', 'before:today'],
            'password' => ['required', 'confirmed', Password::defaults()]
        ];
    }

    public function messages()
    {
        return [
            'user_name.required' => 'El nombre de usuario es obligatorio',
            'user_name.min' => 'El nombre de usuario ha de tener, como mínimo, 5 caracteres',
            'user_name.max' => 'El nombre de usuario ha de tener, como máximo, 30 caracteres',
            'user_name.unique' => 'Este nombre de usuario no puede asignarse',
            'email.required' => 'El email es obligatorio',
            'email.unique' => 'El email ya existe',
            'email.min' => 'El email ha de tener, como mínimo, 10 caracteres',
            'email.max' => 'El email ha de tener, como máximo, 255 caracteres',
            'password.required' => 'El campo password es obligatorio',
            'password.confirmed' => 'Las contraseñas han de coincidir',
            'password.min' => 'Su contraseña ha de tener, como mínimo, 8 caracteres',
            'password.character' => 'Su contraseña ha de incluir al menos un caracter especial(~, @, #, _, ^, *, %, /, , +, :, ;, =)'
        ];
    }
}
