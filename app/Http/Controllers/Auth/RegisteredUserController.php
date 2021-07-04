<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\Aflee;
use App\Models\Afler;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // $user = User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        // ]);

        if ($request['position'] === "afler") {
            $afler = new  Afler;
            $afler->afler_name = $request['name'];
            $afler->save();

            $aflerId = Afler::latest()->first()->id;
            
            $user =  User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'token' => Str::random(60),
            'role_id' => 4,
            'status' => 1,
            'phone_number' => $request['phone_number'],
            'afler_id' => $aflerId
            ]);
        } else {
            $aflee = new  Aflee;
            $aflee->aflee_name = $request['name'];
            $aflee->save();

            $afleeId = Aflee::latest()->first()->id;
            
            $user =  User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'token' => Str::random(60),
            'role_id' => 5,
            'status' => 1,
            'phone_number' => $request['phone_number'],
            'aflee_id' => $afleeId
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
