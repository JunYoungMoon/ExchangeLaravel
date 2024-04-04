@extends('layouts.app')

@section('content')
<!-- Validation Errors -->
<x-auth-validation-errors class="mb-4" :errors="$errors" />
<form method="POST" action="{{ route('register') }}">
    @csrf
    <div>
        <label for="name">이름</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
    </div>
    @error('name')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <div>
        <label for="email">이메일</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required>
    </div>
    @error('email')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <div>
        <label for="password">비밀번호</label>
        <input id="password" type="password" name="password" required autocomplete="new-password">
    </div>
    @error('password')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <div>
        <label for="password_confirmation">비밀번호 확인</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required>
    </div>
    @error('password_confirmation')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <div>
        <button type="submit">가입</button>
    </div>
</form>
@endsection

@push('scripts')
    <script type="module">
        let frm = new FormData();
        let name = document.getElementById("name").value;
        let email = document.getElementById("email").value;
        let password = document.getElementById("password").value;
        let password_confirmation = document.getElementById("password_confirmation").value;

        frm.append("name", name);
        frm.append("email", email);
        frm.append("password", password);
        frm.append("password_confirmation", password_confirmation);

        // const userData = {
        //     name: $('#name').val(),
        //     email: $('#email').val(),
        //     password: $('#password').val(),
        //     password_confirmation: $('#password_confirmation').val()
        // };

        try {
            const res = await axios.post('/api/register', frm);

            // const response = await axios.post('/api/register', userData);
        } catch (error) {
            if (error.response.status === 422) {
                // const errors = error.response.data.errors;
                // // 오류 메시지를 화면에 표시하는 로직 추가
                // const errorContainer = document.querySelector('.auth-validation-errors');
                // errorContainer.innerHTML = ''; // 오류 메시지를 초기화
                //
                // for (const [key, value] of Object.entries(errors)) {
                //     value.forEach(errorMessage => {
                //         errorContainer.innerHTML += `<div>${errorMessage}</div>`;
                //     });
                // }

                console.error('API 호출 중 오류 발생:', error);
                throw error;
            } else {
                console.error('API 호출 중 오류 발생:', error);
            }
        }
    </script>
@endpush

{{--@section('modals')--}}
{{--    <div id="delete-log-modal" class="modal fade">--}}
{{--        <div class="modal-dialog">--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}
