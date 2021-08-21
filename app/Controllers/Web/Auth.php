<?php

namespace App\Controllers\Web;

use App\Controllers\Base;

class Auth extends Base
{
    public function login()
    {
        return view('app/auth/login');
    }

    public function register()
    {
        return view('app/auth/login');
    }
}
