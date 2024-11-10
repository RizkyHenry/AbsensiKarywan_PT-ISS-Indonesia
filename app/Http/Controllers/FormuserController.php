<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormuserController extends Controller
{
    
    public function index()
    {
        return view('user.formuser');
    }
}
