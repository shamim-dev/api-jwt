<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // modified by shamim for 404 exception handle
        $appName=ENV('APP_NAME');
        if ($exception instanceof NotFoundHttpException){
            return response('Welcome to '.$appName.' ,<br> But your requested Page/url not found', 404);
        }elseif ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json(['error code' => $exception->getCode(),'message' => 'Method is not allowed for the requested route'], 405);
        }
        if ($exception instanceof MethodNotAllowedHttpException) {
            $errMgs = 'Welcome to '.$appName.' , But your requested method not found';
            return response()->json(['error code' => '405', 'message' => $errMgs], 405);
        }
         return parent::render($request, $exception);

    }



}
