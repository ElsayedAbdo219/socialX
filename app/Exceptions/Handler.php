<?php

namespace App\Exceptions;

use App\Traits\ApiResponseTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\Exceptions\MissingAbilityException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Broadcasting\BroadcastException;
use Spatie\Permission\Exceptions\UnauthorizedException;

class Handler extends ExceptionHandler
{
    use ApiResponseTrait;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {

        if ($request->is('api/*') || $request->wantsJson()) {

            if ($exception->getMessage() == "Unauthenticated.") {
                $message = is_array($exception->getMessage()) ? $exception->getMessage()[0] : $exception->getMessage();
                return $this->setStatusCode(401)->respondWithError($message);
            }

            if ($exception instanceof AuthenticationException) {
                $message = is_array($exception->getMessage()) ? $exception->getMessage()[0] : $exception->getMessage();
                return $this->setStatusCode(401)->respondWithError($message);
            }

            if($exception instanceof UnauthorizedException || $exception instanceof AuthorizationException) {
                $message = is_array($exception->getMessage()) ? $exception->getMessage()[0] : $exception->getMessage();
                return $this->setStatusCode(403)->respondWithError($message);

            }

            if ($exception instanceof HttpException) {
                $message = is_array($exception->getMessage()) ? $exception->getMessage()[0] : $exception->getMessage();
                return $this->setStatusCode($exception->getCode())->respondWithError($message);
            }

            if ($exception instanceof ValidationException) {
                $errors = $exception->errors();
                $message = is_array($exception->getMessage()) ? $exception->getMessage()[0] : $exception->getMessage();
                return $this->setStatusCode(422)->respondWithError($message);
            }
        }
        return parent::render($request, $exception);
    }
}
