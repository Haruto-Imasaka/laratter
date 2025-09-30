<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    public function index()
    {
        $blockedUsers = auth()->user()->blocks;
        return view('blocks.index', compact('blockedUsers'));
    }

    public function store(User $user)
    {
        if (!auth()->user()->blocks->contains($user->id)) {
            auth()->user()->blocks()->attach($user->id);
        }
        return back();
    }

    public function destroy(User $user)
    {
        auth()->user()->blocks()->detach($user->id);
        return back();
    }
}
