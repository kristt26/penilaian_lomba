<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index()
    {
        if(session()->get('isRole')){
            return view('home');
        }
        return redirect()->to(base_url('auth'));
    }
}
