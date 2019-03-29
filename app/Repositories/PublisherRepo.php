<?php
/**
 * Created by PhpStorm.
 * User: Ajeh Emeke
 * Date: 3/29/2019
 * Time: 12:46 AM
 */

namespace App\Repositories;


use App\Models\Publisher;
use App\Models\User;
use App\Repositories\Contracts\PublisherRepoContract;
use Illuminate\Database\Eloquent\Model;

class PublisherRepo extends AbstractRepository implements PublisherRepoContract
{
	function instantiateModel(): Model
	{
		return new Publisher();
	}

	public static function resourceCreateRule() {
		return [
			'name' => 'required|string|unique:publishers,name',
		];
	}

	public static function resourceUpdateRule(Model $model) {
		return [
			'name' => 'required|string|unique:publishers,name,' . $model->getOriginal('name'),
		];
	}

	public function create(User $user = null, array $data): Publisher {
		/** @var Publisher $model */
		$model =  $this->getQuery()->create($data);
		return $model;
	}

	public function firstOrCreate(User $user = null, array $data): Publisher
	{
		/** @var Publisher $model */
		$model = $this->getQuery()->where($data)->first();

		if (!$model)
			$model = $this->create($user, $data);

		return $model;
	}

	public function update(User $user = null, array $data): Publisher
	{
		// TODO: Implement update() method.
	}

	public function delete(User $user = null, Publisher $model): bool
	{
		// TODO: Implement delete() method.
	}

	public function findById(int $id): Publisher
	{
		// TODO: Implement findById() method.
	}
}