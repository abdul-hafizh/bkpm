<?php

namespace SimpleCMS\Core\Exceptions;

use Throwable;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Routing\Exceptions\UrlGenerationException;
use Illuminate\Session\TokenMismatchException;
use Nwidart\Modules\Exceptions\ModuleNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

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
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        if (env('SENTRY_LARAVEL_DSN') !== '') {
            if (app()->bound('sentry') && $this->shouldReport($exception)) {
                app('sentry')->captureException($exception);
            }
        }
        parent::report($exception);
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
        $hasException = [];

        if($exception instanceof TokenMismatchException){
            $hasException = ['code'=> 401 , 'message'=>$exception->getMessage(), 'exceptions' => $exception];
        }
        elseif($exception instanceof NotFoundHttpException)
        {
            $hasException = ['code'=> 404 , 'message'=>$exception->getMessage(), 'exceptions' => $exception];
        }
        elseif($exception instanceof MethodNotAllowedHttpException)
        {
            $hasException = ['code'=> 404 , 'message'=>$exception->getMessage(), 'exceptions' => $exception];
        }
        elseif($exception instanceof MethodNotAllowedException){
            $hasException = ['code'=> 404 , 'message'=>$exception->getMessage(), 'exceptions' => $exception];
        }
        elseif($exception instanceof RouteNotFoundException){
            $hasException = ['code'=> 500 , 'message'=>$exception->getMessage(), 'exceptions' => $exception];
        }
        elseif($exception instanceof \InvalidArgumentException){
            $hasException = ['code'=> 500 , 'message'=>$exception->getMessage(), 'exceptions' => $exception];
        }
        elseif($exception instanceof \ReflectionException){
            $hasException = ['code'=> 500 , 'message'=>$exception->getMessage(), 'exceptions' => $exception];
        }
        elseif($exception instanceof \ErrorException){
            $hasException = ['code'=> 500 , 'message'=>$exception->getMessage(), 'exceptions' => $exception];
        }
        elseif ($exception instanceof ModuleNotFoundException)
        {
            $hasException = ['code'=> 500 , 'message'=>$exception->getMessage(), 'exceptions' => $exception];
        }
        elseif ($exception instanceof HttpResponseException)
        {
            $hasException = ['code'=> 500 , 'message'=>$exception->getMessage(), 'exceptions' => $exception];
        }
        elseif ($exception instanceof ModelNotFoundException)
        {
            $hasException = ['code'=> 500 , 'message'=>$exception->getMessage(), 'exceptions' => $exception];
        }
        elseif ($exception instanceof AuthorizationException)
        {
            $hasException = ['code'=> 401 , 'message'=>$exception->getMessage(), 'exceptions' => $exception];
        }
        elseif ($exception instanceof HttpException)
        {
            $hasException = ['code'=> 404 , 'message'=>$exception->getMessage(), 'exceptions' => $exception];
        }elseif ($exception instanceof UrlGenerationException)
        {
            $hasException = ['code'=> 500 , 'message'=>$exception->getMessage(), 'exceptions' => $exception];
        }elseif ($exception instanceof AuthenticationException)
        {
            $hasException = ['code'=> 401 , 'message'=>$exception->getMessage(), 'exceptions' => $exception];
        }elseif ($exception instanceof QueryException)
        {
            $hasException = ['code'=> 500 , 'message'=>$exception->getMessage(), 'exceptions' => $exception];
        }elseif ($exception instanceof PMGException){
            $hasException = ['code'=> 404 , 'message'=>$exception->getMessage(), 'exceptions' => $exception];
        }

        if(count($hasException)){

            \Log::error($exception);

            if (env('APP_ENV') != 'local' && $hasException['code'] == 500){
                $hasException['message'] = 'Internal Server Error, Please contact admin.';
                $hasException['exceptions'] = '';
            }

            if ( ($request->ajax() OR $request->wantsJson()) OR $request->segment(1) == 'api' OR in_array($request->getContentType(),['json'])) {
                return response()->json(['status' => 'error', 'code' => $hasException['code'], 'body' => $hasException], $hasException['code']);
            }
            return response()->view(errorPage((string)$hasException['code']), $hasException , $hasException['code']);
        }
        return parent::render($request, $exception);
    }
}
