<?php

namespace App\Exceptions\Api\Auth;

use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class ApiBaseException extends Exception
{
    use ApiResponseTrait;
    protected $errors;

    public function __construct(array $errors, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    /**
     * Report the exception without vendor code.
     *
     */
    public function report(): void
    {

    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request): JsonResponse
    {
        return $this->respondWithErrors(
            errors: $this->message,
            statusCode: $this->code,
            data: $this->errors,
            message: $this->message
        );
    }

    public static function wrongImplementation($errors, $code = null)
    {
        return new self($errors, __("Failed Operation"), $code ?? 500);
    }
}
