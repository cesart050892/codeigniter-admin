<?php

namespace App\Controllers\Web;

use App\Controllers\Base;

class Users extends Base
{
    public function index()
    {
        return view('app/sections/admin/users');
    }

    public function profile()
    {
        return view('app/sections/admin/profile');
    }
}
