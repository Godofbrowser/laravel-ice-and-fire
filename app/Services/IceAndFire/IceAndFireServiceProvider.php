<?php

namespace App\Services\IceAndFire;

use App\Services\IceAndFire\Contracts\IceAndFireContract;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class IceAndFireServiceProvider extends ServiceProvider
{
	const API_BASE = 'https://www.anapioficeandfire.com/api/';

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(IceAndFireContract::class, function() {
			$httpClient = new Client([
				// Base URI is used with relative requests
				'base_uri' => self::API_BASE,
			]);
        	return new ApiService($httpClient);
		});
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
