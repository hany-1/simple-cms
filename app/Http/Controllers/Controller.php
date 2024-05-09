<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $user = null;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user()) return $next($request);
            $this->user = auth()->user();

            //Set all blade can get user data
            View::share('user', $this->user);
            return $next($request);
        });
    }
}
