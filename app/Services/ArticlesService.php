<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Facades\Gate;

class ArticlesService
{
    public function getArticles($page = 1, $perPage = 10)
    {
        $offset = ($page - 1) * $perPage;

        $articles = Article::with(['user' => function ($query) {
            $query->select('id', 'name');
        }])
            ->select('id', 'body', 'user_id', 'created_at')
            ->latest()
            ->skip($offset)
            ->take($perPage)
            ->get();

        foreach ($articles as $article) {
            $article->can_update = Gate::allows('update', $article);
        }

        return $articles;
    }

    public function getArticlesTotalCount(){
        return Article::count();
    }
}
