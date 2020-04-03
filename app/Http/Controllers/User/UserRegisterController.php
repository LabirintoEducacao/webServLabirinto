<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserRegisterController extends Controller
{

	public function login()
    {
      return view('auth.userLogin');
    }

    public function showRegistrationForm()
    {
      return view('auth.userRegister');
    }

    public function showRegistrationFormId($id)
    {
      return view('cad_sala')->withData($id);
    }
}
