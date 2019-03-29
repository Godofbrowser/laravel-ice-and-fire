<?php
/**
 * Created by PhpStorm.
 * User: Ajeh Emeke
 * Date: 3/28/2019
 * Time: 10:18 PM
 */

namespace App\Http;


use Illuminate\Http\Response;

class XhrResponse
{
	const DEFAULT_SUCCESS_MESSAGE = 'Success! Request successful';
	const DEFAULT_SUCCESS_MESSAGE_FETCH = 'Success! Data retrieved successfully';
	const DEFAULT_SUCCESS_MESSAGE_CREATE = 'Success! Resource created successfully';
	const DEFAULT_SUCCESS_MESSAGE_SAVE = 'Success! Data saved successfully';

	const DEFAULT_ERROR_MESSAGE = 'Error! Request not completed';

	public static function fetchSuccess(array $data = [], int $statusCode = null) {
		return static::success(self::DEFAULT_SUCCESS_MESSAGE_FETCH, $data, $statusCode);
	}

	public static function createSuccess(array $data = [], int $statusCode = Response::HTTP_CREATED) {
		return static::success(self::DEFAULT_SUCCESS_MESSAGE_SAVE, $data, $statusCode);
	}

	public static function saveSuccess(array $data = [], int $statusCode = null) {
		return static::success(self::DEFAULT_SUCCESS_MESSAGE_SAVE, $data, $statusCode);
	}

	public static function requestSuccess(array $data = [], int $statusCode = null) {
		return static::success(self::DEFAULT_SUCCESS_MESSAGE, $data, $statusCode);
	}

	public static function success(string $message, array $data = [], int $statusCode = null) {
		return response()->json([
			'status' => 'success',
			'message' => $message,
			'data' => $data
		], $statusCode ?? Response::HTTP_OK);
	}

	public static function error(string $message = null, array $errors = [], int $statusCode = null) {
		return response()->json([
			'status' => 'error',
			'error' => $message ?? static::DEFAULT_ERROR_MESSAGE,
			'errors' => $errors
		], $statusCode ?? Response::HTTP_UNPROCESSABLE_ENTITY);
	}
}