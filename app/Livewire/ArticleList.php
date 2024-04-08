<?php

namespace App\Livewire;

use App\Services\ArticlesService;
use Livewire\Attributes\On;
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

        $this->dispatch('clientUrlChanged', $this->page);
    }

    #[On('serverUrlChanged')]
    public function serverUrlChanged($page){
        $this->page = $page;

        $this->fetchArticles();
    }

    public function fetchArticles()
    {
        // 데이터를 불러오기 전에 로딩 표시를 보여줍니다.
        $this->dispatch('showLoading');

//        $this->articlesService = app(ArticlesService::class);
        $this->articles = $this->articlesService->getArticles($this->page, $this->perPage);
        $this->total = $this->articlesService->getArticlesTotalCount();

        // 데이터 불러오기가 완료되면 로딩 표시를 숨깁니다.
        $this->dispatch('hideLoading');
    }

    public function gotoPage($page)
    {
        $this->page = $page;
        $this->fetchArticles();

        // URL 업데이트
        $this->dispatch('clientUrlChanged', $this->page);
    }

    public function render()
    {
        return view('livewire.article-list');
    }
}
