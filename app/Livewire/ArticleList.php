<?php

namespace App\Livewire;

use App\Models\Article;
use Livewire\Component;
use Livewire\WithPagination;

class ArticleList extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'id';
    public $sortAsc = true;

    protected $queryString = [
        'search' => ['keep' => ''],
        'sortBy' => ['keep' => 'id'],
        'sortAsc' => ['keep' => true]
    ];

//    public $page = 1;
//    public $perPage = 4;
//    public $articles;
//    public $total;
//    protected $articlesService;
//
//    //의존성 주입
//    public function boot(ArticlesService $articlesService)
//    {
//        $this->articlesService = $articlesService;
//    }
//
//    public function mount()
//    {
//        //다른 페이지에서 뒤로가기로 해당 페이지로 접근 했을때는 GET 페이지 파라미터가 있으므로 dispatch 하지 않는다.
//        if (empty($_GET['page'])) {
//            $this->dispatch('clientUrlChanged', $this->page);
//        } else {
//            $this->page = $_GET['page'];
//        }
//
//        $this->fetchArticles();
//    }
//
//    public function fetchArticles()
//    {
//        // 데이터를 불러오기 전에 로딩 표시를 보여준다.
//        $this->dispatch('showLoading');
//
////        $this->articlesService = app(ArticlesService::class);
//
//        $this->articles = Article::with(['user' => function ($query) {
//            $query->select('id', 'name');
//        }])
//            ->select('id', 'body', 'user_id', 'created_at')
//            ->latest()
//            ->paginate($this->perPage);
//
////        $this->articles = $this->articlesService->getArticles($this->page, $this->perPage);
//        $this->total = $this->articlesService->getArticlesTotalCount();
//
//        // 데이터 불러오기가 완료되면 로딩 표시를 숨긴다.
//        $this->dispatch('hideLoading');
//    }
//
//    #[On('serverUrlChanged')]
//    public function serverUrlChanged($page)
//    {
//        $this->page = $page;
//
//        $this->fetchArticles();
//    }
//
//    public function gotoPage($page)
//    {
//        $this->page = $page;
//        $this->fetchArticles();
//
//        // URL 업데이트
//        $this->dispatch('clientUrlChanged', $this->page);
//    }

    public function render()
    {
        // 데이터를 불러오기 전에 로딩 표시를 보여준다.
        $this->dispatch('showLoading');

        $articles = Article::with(['user' => function ($query) {
            $query->select('id', 'name');
        }])
            ->when($this->search, function ($query) {
                return $query->where('body', 'like', '%' . $this->search . '%');
            })
            ->select('id', 'body', 'user_id', 'created_at')
            ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
            ->paginate(2);

        // 데이터 불러오기가 완료되면 로딩 표시를 숨긴다.
        $this->dispatch('hideLoading');

        return view('livewire.article-list', ['articles' => $articles]);
    }

    public function delete($id)
    {
        $article = Article::find($id);

        // If the user doesn't own the post,
        // an AuthorizationException will be thrown...
        $this->authorize('delete', $article);

        $article->delete();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function changeSortBy($field)
    {
        if($field === $this->sortBy){
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortBy = $field;
    }
}
