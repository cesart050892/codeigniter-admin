<?php

namespace App\Controllers\Web;

use App\Controllers\Base;

class Reports extends Base
{
    public function index()
    {
        return view('app/sections/admin/reports');
    }
}
