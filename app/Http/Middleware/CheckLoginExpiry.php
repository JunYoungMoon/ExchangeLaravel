<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLoginExpiry
{
    public function handle(Request $request, Closure $next): Response
    {
        // 세션에서 login_expiry 값을 가져옴
        $loginExpiry = $request->session()->get('login_expiry');

        // 현재 시간과 loginExpiry를 비교하여 유효한 경우에만 요청을 계속 진행
        if ($loginExpiry && now()->timestamp < $loginExpiry) {
            return $next($request);
        }

        // loginExpiry가 현재 시간 이후인 경우, 로그인 페이지로 리다이렉트
        return redirect()->route('login')->with('error', '로그인 세션이 만료되었습니다.');
    }
}
