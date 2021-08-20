<?php

namespace App\Controllers\Web;

use App\Controllers\Base;

class Home extends Base
{
    public function index()
    {
        return view('welcome_message');
    }
}
