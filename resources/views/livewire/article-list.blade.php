{{-- article-list.blade.php --}}

<div>
    <h1>글목록</h1>
    <div>
        <label>검색 :
            <input type="search" wire:model.live.debounce.800ms="search">
        </label>
    </div>
    <div>
        <table>
            <thead>
            <tr>
                <th style="border: 1px solid #dddddd; padding: 8px;">
                    <button wire:click="changeSortBy('id')">
                        번호
                    </button>
                </th>
                <th style="border: 1px solid #dddddd; padding: 8px;">
                    <button wire:click="changeSortBy('body')">
                        내용
                    </button>
                </th>
                <th style="border: 1px solid #dddddd; padding: 8px;">수정</th>
                <th style="border: 1px solid #dddddd; padding: 8px;">삭제</th>
            </tr>
            </thead>
            <tbody>
            @foreach($articles as $article)
                <tr style="border: 1px solid #dddddd; padding: 8px;">
                    <td style="border: 1px solid #dddddd; padding: 8px;">
                        {{ $article['id'] }}
                    </td>
                    <td style="border: 1px solid #dddddd; padding: 8px;">
                        <a href="/articles/detail/{{ $article['id'] }}">
                            {{ $article['body'] }} {{ $article['created_at'] }} {{ $article['user']['name'] }}
                        </a>
                    </td>
                    <td style="border: 1px solid #dddddd; padding: 8px;">
                        @can('update',$article)
                            <a href="/articles/edit/{{ $article['id'] }}">글수정</a>
                        @endcan
                    </td>
                    <td style="border: 1px solid #dddddd; padding: 8px;">
                        @can('delete',$article)
                            <a href="#" wire:click="delete({{ $article['id'] }})">글삭제</a>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div>
        {{ $articles->onEachSide(1)->links() }}
    </div>
    {{--    <livewire:pagination :page="$page" :perPage="$perPage" :total="$total" :key="$page"/>--}}
</div>
