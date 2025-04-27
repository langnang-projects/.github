<?php

namespace App\Traits\Controller;

/**
 * Summary of HasResponse
 * @namespace \App\Traits\Controller\HasResponse;
 * @method mixed response()
 * @method mixed getResponseData()
 */
trait HasResponse
{
    public function response()
    {
    }
    public function response_json($status, $message = null, $data = null)
    {
        return response()->json([
            "status" => $status,
            "message" => $message,
            "data" => $data,
        ]);
    }
    public function response_success($data = [], $message = null, $status = 200)
    {
        return $this->response_json($status, $message, $data);
    }
    public function response_error($data = [], $message = null, $status = 400)
    {
        return $this->response_json($status, $message, $data);
    }
    public function response_debug()
    {
    }

    public function getResponseData()
    {
    }
}
