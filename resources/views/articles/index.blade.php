@extends('layouts.app')

@section('content')
    <h1>글목록</h1>
    <div>
        <ul class="list">
            {{--axios로 내용이 들어갈 위치--}}
        </ul>
    </div>
    <div class="paging">
        {{--하단 버튼 태그가 들어갈 위치--}}
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script type="module">
        window.onpageshow = function (event) {
            if (event.persisted || (window.performance && window.performance.navigation.type == 2)) {
                parseUrlParamsAndDrawPage();
            } else {
                parseUrlParamsAndDrawPage();
            }
        };

        window.onpopstate = function () {
            parseUrlParamsAndDrawPage();
        };

        function parseUrlParamsAndDrawPage() {
            drawPage(_cmn.url.getParam('page', '1'), true);
        }

        async function drawPage(page = 1, notPush = false) {
            const apiUrl = "{{ route('api.articles.list') }}"; // API 엔드포인트 주소 관리

            let data = {
                page: page,
                perPage: 10,
            };

            if (!notPush) {
                let url = _cmn.url.setParams(data);
                history.pushState({url: url.toString()}, '', url.toString());
            }

            try {
                const response = await axios.post(apiUrl, data);

                // 응답 데이터
                const { articles, totalCount, page, perPage } = response.data;

                console.log(articles);

                let html = '';

                for (let i in articles) {
                    html += '<li>';
                    html += articles[i].body + ' ';
                    html += _cmn.time.getWhenDateAdmin(articles[i].created_at, 2) + ' ';
                    html += articles[i].user.name;
                    // html += moment(articles[i].created_at).fromNow();
                    html += '</li>';
                }

                $('.list').html(html);

                $('.paging').html(_cmn.pagination.getPagination(totalCount, page, perPage, 2));

                $('.paging a').on('click', function () {
                    drawPage($(this).text());
                });
            } catch (error) {
                if (error.response.status === 422) {
                    console.error('API 호출 중 오류 발생:', error);
                    throw error;
                } else {
                    console.error('API 호출 중 오류 발생:', error);
                }
            }
        }
    </script>
@endpush
