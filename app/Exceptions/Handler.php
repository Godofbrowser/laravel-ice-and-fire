<?php

namespace App\Exceptions;

use App\Http\XhrResponse;
use App\Services\IceAndFire\Exceptions\ApiException as IceAndFireApiException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
    	XhrException::class,
		ValidationException::class,
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
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Exception $exception
	 *
	 * @return \Illuminate\Http\Response
	 * @throws \App\Exceptions\XhrException
	 */
    public function render($request, Exception $exception)
    {
		if ($exception instanceof ModelNotFoundException && $request->expectsJson()) {
			throw XhrException::modelNotFound();
		}

		if ($exception instanceof ValidationException) {
			return $this->validationExceptionHandler($request, $exception);
		} elseif ($exception instanceof XhrException) {
			return $this->xhrExceptionHandler($request, $exception);
		}

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

	private function validationExceptionHandler(Request $request, ValidationException $exception)
	{
		if ($request->expectsJson()) {
			return response()->json([
				'error' => $exception->errorMessage(),
				'errors' => $exception->errors(),
				'messages' => $exception->hasValidationMessages() ? $exception->errorMessages() : [],
			], Response::HTTP_BAD_REQUEST);
		}

		return redirect($exception->redirectTo ?? url()->previous())
			->withInput($request->except($this->dontFlash))
			->with('error', $exception->errorMessage())
			->withErrors($exception->errors(), $exception->errorBag);
	}

	private function xhrExceptionHandler(Request $request, XhrException $exception)
	{
		return response()->json([
			'status' => 'error',
			'error' => $exception->getMessage(),
			'errors' => $exception->hasValidator() ? $exception->getValidationErrors() : [],
			'messages' => $exception->hasValidator() ? $exception->getValidationMessages() : [],
		], $exception->getCode());
	}
}
