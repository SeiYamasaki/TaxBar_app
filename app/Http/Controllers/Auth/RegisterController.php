<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function showTaxExpertRegister()
    {
        return view('auth.register_tax_expert');
    }

    public function showCompanyRegister()
    {
        return view('auth.register_company');
    }

    public function showIndividualRegister()
    {
        return view('auth.register_individual');
    }
}
