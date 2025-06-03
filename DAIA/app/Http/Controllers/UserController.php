<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display the User.
     */
    public function index(): View
    {
        return view('users.index', ['user' => Auth::user()]);
    }

    /**
     * Show the form for creating a new User.
     */
    public function create()
    {
        $users = User::all();
        return view('users.add', compact('users'));
    }

    /**
     * Store a newly created User in storage.
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->prod_name = $request->get('prod_name');
        $user->slug = Str::slug($user->prod_name);
        $user->prod_desc = $request->get('prod_desc');
        $user->prod_stock = $request->get('prod_stock');
        $user->prod_price = $request->get('prod_price');
        $user->save();

        return view('users.all', compact('$user'));
    }

    /**
     * Display the User.
     */
    public function show(User $user)
    {
        User::findOrFail($user->id);
        return view('users.show', compact($user));
    }

    /**
     * Show the form for editing the User.
     */
    public function edit(User $user)
    {
        $users = User::All();
        return view('users.edit', compact('user', 'users'));
    }

    /**
     * Update the User in storage.
     */
    public function update(Request $request, User $user)
    {
        $user->prod_name = $request->get('prod_name');
        $user->slug = Str::slug($user->prod_name);
        $user->prod_desc = $request->get('prod_desc');
        $user->prod_stock = $request->get('prod_stock');
        $user->prod_price = $request->get('prod_price');
        $user->save();

        return view('users.all', compact('$user'));
    }

    /**
     * Remove the User from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('logout');
    }


    /**
     * Inhabilitates the User from storage.
     */
    public function inhabilitate(User $user)
    {
        $user = User::findOrFail($user->id);
        $user->user_active = false;
        $user->email = now() . $user->email;
        $user->save();

        return redirect()->route('logout');
    }
}
