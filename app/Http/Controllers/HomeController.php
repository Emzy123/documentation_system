<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role->slug === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role->slug === 'staff') {
            return redirect()->route('staff.dashboard');
        } elseif ($user->role->slug === 'student') {
            return redirect()->route('student.dashboard');
        }

        return view('home');
    }
}
