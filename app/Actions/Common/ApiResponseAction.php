<?php

namespace App\Actions\Common;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Symfony\Component\HttpFoundation\Response;

class ApiResponseAction
{
    use AsAction;

    public function handle($status, $msg, $data)
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
