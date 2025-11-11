<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
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
        // 403 Forbidden
        if ($exception instanceof HttpException && $exception->getStatusCode() === 403) {
            return response()->view('publication::site.page.404.error', [], 403);
        }

        // 404 Not Found
        if ($exception instanceof NotFoundHttpException) {
            return response()->view('publication::site.page.404.error', [], 404);
        }

        // Database Query Exception
        if ($exception instanceof QueryException) {
            return response()->view('errors.database', [
                'message' => 'A database error occurred: ' . $exception->getMessage(),
            ], 500);
        }

        return parent::render($request, $exception);
    }
}
