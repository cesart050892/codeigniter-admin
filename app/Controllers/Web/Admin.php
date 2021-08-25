<?php

namespace App\Controllers\Web;

use App\Controllers\Base;

class Admin extends Base
{
    public function index()
    {
        return view('app/sections/admin/admin');
    }
}
