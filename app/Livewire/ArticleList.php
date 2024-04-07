<?php

namespace App\Livewire;

use App\Services\ArticlesService;
use Livewire\Component;

class ArticleList extends Component
{
    public $page = 1;
    public $perPage = 2;
    public $articles;
    protected $articlesService;

    public function mount()
    {
        $this->fetchArticles();
    }

    public function fetchArticles()
    {
        $this->articlesService = app(ArticlesService::class);
        $this->articles = $this->articlesService->getArticles($this->page, $this->perPage);
    }

    public function gotoPage($page)
    {
        $this->page = $page;
        $this->fetchArticles();
    }

    public function render()
    {
        $totalCount = $this->articlesService->getArticlesTotalCount();

        return view('livewire.article-list', [
            'pagination' => compact('totalCount')
        ]);
    }
}
