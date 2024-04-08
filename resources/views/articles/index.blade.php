@extends('layouts.app')

@section('content')
{{--    <h1>글목록</h1>--}}
{{--    <div>--}}
{{--        <ul class="list">--}}
{{--            axios로 내용이 들어갈 위치--}}
{{--        </ul>--}}
{{--    </div>--}}
{{--    <div class="paging">--}}
{{--        하단 버튼 태그가 들어갈 위치--}}
{{--    </div>--}}

    @livewire('article-list')

    <a href="{{ route('articles.create') }}">글작성</a>
@endsection

@push('scripts')
    <script>
        //뒤로가기, 앞으로가기
        window.onpopstate = function () {
            Livewire.dispatch('serverUrlChanged',{ page: _cmn.url.getParam('page') });
        };

        //최초
        document.addEventListener('livewire:init', () => {
            Livewire.on('clientUrlChanged', (page) => {
                let url = _cmn.url.setParams({'page': page[0]});
                history.pushState({url: url.toString()}, '', url.toString());
            });
        });
    </script>

    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>--}}

{{--    <script type="module">--}}
{{--        window.onpageshow = function (event) {--}}
{{--            if (event.persisted || (window.performance && window.performance.navigation.type == 2)) {--}}
{{--                parseUrlParamsAndDrawPage();--}}
{{--            } else {--}}
{{--                parseUrlParamsAndDrawPage();--}}
{{--            }--}}
{{--        };--}}

{{--        window.onpopstate = function () {--}}
{{--            parseUrlParamsAndDrawPage();--}}
{{--        };--}}

{{--        function parseUrlParamsAndDrawPage() {--}}
{{--            drawPage(_cmn.url.getParam('page', '1'), true);--}}
{{--        }--}}

{{--        async function drawPage(page = 1, notPush = false) {--}}
{{--            let data = {--}}
{{--                page: page,--}}
{{--                perPage: 2,--}}
{{--            };--}}

{{--            if (!notPush) {--}}
{{--                let url = _cmn.url.setParams(data);--}}
{{--                history.pushState({url: url.toString()}, '', url.toString());--}}
{{--            }--}}

{{--            try {--}}
{{--                const response = await axios.post("{{ route('api.articles.list') }}", data);--}}

{{--                // 응답 데이터--}}
{{--                const {articles, totalCount, page, perPage} = response.data;--}}

{{--                console.log(articles);--}}

{{--                let html = '';--}}

{{--                for (let i in articles) {--}}
{{--                    html += '<li>';--}}
{{--                    html += '<a href="/articles/detail/' + articles[i].id + '">';--}}
{{--                    html += articles[i].body + ' ';--}}
{{--                    html += _cmn.time.getWhenDateAdmin(articles[i].created_at, 2) + ' ';--}}
{{--                    html += articles[i].user.name;--}}
{{--                    html += '</a> ';--}}
{{--                    html += '<a href="/articles/edit/' + articles[i].id + '">글수정</a>';--}}
{{--                    html += `<a href="javascript:void(0)" class="delete-article" data-article-id="${articles[i].id}">글삭제</a>`;--}}
{{--                    // html += moment(articles[i].created_at).fromNow();--}}
{{--                    html += '</li>';--}}
{{--                }--}}

{{--                $('.list').html(html);--}}
{{--                $('.paging').html(_cmn.pagination.getPagination(totalCount, page, perPage, 2));--}}
{{--                $('.paging a').on('click', function () {--}}
{{--                    drawPage($(this).text());--}}
{{--                });--}}

{{--                // 글삭제 버튼에 이벤트 리스너 추가--}}
{{--                $('.delete-article').on('click', function(event) {--}}
{{--                    event.preventDefault();--}}
{{--                    const articleId = $(this).data('article-id');--}}
{{--                    deleteArticle(articleId);--}}
{{--                });--}}
{{--            } catch (error) {--}}
{{--                if (error.response.status === 422) {--}}
{{--                    console.error('API 호출 중 오류 발생:', error);--}}
{{--                    throw error;--}}
{{--                } else {--}}
{{--                    console.error('API 호출 중 오류 발생:', error);--}}
{{--                }--}}
{{--            }--}}
{{--        }--}}

{{--        async function deleteArticle(articleId) {--}}
{{--            try {--}}
{{--                const response = await axios.delete(`/api/articles/${articleId}`);--}}

{{--                window.location.reload();--}}
{{--                console.log('글 삭제 성공:', response.data);--}}
{{--                // 삭제 성공 시 추가적으로 할 일이 있으면 여기에 작성--}}
{{--            } catch (error) {--}}
{{--                console.error('글 삭제 실패:', error);--}}
{{--            }--}}
{{--        }--}}
{{--    </script>--}}
@endpush
