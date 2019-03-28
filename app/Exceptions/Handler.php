<?php

namespace App\Exceptions;

use App\Http\XhrResponse;
use App\Services\IceAndFire\Exceptions\ApiException as IceAndFireApiException;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
		IceAndFireApiException::class
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
        return parent::render($request, $exception);
    }

	/**
	 * Convert Ice and Fire exception to http response
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \App\Services\IceAndFire\Exceptions\ApiException $exception
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function convertIceAndFireApiExceptionToResponse(
    	Request $request,
		IceAndFireApiException $exception
	) {
    	if ($request->expectsJson()) {
    		return XhrResponse::error(
    			$exception->getApiMessage()
			);
		}

		return redirect()->back()->with('error', $exception->getApiMessage());
	}
}
