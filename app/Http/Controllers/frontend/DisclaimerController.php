<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;

class DisclaimerController extends Controller
{
    public function index()
    {
        $view_path = 'frontend.' . get_frontend_settings('theme') . '.disclaimer.index';
        return view($view_path);
    }
}
