<?php

namespace App\Controllers\Web;

use App\Controllers\Base;

class Clients extends Base
{
    public function index()
    {
        return view('app/sections/admin/clients');
    }
}
