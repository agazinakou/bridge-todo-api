<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResumeController extends Controller
{
    public function resume()
    {
        $resume = [
            'all' => Todo::count(),
            'me' => Todo::where('author_id', Auth::user()->id)->count(),
            'todo' => Todo::where('done', false)->where('author_id', Auth::user()->id)->count(),
            'done' => Todo::where('done', true)->where('author_id', Auth::user()->id)->count()
        ];

        return response()->json([
            'status' => 'success',
            'resume' => $resume,
        ]);
    }
}
