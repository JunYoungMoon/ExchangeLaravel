<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;

class RegisterViewController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register/register');
    }
}
