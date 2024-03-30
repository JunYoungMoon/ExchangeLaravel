<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticlesController extends Controller
{
    public function index()
    {
        return view('articles.create');
    }

    public function create(Request $request)
    {
        $input = $request->validate([
            'body' => 'required|string|max:255',
        ]);

        Article::create([
            'body' => $input['body'],
            'user_id' => Auth::id()
//            'user_id' => 1
        ]);

        return 'hello';
    }
}
