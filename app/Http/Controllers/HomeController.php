<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Contracts\Support\Renderable;
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
     * @return Renderable
     */
    public function index(): Renderable
    {
        return view('web.backend.sections.home');
    }

    public function root()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return redirect()->route('login');
    }
}
