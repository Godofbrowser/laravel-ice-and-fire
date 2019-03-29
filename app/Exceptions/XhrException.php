<?php
/**
 * Created by PhpStorm.
 * User: Ajeh Emeke
 * Date: 3/29/2019
 * Time: 1:33 AM
 */

namespace App\Exceptions;


use Exception;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

class XhrException extends Exception
{
	protected $validator;

	public static function resourceNotFound() {
		return new static(
			'The requested resource was not found.',
			Response::HTTP_NOT_FOUND
		);
	}

	public static function modelNotFound($message = null) {
		return new static(
			$message ?? 'The requested item was not found.',
			Response::HTTP_NOT_FOUND
		);
	}

	public static function internalServerError($message = null) {
		return new static(
			$message ?? 'The server encountered an error while processing your request.',
			Response::HTTP_BAD_REQUEST
		);
	}

	public static function requestNotCompleted($message = null) {
		return new static(
			$message ?? 'An error occurred and the request could not be completed.',
			Response::HTTP_BAD_REQUEST
		);
	}

	public static function failedToPassValidation(Validator $validator) {
		$ex = new static(
			'The request failed to pass validation. Please check your input',
			Response::HTTP_BAD_REQUEST
		);

		$ex->setValidator($validator);
		return $ex;
	}

	public function hasValidator() {
		return !is_null($this->validator);
	}

	/**
	 * Get the errors as a single array
	 *
	 * @return array
	 */
	public function getValidationErrors() {
		return $this->getValidator()->errors()->all();
	}

	/**
	 * Get a list of (attribute => messages) errors
	 *
	 * @return array
	 */
	public function getValidationMessages() {
		return $this->getValidator()->errors()->messages();
	}

	/**
	 * @return Validator
	 */
	public function getValidator(): Validator
	{
		return $this->validator;
	}

	/**
	 * @param Validator $validator
	 */
	public function setValidator($validator)
	{
		$this->validator = $validator;
	}
}