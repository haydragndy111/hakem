<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use BezhanSalleh\FilamentExceptions\FilamentExceptions;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
        $this->reportable(function (Throwable $e) {
            if ($this->shouldReport($e)) {
                FilamentExceptions::report($e);
            }
        });
    }

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
        // if (config('app.env') == 'production') {
        //     if (app()->bound('sentry') && $this->shouldReport($exception)) {
        //         app('sentry')->captureException($exception);
        //     }
        // }
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

        if ($exception instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($exception, $request);
        }
        if ($exception instanceof ModelNotFoundException) {
            $modelName = strtolower(class_basename($exception->getModel()));
            return $this->errorResponse("No {$modelName} Found", 404);
        }
        if ($exception instanceof FileNotFoundException) {

            return $this->errorResponse('The specified File can not be found', 404);
        }
        if ($exception instanceof AuthenticationException) {
            $this->unauthenticated($request, $exception);
        }
        if ($exception instanceof AuthorizationException) {
            return $this->errorResponse($exception->getMessage(), 403);
        }

        if ($exception instanceof NotFoundHttpException && $this->isFrontend($request) == false) {
            return $this->errorResponse('The specified URL can not be found', 404);
        }
        if ($exception instanceof MethodNotAllowedException) {
            return $this->errorResponse('The specified METHOD for your request not valid', 405);
        }
        if ($exception instanceof HttpException && $this->isFrontend($request) == false) {
            return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
        }
        if ($exception instanceof TokenMismatchException) {
            return $this->errorResponse($exception->getMessage(), 401);
        }

        // if ($exception instanceof ErrorException) {
        //     return $this->errorResponse('file not found', 404);
        // }
        // foriegn key exception
        if ($exception instanceof QueryException) {
            $errorCode = $exception->errorInfo[1];
            if ($errorCode == 1451) {
                return $this->errorResponse('Can not remove this resource permenantly. related to another resource', 409);
            }
            if ($errorCode == 1062) {
                return $this->errorResponse('Duplicate entry', 410);
            }
            // if ($errorCode == 7) {
            //     return $this->errorResponse('Invalid request input' ,422);
            // }

        }

        if ($exception instanceof TokenMismatchException) {
            return redirect()->back()->withInput($request->input());
        }

        if (config('app.debug')) {
            return parent::render($request, $exception);
        }
        return $this->errorResponse('Unexpected Exception, Please Try later', 500);

    }
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        /*return $request->expectsJson()
        ? response()->json(['message' => $exception->getMessage()], 401)
        : redirect()->guest($exception->redirectTo() ?? route('login'));*/
        if ($this->isFrontend($request)) {
            return redirect()->guest('admin/login');
        }
        return $this->errorResponse('UnAuthintecated', 401);

    }
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        /*if ($e->response) {
        return $e->response;
        }
        return $request->expectsJson()
        ? $this->invalidJson($request, $e)
        : $this->invalid($request, $e);*/
        $errors = $e->validator->errors()->getMessages();
        //return response()->json($errors,422);
        if ($this->isFrontend($request)) {
            return $request->ajax() ? response()->json($errors, 422) : redirect()->back()->withInput($request->input())
                ->withErrors($errors);
        }
        return $this->errorResponse($errors, 422);
    }
    private function isFrontend($request)
    {
        return !$request->is('api/*');
    }

}
