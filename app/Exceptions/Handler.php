<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Exceptions\MethodNotAllowedHttpException;

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
     * This registers the exception handling callbacks for the application.
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
     * This method handles the rendering of exceptions and can customize the response
     * based on the type of exception. Specifically, it handles MethodNotAllowedHttpException
     * to provide a specific JSON response or a view for non-API requests.
     *
    */
    public function render($request, Throwable $exception)
    {
        // This handles MethodNotAllowedHttpException
        if ($exception instanceof MethodNotAllowedHttpException) {
            if ($request->expectsJson()) {


                // This displays HTTP status code for Method Not Allowed
                return response()->json([
                    'error' => 'Method Not Allowed',
                    'message' => 'The method is not allowed for the requested route.'
                ], 405);
            }


            // This is for non-API requests
            return response()->view('errors.405', [], 405);
        }

        return parent::render($request, $exception);
    }

}
