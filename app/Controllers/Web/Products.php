<?php

namespace App\Controllers\Web;

use App\Controllers\Base;

class Products extends Base
{
    public function index()
    {
        return view('app/sections/admin/products');
    }
}
