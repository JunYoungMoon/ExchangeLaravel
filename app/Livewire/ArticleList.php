<?php

namespace App\Livewire;

use App\Services\ArticlesService;
use Livewire\Component;

class ArticleList extends Component
{
    public $page = 1;
    public $perPage = 2;
    public $articles;
    public $total;
    protected $articlesService;

    public function boot(ArticlesService $articlesService){
        $this->articlesService = $articlesService;
    }

    public function mount()
    {
        $this->fetchArticles();
    }

    public function fetchArticles()
    {
//        $this->articlesService = app(ArticlesService::class);
        $this->articles = $this->articlesService->getArticles($this->page, $this->perPage);
        $this->total = $this->articlesService->getArticlesTotalCount();
    }

    public function gotoPage($page)
    {
        $this->page = $page;
        $this->fetchArticles();
    }

    public function render()
    {
        return view('livewire.article-list');
    }
}
