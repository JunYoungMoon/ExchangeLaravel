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

    <div>
        @if ($pagination['previous'])
            <button wire:click="previousPage">Previous</button>
        @endif

        @foreach ($pagination['pages'] as $pageNumber)
            <button wire:click="gotoPage({{ $pageNumber }})">{{ $pageNumber }}</button>
        @endforeach

        @if ($pagination['next'])
            <button wire:click="nextPage">Next</button>
        @endif
    </div>
</div>
