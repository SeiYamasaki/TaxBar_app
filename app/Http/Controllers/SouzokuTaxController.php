<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SouzokuTaxController extends Controller
{
    public function index()
    {
        return view('souzoku-tax');
    }
}
