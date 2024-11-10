<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
      
        $user = Auth::user(); // Mendapatkan user yang sedang login
        return view('admin.dashboard', compact('user')); // Kirim variabel ke view
    }
}
