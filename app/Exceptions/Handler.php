<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\Response;

use function GuzzleHttp\json_decode;

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
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        if (app()->bound('sentry') && $this->shouldReport($e)) {
            app('sentry')->captureException($e);
        }

        parent::report($e);
    }
    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof HttpResponseException) {
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;
        } elseif ($e instanceof HttpException) {
            $status = $e->getStatusCode();
            $message = $e->getMessage();
        } elseif ($e instanceof MethodNotAllowedHttpException) {
            $status = Response::HTTP_METHOD_NOT_ALLOWED;
            $e = new MethodNotAllowedHttpException([], 'HTTP_METHOD_NOT_ALLOWED', $e);
            $message = $e->getMessage();
        } elseif ($e instanceof NotFoundHttpException) {
            $status = Response::HTTP_NOT_FOUND;
            $e = new NotFoundHttpException('HTTP_NOT_FOUND', $e);
            $message = $e->getMessage();
        } elseif ($e instanceof ModelNotFoundException) {
            $status = Response::HTTP_NOT_FOUND;
            $message = $e->getMessage();
        } elseif ($e instanceof AuthorizationException) {
            $status = Response::HTTP_FORBIDDEN;
            $e = new AuthorizationException('HTTP_FORBIDDEN', $status);
            $message = $e->getMessage();
        } elseif ($e instanceof ValidationException) {
            $response = json_decode($e->getResponse()->getContent(), true);
            $status = $e->getResponse()->getStatusCode();
            
            foreach (array_reverse($response) as $key => $value) {
                $message = $key .' - '. $value[0];
            }
        } elseif ($e instanceof \Dotenv\Exception\ValidationException && $e->getResponse()) {
            $status = Response::HTTP_BAD_REQUEST;
            $e = new \Dotenv\Exception\ValidationException('HTTP_BAD_REQUEST', $status, $e);
            $message = $e->getMessage();
        } else {
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;
            $message = $e->getMessage();
        }

        if (getenv('APP_ENV') == 'production') {
            return response()->json([
                'success' => false,
                'status'  => $status,
                'message' => $message,
            ], $status);
        } else {
            $trace = (string) json_encode($e->getTrace(), true) == "" ? "" : json_decode((string) json_encode($e->getTrace(), true));
            return response()->json([
                'success' => false,
                'status'  => $status,
                'message' => $message,
                'trace'   => $trace
            ], $status);
        }
    }
}
