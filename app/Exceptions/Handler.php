<?php

// @codingStandardsIgnoreFile

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\AuthenticationException;

/**
 * Class Handler.
 */
class Handler extends ExceptionHandler
{
    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
    ];

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception $exception
     *
     * @return Response
     */
    public function render($request, Exception $exception): Response
    {
        return parent::render($request, $exception);
    }

    /**
     * Report or log an exception.
     *
     * @param \Exception $exception
     *
     * @throws Exception
     */
    public function report(Exception $exception) : void
    {
        if ($exception instanceof AuthenticationException) {
            abort(401, 'You are not logged in.');
        }

        if (app()->bound('sentry') && $this->shouldReport($exception)) {
            app('sentry')->captureException($exception);
        }

        parent::report($exception);
    }
}
