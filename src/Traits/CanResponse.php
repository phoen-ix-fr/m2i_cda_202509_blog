<?php

namespace M2i\Blog\Traits;

trait CanResponse
{
    protected function jsonErrorResponse(int $httpCode, string $message)
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($httpCode);

        $errorJson = json_encode([
            'success'   => false,
            'error'     => [
                'message'   => $message
            ]
        ]);

        return $errorJson;
    }

    protected function jsonSuccessResponse(array $data, string $message = "", int $httpCode = 200)
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($httpCode);

        $json = json_encode([
            'success'   => true,
            'data'      => $data,
            'message'   => $message
        ]);

        if(json_last_error() !== JSON_ERROR_NONE) {

            $errorJson = json_encode([
                'success'   => false,
                'error'     => [
                    'message'   => json_last_error_msg()
                ]
            ]);

            return $errorJson;
        }
        else {
            return $json;
        }
    }
}