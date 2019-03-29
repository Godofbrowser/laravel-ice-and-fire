<?php
/**
 * Created by PhpStorm.
 * User: Ajeh Emeke
 * Date: 3/29/2019
 * Time: 12:46 AM
 */

namespace App\Repositories;


use App\Models\Author;
use App\Models\User;
use App\Repositories\Contracts\AuthorRepoContract;
use Illuminate\Database\Eloquent\Model;

class AuthorRepo extends AbstractRepository implements AuthorRepoContract
{
	function instantiateModel(): Model
	{
		return new Author();
	}

	public static function resourceCreateRule() {
		return [
			'name' => 'required|string|unique:authors',
		];
	}

	public static function resourceUpdateRule(Model $model) {
		return [
			'name' => 'required|string|unique:authors,name,' . $model->getOriginal('name'),
		];
	}

	public function create(User $user = null, array $data): Author {
		/** @var Author $model */
		$model =  $this->getQuery()->create($data);
		return $model;
	}

	public function firstOrCreate(User $user = null, array $data): Author
	{
		/** @var Author $model */
		$model = $this->getQuery()->where($data)->first();

		if (!$model)
			$model = $this->create($user, $data);

		return $model;
	}

	public function update(User $user = null, array $data): Author
	{
		// TODO: Implement update() method.
	}

	public function delete(User $user = null, Author $model): bool
	{
		// TODO: Implement delete() method.
	}

	public function findById(int $id): Author
	{
		// TODO: Implement findById() method.
	}
}