<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;

class AuthenticationController extends Controller
{
    /**
     * * renderLogin()
     * 
     * @return View pages.auth.login
     */
    public function renderLogin()
    {
        return view('pages.auth.login');
    }


    /**
     * * renderRegister()
     *  
     * @return View pages.auth.register
     */
    public function renderRegister()
    {
        return view('pages.auth.register');
    }
}
