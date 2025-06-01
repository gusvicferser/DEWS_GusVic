<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $user->user_name = $request->get('user_name');
        $user->slug = Str::slug($user->user_name);
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->email = $request->get('email');
        $user->birthday = $request->get('birthday');
        $user->address = $request->get('address');
        $user->telephone = $request->get('telephone');
        $user->user_avatar = $request->get('user_avatar');
        if ($request->get('role') !== null) {
            $user->role = $request->get('role');
        }
        $user->password = Hash::make($request->get('password'));
        $user->save();

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('user.index');
    }

    public function loginForm(): View
    {
        if (Auth::viaRemember()) {
            return view('user.index');
        } else if (Auth::check()) {
            return view('user.index');
        } else {
            return view('auth.login');
        }

        return view('index');
    }

    public function login(Request $request)
    {
        // Traza:
        // dd($request->all());

        // Obtiene el estado del usuario antes de autentificarlo:
        $user = DB::table('users')->where('user_name', $request->get('user_name'))->first();

        // Traza:
        // dd($user->user_active);

        $credentials = $request->only('user_name', 'password');
        $rememberLogin = ($request->get('remember')) ? true : false;

        if ($user->user_active) {
            if (Auth::guard('web')->attempt($credentials, $rememberLogin)) {
                $request->session()->regenerate();
                return redirect()->route('index');
            } else {
                $error = 'Error de acceso';
                return view('auth.login', compact('error'));
            }
        } else {
            $error = 'Error de inicio de sesión';
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
