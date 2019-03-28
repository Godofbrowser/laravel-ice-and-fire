<?php
/**
 * Created by PhpStorm.
 * User: Ajeh Emeke
 * Date: 3/28/2019
 * Time: 6:52 PM
 */

namespace App\Services\IceAndFire\Exceptions;


use Exception;
use Throwable;

class ApiException extends Exception
{
	private $apiMessage;
	const GENERIC_MESSAGE = 'The ice and fire api service encountered an error';
	const REQUEST_MESSAGE = 'The api request could not be completed';
	const RESPONSE_MESSAGE = 'An error occurred while processing the api response';

	/**
	 * ApiException constructor.
	 *
	 * @param string $message
	 * @param int $code
	 * @param \Throwable|null $previous
	 */
	public function __construct($message = self::GENERIC_MESSAGE, $code = 0, Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}

	static function RequestException($message) {
		$ex = new static();
		$ex->setApiMessage($message);
	}

	static function ResponseException($message) {
		$ex = new static();
		$ex->setApiMessage($message);
	}

	public function setApiMessage(string $message) {
		$this->apiMessage = $message;
		return $this;
	}

	public function getApiMessage() {
		return $this->apiMessage;
	}
}