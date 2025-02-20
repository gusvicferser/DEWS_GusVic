<?php

namespace App\Http\Controllers;
use App\Models\User;
// use App\Rules\ValidEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

// use Illuminate\Support\Facades\Hash;
// use Illuminate\View\View;

class UserController extends Controller
{

    /**
     * Display the specified resource.
     */
    public function index(): View
    {
        return view('user.index', ['user' => Auth::user()]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        User::findOrFail($user->id)->delete();

        Auth::guard('web')->logout();
        $user->session()->invalidate();
        $user->session()->regenerateToken();

        return redirect()->route('index');
    }
}
