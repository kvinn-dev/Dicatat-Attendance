<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    public function system_setting()
    {
        return view('settings.system_setting');
    }
    
    public function notification()
    {
        return view('settings.notification');
    }
}
