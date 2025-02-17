<?php

namespace App\Http\Controllers;
use App\Models\User;
// use App\Rules\ValidEmail;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\View\View;

class UserController extends Controller
{

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        User::findOrFail($user->id());
        return view('users.profile');
    }

    // /**
    //  * Update the password (with a little help from GPT:)
    //  */
    // public function changePass(Request $request, User $user) {
    //     $request->validate(
    //         [
    //             'password' => ['required'],
    //             'new_password' => ['required', 'confirmed', 'min:8'],
    //         ]);

    //     if($request->get('password') !== $request->get('new_pass')){
    //         $pass_equals = 'Las contraseñas no coinciden';
    //         return view('users.profile', compact('pass_equals'));
    //     }

    //     if(!Hash::check($request->get('password'), $user->password)) {
    //         $pass_error = 'La contraseña proporcionada no es correcta';
    //         return view('users.profile', compact('pass_error'));
    //     }

    //     $user->password = Hash::make($request->get('password'));
    //     $user->save();
    //     return view('users.profile');
    // }

    // /**
    //  * Update email:
    //  */
    // public function changeEmail(Request $request, User $user): View {
    //     $request->validate(
    //         ['email' => ['required', 'email', 'unique:users,email', new ValidEmail()]]);
    //     $user->email = $request->get('email');
    //     $user->save();
    //     return view('users.profile');
    // }

    // /**
    //  * Update name:
    //  */
    // public function changeName(Request $request, User $user): View
    // {
    //     $user->name = $request->get('name');
    //     $user->save();
    //     return view('users.profile');
    // }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        User::findOrFail($user->id)->delete();
        return redirect()->route('index');
    }
}
