<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Option;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function test()
    {
        return view('test');
    }

    public function welcome()
    {
        //TODO: based on theme selected, return correct blade file, for now just return welcome 
        // 1. `welcome` is default
        // 2. default 
        $page = Post::where('status', PUBLISHED)->where('post_type', PAGE)->orderBy('menu_order', 'asc')->first();
        return view('templates.resume.index')->with([
            'page' => isset($page) ? $page : null, //default first page will be shown
        ]);
    }
}
