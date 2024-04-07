<!-- article-list.blade.php -->

<div>
    <h1>글목록</h1>
    <div>
        <ul class="list2">
            @foreach($articles as $article)
                <li>
                    <a href="/articles/detail/{{ $article['id'] }}">
                        {{ $article['body'] }} {{ $article['created_at'] }} {{ $article['user']['name'] }}
                    </a>
                    <a href="/articles/edit/{{ $article['id'] }}">글수정</a>
                    <a href="#" wire:click="deleteArticle({{ $article['id'] }})">글삭제</a>
                </li>
            @endforeach
        </ul>
    </div>

    <livewire:pagination :page="$page" :perPage="$perPage" :total="$pagination['totalCount']"/>
</div>
