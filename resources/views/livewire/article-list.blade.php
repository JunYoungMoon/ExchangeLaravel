{{-- article-list.blade.php --}}

<div>
    <h1>글목록</h1>
    <div>
        <ul class="list2">
            @foreach($articles as $article)
                <li>
                    <a href="/articles/detail/{{ $article['id'] }}">
                        {{ $article['body'] }} {{ $article['created_at'] }} {{ $article['user']['name'] }}
                    </a>
                    @can('update',$article)
                    <a href="/articles/edit/{{ $article['id'] }}">글수정</a>
                    @endcan
                    @can('delete',$article)
                    <a href="#" wire:click="deleteArticle({{ $article['id'] }})">글삭제</a>
                    @endcan
                </li>
            @endforeach
        </ul>
    </div>

    <livewire:pagination :page="$page" :perPage="$perPage" :total="$total" :key="$page"/>
</div>
