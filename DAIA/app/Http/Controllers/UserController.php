<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use LengthException;

use function Laravel\Prompts\search;

class UserController extends Controller
{
    /**
     * Display the User.
     */
    public function index(): View
    {
        if(Auth::user()->role === 'admin') {
            $users = User::all();
            return view('users.index', compact('users'));
        } else {
            return view('users.index', ['user' => Auth::user()]);
        }
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
        $fileName = Auth::user()->user_name . '.png';
        $user->address = $request->string('address');
        $user->first_name = $request->string('first_name');
        $user->last_name = $request->string('last_name');

        if ($request->file('avatar')) {
            $request->file('avatar')->storeAs('avatars', $fileName);
            $user->user_avatar = 'storage/avatars/' . $fileName;
        }
        $user->telephone = $request->integer('telephone');
        $user->save();
        // Si no se regenera la sesión no se puede ver el cambio de foto:
        session()->regenerate();

         if(Auth::user()->role === 'admin'){
            $users = User::all();
            return view('users.index', compact('users'));
        }
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

        // dd($request); // Traza
        $fileName = $request->user()->user_name . '.png';
        $user->address = $request->get('address');
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        // dd($request->file('avatar') ? '1' : '0'); // Trace
        if ($request->file('avatar')) {
            $request->file('avatar')->storeAs('avatars', $fileName);
            $user->user_avatar = 'storage/avatars/' . $fileName;
        }

        if(Auth::user()->role === 'admin' && $request->get('')) {
            $role = $request->get('user_name'. '_' . $user->role);


        }
        $user->telephone = $request->integer('telephone');
        $user->save();
        session()->regenerate();

        if(Auth::user()->role === 'admin'){
            $users = User::all();
            return view('users.index', compact('users'));
        }

        return view('users.index', compact('user'));
    }

    /**
     * Remove the User from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        session()->invalidate();
        session()->regenerateToken();
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

        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('logout');
    }
}
