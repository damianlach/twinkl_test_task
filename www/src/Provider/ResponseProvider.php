<?php

declare(strict_types=1);

namespace App\Provider;

use Symfony\Component\HttpFoundation\Response;

class ResponseProvider
{
    public function __construct(
        public int     $status = Response::HTTP_OK,
        public ?string $message = null,
        public ?array  $data = null,
        public ?array  $error = null,
    )
    {
    }

    public function createResponse()
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data,
            'error' => $this->error,
        ];
    }
}