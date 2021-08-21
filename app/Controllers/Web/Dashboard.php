<?php

namespace App\Controllers\Web;

use App\Controllers\Base;

class Dashboard extends Base
{
    public function index()
    {
        return view('app/sections/dashboard');
    }
}
