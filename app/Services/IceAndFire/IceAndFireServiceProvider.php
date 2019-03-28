<?php

namespace App\Services\IceAndFire;

use App\Services\IceAndFire\Contracts\IceAndFireContract;
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
        $this->app->bind(IceAndFireContract::class, function() {
        	return new ApiService(self::API_BASE);
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
