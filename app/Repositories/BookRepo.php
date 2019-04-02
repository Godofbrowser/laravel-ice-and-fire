<?php
/**
 * Created by PhpStorm.
 * User: Ajeh Emeke
 * Date: 3/29/2019
 * Time: 12:46 AM
 */

namespace App\Repositories;


use App\Models\Book;
use App\Models\User;
use App\Repositories\Contracts\BookRepoContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class BookRepo extends AbstractRepository implements BookRepoContract
{
	function instantiateModel(): Model
	{
		return new Book();
	}

	public static function resourceCreateRule() {
		return [
			'name' => 'required|string',
			'isbn' => 'required|string|regex:/\d{3}\-\d{10}/|unique:books,isbn',
			'country' => 'required|string',
			'number_of_pages' => 'required|integer',
			'publisher' => 'required|string',
			'release_date' => 'required',
			'authors' => 'required|array'
		];
	}

	public static function resourceUpdateRule(Model $model) {
		$isbn = $model->getOriginal('isbn');
		return [
			'name' => 'nullable|string',
			'isbn' => "nullable|string|regex:/\d{3}\-\d{10}/|unique:books,isbn,{$isbn}",
			'country' => 'nullable|string',
			'number_of_pages' => 'nullable|integer',
			'publisher' => 'nullable|string',
			'release_date' => 'nullable',
			'authors' => 'nullable|array'
		];
	}

	public function create(User $user = null, array $data): Model {
		$authorIds = $data['author_ids'];

		/** @var Book $book */
		$book = $this->getQuery()->create($data);
		$book->authors()->sync($authorIds);

		return $book;
	}

	public function update(User $user = null, Model $model, array $data): Model
	{
		$authorIds = Arr::get($data, 'author_ids', null);

		/** @var Book $book */
		$book = $model->fill($data);

		if (!is_null($authorIds))
			$book->authors()->sync($authorIds);

		return $book;
	}

	public function delete(User $user = null, Model $model): bool
	{
		if (!$model->exists) return false;
		return $model->delete() ?? false;
	}

	public function findById(int $id, $firstOrFail = false): Model {
		/** @var Book $model */
		$model = $this->getQuery()->whereKey($id)->firstOrFail();
		return $model;
	}

	public function firstOrCreate(User $user = null, array $data): Model
	{
		/** @var Book $model */
		$model = $this->getQuery()->where($data)->first();

		if (!$model)
			$model = $this->create($user, $data);

		return $model;
	}
}