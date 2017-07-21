<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Common\BaseController;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view($this->theme.'.home');
    }
}
