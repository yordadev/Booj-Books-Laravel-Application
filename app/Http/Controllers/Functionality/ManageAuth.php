<?php

namespace App\Http\Controllers\Functionality;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ManageAuth extends Controller
{
    /**
     * * processLogout(Request $request)
     * 
     *  This method logs out an authenticated user.
     * 
     * @param Request $request
     * 
     * @return Route get.login
     */
    public function processLogout(Request $request)
    {
        Auth::logout();

        return redirect()->route('get.login');
    }


    /**
     * * processRegisteration(Request $request)
     * 
     *  Registers a new user
     * 
     * @param Request $request
     * 
     * @return Route home
     */
    public function processRegisteration(Request $request)
    {
        $request->validate([
            'name'             => 'required|string',
            'email'            => 'required|email|unique:users',
            'password'         => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        $user = $this->createUser($request);
        Auth::login($user, true);

        return redirect()->route('home');
    }


    /**
     * * createUser(Request $request)
     * 
     *  Creates a new user record in the db and returns it
     * 
     * @param Request $request
     * 
     * @return User $user
     */
    private function createUser(Request $request)
    {
        return User::create([
            'name' => ucfirst(strtolower($request->name)),
            'email' => strtolower($request->email),
            'password' => bcrypt($request->password),
        ]);
    }


    /**
     * * processLogin(Request $request)
     * 
     *  This method logs out an authenticated user.
     * 
     * @param Request $request
     * 
     * @return Route home
     */
    public function processLogin(Request $request)
    {
        $request->validate([
            'email'      => 'required|email',
            'password'   => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('home');
        }
        return redirect()->route('get.login')->withErrors(['Uh oh, something went wrong. Please try again.']);
    }
}
