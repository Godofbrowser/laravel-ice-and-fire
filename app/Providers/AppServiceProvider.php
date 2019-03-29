<?php

namespace App\Providers;

use App\Repositories\AuthorRepo;
use App\Repositories\BookRepo;
use App\Repositories\Contracts\AuthorRepoContract;
use App\Repositories\Contracts\BookRepoContract;
use App\Repositories\Contracts\PublisherRepoContract;
use App\Repositories\PublisherRepo;
use App\Services\IceAndFire\IceAndFireServiceProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(IceAndFireServiceProvider::class);
		$this->registerModelRepositories();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

	private function registerModelRepositories()
	{
		$this->app->bind(BookRepoContract::class, BookRepo::class);
		$this->app->bind(AuthorRepoContract::class, AuthorRepo::class);
		$this->app->bind(PublisherRepoContract::class, PublisherRepo::class);
	}
}
