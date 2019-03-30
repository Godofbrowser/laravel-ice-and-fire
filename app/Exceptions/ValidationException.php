<?php
/**
 * Created by PhpStorm.
 * User: Ajeh Emeke
 * Date: 3/29/2019
 * Time: 1:31 AM
 */


namespace App\Exceptions;

use RuntimeException;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Validator as ValidatorFacade;

class ValidationException extends RuntimeException
{
	/**
	 * The validator instance.
	 *
	 * @var \Illuminate\Contracts\Validation\Validator
	 */
	public $validator;

	/**
	 * The recommended response to send to the client.
	 *
	 * @var \Symfony\Component\HttpFoundation\Response|null
	 */
	public $response;

	/**
	 * The status code to use for the response.
	 *
	 * @var int
	 */
	public $status = Response::HTTP_UNPROCESSABLE_ENTITY;

	/**
	 * The name of the error bag.
	 *
	 * @var string
	 */
	public $errorBag;

	/**
	 * The path the client should be redirected to.
	 *
	 * @var string
	 */
	public $redirectTo;

	/**
	 * Create a new exception instance.
	 *
	 * @param  \Illuminate\Contracts\Validation\Validator  $validator
	 * @param  \Symfony\Component\HttpFoundation\Response  $response
	 * @param  string  $errorBag
	 * @return void
	 */
	public function __construct($validator, $response = null, $errorBag = 'default')
	{
		parent::__construct(__('The request failed to pass validation.'));

		$this->response = $response;
		$this->errorBag = $errorBag;
		$this->validator = $validator;
	}

	public static function withMessage(string $message){
		return static::withMessages([$message]);
	}

	/**
	 * Create a new validation exception from a plain array of messages.
	 *
	 * @param  array  $messages
	 * @return static
	 */
	public static function withMessages(array $messages)
	{
		return new static(tap(ValidatorFacade::make([], []), function (Validator $validator) use ($messages) {
			foreach ($messages as $key => $value) {
				foreach (Arr::wrap($value) as $message) {
					$validator->errors()->add($key, $message);
				}
			}
		}));
	}

	/**
	 * Get a single validation error message or the exception message.
	 *
	 * @return string
	 */
	public function errorMessage()
	{
		if ($this->hasValidationMessages()) {
			return $this->errorMessages()[0];
		}

		return $this->getMessage();
	}

	/**
	 * Get all error messages.
	 *
	 * @return array
	 */
	public function errorMessages()
	{
		return $this->validator->errors()->all();
	}

	/**
	 * Get all of the validation error messages.
	 *
	 * @return array
	 */
	public function errors()
	{
		return $this->validator->errors()->messages();
	}

	public function hasValidationMessages() {
		return $this->validator->errors()->isNotEmpty();
	}

	/**
	 * Set the HTTP status code to be used for the response.
	 *
	 * @param  int  $status
	 * @return $this
	 */
	public function status($status)
	{
		$this->status = $status;

		return $this;
	}

	/**
	 * Set the error bag on the exception.
	 *
	 * @param  string  $errorBag
	 * @return $this
	 */
	public function errorBag($errorBag)
	{
		$this->errorBag = $errorBag;

		return $this;
	}

	/**
	 * Set the URL to redirect to on a validation error.
	 *
	 * @param  string  $url
	 * @return $this
	 */
	public function redirectTo($url)
	{
		$this->redirectTo = $url;

		return $this;
	}

	/**
	 * Get the underlying response instance.
	 *
	 * @return \Symfony\Component\HttpFoundation\Response|null
	 */
	public function getResponse()
	{
		return $this->response;
	}

}