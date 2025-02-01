<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;


class FaqController extends Controller
{
    public function index(Request $request)
    {
        $query = Faq::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('question', 'like', "%{$search}%")
                ->orWhere('answer', 'like', "%{$search}%");
        }

        $faqs = $query->paginate(20);

        return view('faqs.index', compact('faqs'));
    }
}
