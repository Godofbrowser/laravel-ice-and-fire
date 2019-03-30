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

	public function create(User $user = null, array $data): Model {
		/** @var Publisher $model */
		$model =  $this->getQuery()->create($data);
		return $model;
	}

	public function firstOrCreate(User $user = null, array $data): Model
	{
		/** @var Publisher $model */
		$model = $this->getQuery()->where($data)->first();

		if (!$model)
			$model = $this->create($user, $data);

		return $model;
	}

	public function update(User $user = null, Model $model, array $data): Model
	{
		$model->fill($data)->save();
		return $model;
	}

	public function delete(User $user = null, Model $model): bool
	{
		if (!$model->exists) return false;
		return $model->delete() ?? false;
	}

	public function findById(int $id): Model
	{
		/** @var Publisher $model */
		$model = $this->getQuery()->whereKey($id)->firstOrFail();
		return $model;
	}
}