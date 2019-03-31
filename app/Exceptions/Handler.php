<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Session\TokenMismatchException;

class Handler extends ExceptionHandler
{
    /**
    * A list of the exception types that are not reported.
    *
    * @var array
    */
    protected $dontReport = [];

    /**
    * A list of the inputs that are never flashed for validation exceptions.
    *
    * @var array
    */
    protected $dontFlash = [
        'password',
        'passwordOld',
        'passwordVerify',
    ];

    /**
    * Report or log an exception.
    *
    * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
    *
    * @param  \Exception  $exception
    * @return void
    */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
    * Render an exception into an HTTP response.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Exception  $exception
    * @return \Illuminate\Http\Response
    */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof TokenMismatchException) {
            if ($request->ajax() ||
                $request->isJson() ||
                $request->wantsJson()
            ) {
                return response([
                    "errors" => [
                        "message" => "xcsrf",
                        "xcsrf" => __('auth.xcsrf')
                    ]
                ], 200);
            }
            return redirect()->guest('/');
        }
        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->ajax() ||
            $request->isJson() ||
            $request->wantsJson()
        ) {
            return response([
                "errors" => [
                    "message" => "authentication",
                    "authentication" => __('auth.session_end')
                ]
            ], 200);
        }

        return redirect()->to('/');
    }
}
