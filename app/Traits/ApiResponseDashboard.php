<?php

namespace App\Traits;

trait ApiResponseDashboard
{
    protected int $code = 400;

    protected array $body = [];

    protected array $routes = [];

    protected string $message = '';

    protected string $info = 'from response action';

    protected function apiResponse(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'code' => $this->code,
            'status' => $this->code === 200,
            'message' => $this->message,
            'body' => (object) $this->body,
            'info' => $this->info,
        ], $this->code);
    }

    protected function apiBody(array $body = []): static
    {
        foreach ($body as $key => $value) {
            $this->body[$key] = $value;
        }

        return $this;
    }

    protected function apiRoute(array $route = []): static
    {
        foreach ($route as $key => $value) {
            $this->routes[$key] = $value;
        }

        return $this;
    }

    protected function apiMessage(string $message = ''): static
    {
        $this->message = $message;

        return $this;
    }

    protected function apiInfo(string $info = '', $addToCurrent = false): static
    {
        $addToCurrent ? $this->info .= $info : $this->info = $info;

        return $this;
    }

    protected function apiCode(int $code = 400): static
    {
        $this->code = $code;

        return $this;
    }

    protected function routes(): array
    {
        return array_merge([
            'current' => request()->url(),
        ], $this->routeAction());
    }
}
