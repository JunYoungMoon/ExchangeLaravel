<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateArticleRequest;
use App\Http\Requests\DeleteArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Services\ArticlesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ArticlesController extends Controller
{
    public ArticlesService $articlesService;

    public function __construct(ArticlesService $articlesService)
    {
        $this->articlesService = $articlesService;
    }

    public function list(Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 2);

        //order_by 방식
//    $articles = Article::select('body', 'created_at')->orderBy('created_at', 'desc')->orderby('body','asc')->get();
        //orderBy('created_at', 'desc')와 동일
//    $articles = Article::select('body', 'created_at')->latest()->get();
        //orderBy('created_at', 'asc')와 동일
//    $articles = Article::select('body', 'created_at')->oldest()->get();

//     limit : take, offset : skip
//        ORM을 사용하지 않으면 아래와 같이 쿼리로 join해야 한다.
//        $articles = Article::join('users', 'articles.user_id', '=', 'users.id')
//            ->select('articles.*', 'users.name as user_name')
//            ->latest()
//            ->skip($offset)
//            ->take($perPage)
//            ->get();


        $articles = $this->articlesService->getArticles($page, $perPage);
        $totalCount = $this->articlesService->getArticlesTotalCount();

        return [
            'articles' => $articles,
            'totalCount' => $totalCount,
            'page' => $page,
            'perPage' => $perPage,
        ];
    }

    public function create(CreateArticleRequest $request)
    {
        $input = $request->validated();

        Article::create([
            'body' => $input['body'],
//            로그인 기능을 만들때까지 하드코딩
            'user_id' => Auth::id()
        ]);

        return redirect()->route('articles.index');
    }

    public function update(UpdateArticleRequest $request, Article $article)
    {
        //검증이 된 결과 가져오기
        $input = $request->validated();

        Article::where('id', $article->id)->update($input);

        return redirect()->route('articles.index');
    }

    public function delete(DeleteArticleRequest $request, Article $article)
    {
        $article->delete(); // 해당 레코드 삭제

        return 'delete';
    }
}
