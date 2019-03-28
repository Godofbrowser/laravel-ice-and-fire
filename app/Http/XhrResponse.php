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
	const DEFAULT_SUCCESS_MESSAGE_SAVE = 'Success! Data saved successfully';

	const DEFAULT_ERROR_MESSAGE = 'Error! Request not completed';

	public static function fetchSuccess(array $data = []) {
		return static::success(self::DEFAULT_SUCCESS_MESSAGE_FETCH, $data);
	}

	public static function saveSuccess(array $data = []) {
		return static::success(self::DEFAULT_SUCCESS_MESSAGE_SAVE, $data);
	}

	public static function requestSuccess(array $data = []) {
		return static::success(self::DEFAULT_SUCCESS_MESSAGE, $data);
	}

	public static function success(string $message, array $data = []) {
		return response()->json([
			'status' => 'success',
			'info' => $message,
			'data' => $data
		]);
	}

	public static function error(string $message = null, array $errors = []) {
		return response()->json([
			'status' => 'error',
			'error' => $message || static::DEFAULT_ERROR_MESSAGE,
			'errors' => $errors
		], Response::HTTP_UNPROCESSABLE_ENTITY);
	}
}