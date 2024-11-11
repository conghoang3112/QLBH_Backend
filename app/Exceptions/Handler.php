<?php

namespace App\Exceptions;

use App\Exceptions\Business\ActionFailException;
use App\Helpers\Enums\ErrorCodes;
use App\Helpers\ExceptionHelper;
use App\Helpers\Responses\ApiResponse;
use App\Helpers\Responses\HttpStatuses;
use BenSampo\Enum\Exceptions\InvalidEnumKeyException;
use BenSampo\Enum\Exceptions\InvalidEnumMemberException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render exception response
     * @param $request
     * @param Throwable $exception
     * @return mixed
     * @throws InvalidEnumKeyException
     * @throws Throwable
     */
    public function render($request, Throwable $exception): mixed
    {
        # if not api call render as normal
        if (!$this->shouldReturnJson($request, $exception))
            return parent::render($request, $exception);

        return $this->renderForApi($request, $exception);
    }


    /**
     * Return error response for validation exception
     * @param mixed $exception
     * @return Response
     * @throws InvalidEnumMemberException
     */
    private function apiResponseForValidationError(mixed $exception): Response
    {
        return ApiResponse::v1()
            ->withStatusCode(HttpStatuses::HTTP_BAD_REQUEST)
            ->fail(data: [
                "code" => ErrorCodes::ERR_SUBMITTED_DATA_IS_INVALID,
                "message" => __(ErrorCodes::getKey(ErrorCodes::ERR_SUBMITTED_DATA_IS_INVALID)),
                "fields" => $exception->errors()
            ], dataKey: "errors");
    }

    /**
     * Return custom response for well-known business exception
     * @param ActionFailException $exception
     * @return Response
     * @throws InvalidEnumMemberException
     */
    private function apiResponseForActionFail(ActionFailException $exception): Response
    {
        $code = $exception->getCode();
        $message = __(ErrorCodes::getKey(ErrorCodes::ERR_ACTION_FAIL));

        $key = strval($exception->getCode());
        if (ErrorCodes::hasValue($key)) {
            $enum_code = ErrorCodes::getKey($key);
            $message = __($enum_code);
        }
        $data = [
            'code' => $code,
            'message' => $message
        ];

        if (config('app.debug')) {
            $trace = ExceptionHelper::makePrettyException($exception);
            $data['message'] = $exception->getMessage();
            $data['trace'] = $trace;
        }

        return ApiResponse::v1()
            ->withStatusCode(HttpStatuses::HTTP_INTERNAL_SERVER_ERROR)
            ->fail(data: $data, dataKey: "errors");
    }


    /**
     * Convert an authentication exception into a response.
     *
     * @param  Request  $request
     * @param AuthenticationException $exception
     * @return Response
     */
    protected function unauthenticated($request, AuthenticationException $exception): Response
    {
        return $this->shouldReturnJson($request, $exception)
            ? ApiResponse::v1()
            ->withStatusCode(HttpStatuses::HTTP_UNAUTHORIZED)
            ->fail(data: [__("auth.unauthenticated")])
            : redirect()->guest($exception->redirectTo() ?? route('unauthenticated'));
    }

    /**
     * Render exception for API call
     * @param Request $request
     * @param Throwable $exception
     * @return mixed|Response
     * @throws InvalidEnumKeyException
     */
    private function renderForApi(Request $request, Throwable $exception): mixed
    {
        # invalid inputs caught by FormRequest
        if ($exception instanceof ValidationException) {
            return $this->apiResponseForValidationError($exception);
        }

        if ($exception instanceof ActionFailException) {
            return $this->apiResponseForActionFail($exception);
        }


        return $this->apiResponseForOtherException($request, $exception);
    }

    /**
     * Return exception response for type of exception
     * @param Request $request
     * @param Throwable $exception
     * @return mixed
     */
    private function apiResponseForOtherException(Request $request, Throwable $exception): mixed
    {
        $data = [
            'code' => $exception->getCode(),
            'message' => $exception->getMessage()
        ];

        if (config('app.debug')) {
            $trace = ExceptionHelper::makePrettyException($exception);
            $data['trace'] = $trace;
        }

        return ApiResponse::v1()
            ->withStatusCode(HttpStatuses::HTTP_INTERNAL_SERVER_ERROR)
            ->fail(data: [$data], dataKey: "errors");
    }
}
