<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlockController extends Controller
{
    public function index()
    {
        // ひとまず空ビューを返すだけ
        return view('blocks.index');
    }
}
