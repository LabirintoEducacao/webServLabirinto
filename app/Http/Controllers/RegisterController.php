<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    protected function create()
    {
        return [
            'name' => 'gabi',
            'email' => "gabi@gabi",
            'login' => 'gabi',
            'password' => Hash::make('gabi'),
        ];
    }
}
