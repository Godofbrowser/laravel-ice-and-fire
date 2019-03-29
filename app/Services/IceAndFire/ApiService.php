<?php
/**
 * Created by PhpStorm.
 * User: Ajeh Emeke
 * Date: 3/28/2019
 * Time: 6:50 PM
 */

namespace App\Services\IceAndFire;


use App\Services\IceAndFire\Contracts\IceAndFireContract;
use App\Services\IceAndFire\Exceptions\ApiException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

class ApiService implements IceAndFireContract
{
	const REQUEST_TYPE_GET = 'get';
	const REQUEST_TYPE_POST = 'post';

	private $client;

	/**
	 * IceAndFireService constructor.
	 *
	 * @param \GuzzleHttp\Client $client
	 *
	 */
	public function __construct(Client $client)
	{
		$this->client = $client;
	}

	private function makeRequest($type, $endpoint, $options = [])
	{
		try {
			/** @var \GuzzleHttp\Psr7\Response $response_raw */
			$response_raw = $this->client->{$type}($endpoint, $options);
			return json_decode($response_raw->getBody()->getContents(), true);
		} catch (BadResponseException $exception) {
			$message = $exception->getMessage();
			throw new ApiException($message);
		}
	}

	public function findBooksByName(string $name = null, $page = 1, $page_size = 12): array
	{
		$endpoint = 'books';
		$query = [
			'page' => $page,
			'pageSize' => $page_size,
		];

		if ($name) $query['name'] = $name;

		return $this->makeRequest(
			self::REQUEST_TYPE_GET,
			$endpoint,
			['query' => $query]
		);
	}

	public function getAllBooks($page = 1, $page_size = 12): array
	{
		return $this->findBooksByName(null, $page = 1, $page_size = 12);
	}
}
