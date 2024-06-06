<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if($response->getData() && property_exists($response->getData(), 'status')){
            $status = $response->getData()->status;
            $msg = $response->getData()->msg;

            if($status === 'error'){
                return $this->jsonResponse('error', $msg, []);
            }
        }
        return $this->jsonResponse('success', '', $response->getData());
    }

    public function jsonResponse($status, $msg, $data)
    {
        return response()->json(
            [
                "status" => $status,
                "msg" => $msg,
                "data" => $data
            ],
            200
        );
    }
}
