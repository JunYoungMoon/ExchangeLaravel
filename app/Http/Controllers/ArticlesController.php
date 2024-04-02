<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticlesController extends Controller
{
    public function list(Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 2);
        $offset = ($page - 1) * $perPage;

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

        $articles = Article::with(['user' => function ($query) {
            $query->select('id', 'name');
        }])
            ->select('id', 'body', 'user_id', 'created_at')
            ->latest()
            ->skip($offset)
            ->take($perPage)
            ->get();

        $totalCount = Article::count();

        return [
            'articles' => $articles,
            'totalCount' => $totalCount,
            'page' => $page,
            'perPage' => $perPage,
        ];
    }

    public function create(Request $request)
    {
        $input = $request->validate([
            'body' => 'required|string|max:255',
        ]);

        Article::create([
            'body' => $input['body'],
//            로그인 기능을 만들때까지 하드코딩
//            'user_id' => Auth::id()
            'user_id' => 1
        ]);

        return redirect()->route('articles.index');
    }

    public function update(Request $request, Article $article)
    {
        $input = $request->validate([
            'body' => 'required|string|max:255',
        ]);

        Article::where('id', $article->id)->update($input);

        return redirect()->route('articles.index');
    }

    public function delete(Article $article)
    {
        $article->delete(); // 해당 레코드 삭제

        return 'delete';
    }
}
