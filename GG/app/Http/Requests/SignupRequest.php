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
            'username' => ['required', 'string', 'min:5', 'max:30', 'unique:users'],
            'name' => ['required', 'string', 'min:5', 'max:255'],
            'email' => ['required', 'string', 'email' , 'unique:users'],
            'birthday' => ['required', 'date', 'before:today'],
            'password' => ['required', 'confirmed', Password::defaults()]
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'El nombre de usuario es obligatorio',
            'username.min' => 'El nombre de usuario ha de tener, como mínimo, 5 caracteres',
            'username.max' => 'El nombre de usuario ha de tener, como máximo, 30 caracteres',
            'username.unique' => 'El nombre de usuario ya existe',
            'name.required' => 'Ha de introducir un nombre completo',
            'name.min' => 'El nombre completo ha de tener como mínimo 5 caracteres',
            'name.max' => 'El nombre completo ha de tener como máximo 255 caracteres',
            'email.required' => 'El email es obligatorio',
            'email.unique' => 'El email ya existe',
            'email.min' => 'El email ha de tener, como mínimo, 10 caracteres',
            'email.max' => 'El email ha de tener, como máximo, 255 caracteres',
            'password.required' => 'El campo password es obligatorio',
            'password.confirmed' => 'Las contraseñas han de coincidir',
            'password.min' => 'Su contraseña ha de tener, como mínimo, 8 caracteres'
        ];
    }
}
