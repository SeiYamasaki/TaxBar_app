<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function show()
    {
        return view('themes.theme'); // ここで正しいBladeを返す
    }
}
