<?php

namespace Tests\Feature;

use App\Services\IceAndFire\ApiService;
use App\Services\IceAndFire\Contracts\IceAndFireContract;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Response as HttpResponse;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IceAndFireApiTest extends TestCase
{
	public $mockHandler;

	protected function setUp(): void
	{
		parent::setUp();

		$this->mockHandler = new MockHandler();

		$this->app->bind(IceAndFireContract::class, function() {
			$httpClient = new Client([
				'handler' => $this->mockHandler,
			]);

			return new ApiService($httpClient);
		});
	}

	/**
     * A basic feature test example.
     *
     * @return void
     */
    public function testItRetrievesBookByName()
    {
		$this->mockHandler->append(new Response(
			200,
			[],
			file_get_contents(storage_path('/data/bookByName.json'))
		));

        $response = $this->json('GET','/api/external-books', [
        	'name' => 'A Game of Thrones'
		]);

        $response
			->assertStatus(HttpResponse::HTTP_OK)
			->assertJson([
				'status' => 'success',
				'data' => [[
					'name' => 'A Game of Thrones'
				]]
			]);

		$response->assertJsonMissing([
			'data' => [[
				'name' => 'A Storm of Swords'
			]]
		]);
    }
}
