<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;



class Handler extends ExceptionHandler
{

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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

    protected function invalidJson($request, ValidationException $exception){
//        return sendError('',\Arr::first(\Arr::first($exception->errors())));
        return response()->json([
            'status' => false,
            'message' => 'The given data was invalid.',
            'errors' => $exception->errors(),
        ], $exception->status);
    }
    public function render($request, Throwable $exception)
    {

        if ($request->is('api/*')) {
            // Code for API specific error handling

            // Return an API response with the error message
            return  sendError( $exception->getMessage());

        }else{
            return parent::render($request, $exception);
        }


    }
}
