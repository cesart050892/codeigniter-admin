<?php

namespace App\Controllers\Web;

use App\Controllers\Base;

class Sales extends Base
{
    public function index()
    {
        return view('app/sections/admin/sales');
    }
}
