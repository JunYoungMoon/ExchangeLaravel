@extends('layouts.app')

@section('content')
    <div>
        <h1>로그인</h1>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div>
                <label for="email">이메일</label>
                <input id="email" type="text" name="email" value="{{ old('email') }}" required autofocus>
            </div>
            @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div>
                <label for="password">비밀번호</label>
                <input id="password" type="password" name="password" value="{{ old('password') }}" required>
            </div>
            @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div>
                <button type="submit">로그인</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('loginForm').addEventListener('submit', async function(event) {
            event.preventDefault();

            try {
                const formData = new FormData(this);
                const response = await axios.post('{{ route('api.login') }}', formData);

                console.log(response);

                const token = response.data.token; // 토큰 추출
                saveTokenToCookie(token); // 토큰을 쿠키에 저장하는 함수 호출
                // 로그인 성공 후 리다이렉트 또는 다른 작업 수행
            } catch (error) {
                // 오류 처리
                console.error('로그인 오류:', error);
            }
        });

        function saveTokenToCookie(token) {
            // 쿠키에 토큰 저장
            document.cookie = `laravel_session=${token}; path=/; expires=${getCookieExpirationDate()};`;
        }

        function getCookieExpirationDate() {
            // 쿠키 만료일 설정
            const expires = new Date();
            expires.setDate(expires.getDate() + 1); // 하루 뒤 만료
            return expires.toUTCString();
        }
    </script>
@endpush
