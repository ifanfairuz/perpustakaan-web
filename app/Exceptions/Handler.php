<?php

namespace App\Exceptions;

use App\Http\Controllers\Traits\MyResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    use MyResponse;

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
        $this->renderable(function (AuthenticationException $e) {
            if (in_array('api', $e->guards())) {
                return $this->response(\request(), 'Unauthenticated.', false, 'Unauthenticated.');
            }
        });
    }
}
