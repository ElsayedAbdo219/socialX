<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    protected ?int $statusCode = null;

    /**
     * setStatusCode() set status code value
     *
     * @param $statusCode
     * @return $this
     */
    protected function setStatusCode($statusCode): static
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * respondWithArray() used to return json response array with status and headers
     *
     * @param $data
     * @param array $headers
     * @return JsonResponse
     */
    protected function respondWithArray($data, array $headers = []): JsonResponse
    {
        return response()->json($data, $data['status'] ?? 200, $headers);
    }

    /**
     * getStatusCode() return status code value
     *
     * @return int
     */
    protected function getStatusCode(): int
    {
        return $this->statusCode ?: 200;
    }
    /**
     * respondWithSuccess() used to return success message
     *
     * @param string|null $message
     * @param array $data
     * @return JsonResponse
     */
    protected function respondWithSuccess(string $message = null, array $data = []): JsonResponse
    {
        $response = [
            'status' => 200,
        ];
        $response['message'] = !empty($message) ? $message : __('Success');
        if (!empty($data)) {
            $response['data'] = $data;
        }
        return $this->setStatusCode(200)->respondWithArray($response);
    }

    /**
     * @param string|null $message
     * @param mixed $data
     * @return JsonResponse
     */
    protected function respondWithCollection(mixed $collection, int $statusCode = null, $headers = []): mixed
    {
        $statusCode = $statusCode ?? 200;
        return $this->setStatusCode($statusCode)->respond($collection, $headers);
    }

    protected function respondWithModelData($model, int $statusCode = null, array $headers = []): mixed
    {
        $statusCode = $statusCode ?? 200;
        return $this->setStatusCode($statusCode)->respond($model, $headers);
    }

    /**
     * respondWithError() used to return error message
     *
     * @param $message
     * @return JsonResponse
     */
    protected function respondWithError($message): JsonResponse
    {
        if ($this->statusCode === 200) {
            trigger_error(
                "You better have a really good reason for error on a 200...",
                E_USER_WARNING
            );
        }
        return $this->respondWithErrors($message, $this->statusCode, [], $message);
    }

    /**
     * respondWithErrors()
     *
     * @param string $errors
     * @param null $statusCode
     * @param array $data
     * @param null $message
     * @return JsonResponse
     */
    protected function respondWithErrors(
        string $errors = 'messages.error',
        $statusCode = null,
        array  $data = [],
        $message = null
    ): JsonResponse {
        $statusCode = !empty($statusCode) ? $statusCode : 400;
        if (is_string($errors)) {
            $errors = __($errors);
        }
        $response = ['status' => $statusCode, 'message' => $message, 'errors' => ['message' => [$errors]]];
        if (!empty($message)) {
            $response['message'] = $message;
        }
        if (!empty($data)) {
            $response['data'] = $data;
        }
        return $this->setStatusCode($statusCode)->respondWithArray($response);
    }

    /**
     * respondWithBoolean() used to determine if process success or failed
     *
     * @param $result
     * @return JsonResponse
     */
    protected function respondWithBoolean($result): JsonResponse
    {
        return $result ? $this->respondWithSuccess() : $this->errorUnknown();
    }

    /**
     * **************************************************************************
     *                           Response Status Helpers
     * **************************************************************************
     */

    /**
     * errorWrongArgs() Generates a Response with a 400 HTTP header and a given message.
     *
     * @param null $message
     * @return JsonResponse
     */
    public function errorWrongArgs($message = null): JsonResponse
    {
        if (empty($message)) {
            $message = __('Wrong Arguments');
        }
        return $this->setStatusCode(400)->respondWithError($message);
    }

    /**
     * errorUnauthorized() Generates a Response with a 401 HTTP header and a given message.
     *
     * @param null $message
     * @return JsonResponse
     */
    public function errorUnauthorized($message = null): JsonResponse
    {
        if (empty($message)) {
            $message = __('Unauthorized');
        }
        return $this->respondWithErrors($message, 401);
    }

    /**
     * errorForbidden() Generates a Response with a 403 HTTP header and a given message.
     *
     * @param null $message
     * @return JsonResponse
     */
    public function errorForbidden($message = null): JsonResponse
    {
        if (empty($message)) {
            $message = __('Forbidden');
        }
        return $this->setStatusCode(403)->respondWithError($message);
    }

    /**
     * errorNotFound() Generates a Response with a 404 HTTP header and a given message.
     *
     * @param null $message
     * @return JsonResponse
     */
    public function errorNotFound($message = null): JsonResponse
    {
        if (empty($message)) {
            $message = __('Not Found');
        }
        return $this->setStatusCode(404)->respondWithError($message);
    }

    /**
     * errorInternalError() Generates a Response with a 500 HTTP header and a given message.
     *
     * @param null $message
     * @return JsonResponse
     */
    public function errorInternalError($message = null): JsonResponse
    {
        if (empty($message)) {
            $message = __('Internal Server Error');
        }
        return $this->setStatusCode(500)->respondWithError($message);
    }

    /**
     * errorUnknown() Generates a Response with a 500 HTTP header and a given message.
     *
     * @param string $message
     * @return JsonResponse
     */
    public function errorUnknown(string $message = 'dashboard.unknown_error'): JsonResponse
    {
        if (empty($message)) {
            $message = __('Unknown Error');
        }
        return $this->setStatusCode(500)->respondWithError($message);
    }

    /**
     * base json response
     *
     * @param $data
     * @param int $statusCode
     * @return JsonResponse
     */
    public function respondWithJson($data, int $statusCode = 200): JsonResponse
    {
        return response()->json($data, $statusCode);
    }


    protected function respond($resources, array $headers = []): mixed
    {
        return $resources
            ->additional(['status' => $this->getStatusCode()])
            ->response()
            ->setStatusCode($this->getStatusCode())
            ->withHeaders($headers);
    }


}
