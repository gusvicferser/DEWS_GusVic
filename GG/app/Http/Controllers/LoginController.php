<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class LoginController extends Controller
{

    public function signupForm(): View
    {
        return view('auth.signup');
    }

    public function signup(SignupRequest $request): RedirectResponse
    {
        // Traza:
        // dd($request->all());

        $user = new User();
        $user->username = $request->get('username');
        $user->slug = Str::slug($user->username);
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->birthday = $request->get('birthday');
        $user->password = Hash::make($request->get('password'));
        $user->save();

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('user.index');
    }

    public function loginForm()
    {
        if(Auth::viaRemember()) {
            return 'Bienvenid@ de nuevo';
        } else if (Auth::check()) {
            return redirect()->route('user.index');
        } else {
            return view('auth.login');
        }
    }

    public function login(Request $request)
    {
        // Traza:
        // dd($request->all());

        $credentials = $request->only('username', 'password');
        $rememberLogin = ($request->get('remember')) ? true : false;

        if (Auth::guard('web')->attempt($credentials, $rememberLogin)) {
            $request->session()->regenerate();
            return redirect()->route('user.index');
        } else {
            $error= 'Error de acceso';
            return view('auth.login', compact('error'));
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('index');
    }
}
