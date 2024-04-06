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

    public function __construct()
    {
        // ArticlesService를 생성자에서 주입
        $this->articlesService = app(ArticlesService::class);
    }

    public function mount()
    {
        $this->fetchArticles();
    }

    public function fetchArticles()
    {
        $this->articles = $this->articlesService->getArticles($this->page, $this->perPage);
    }

    public function previousPage()
    {
        if ($this->page > 1) {
            $this->page--;
            $this->fetchArticles();
        }
    }

    public function nextPage()
    {
        $totalCount = $this->articlesService->getArticlesTotalCount();
        $totalPage = ceil($totalCount / $this->perPage);

        if ($this->page < $totalPage) {
            $this->page++;
            $this->fetchArticles();
        }
    }

    public function gotoPage($page)
    {
        $this->page = $page;
        $this->fetchArticles();
    }

    public function render()
    {
        return view('livewire.article-list', [
            'pagination' => $this->generatePagination(),
        ]);
    }

    public function generatePagination()
    {
        $totalCount = $this->articlesService->getArticlesTotalCount();
        $totalPage = ceil($totalCount / $this->perPage);

        return [
            'previous' => $this->page > 1,
            'next' => $this->page < $totalPage,
            'pages' => range(1, $totalPage),
        ];
    }
}
