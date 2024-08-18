<?php

namespace App\Trait;


trait ApiResponseTrait
{


    public function returnWithSuccess(string $message, array $data = [], int $statusCode = 200, array $headers = [])
    {
        return (new static())->respondWithSuccess($message, $data)->withHeaders($headers)->setStatusCode($statusCode);
    }
}
