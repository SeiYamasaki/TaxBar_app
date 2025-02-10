<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    // 動画一覧表示
    public function index()
    {
        return view('videos.index');
    }

    // 動画投稿フォーム
    public function create()
    {
        return view('videos.create');
    }
}
