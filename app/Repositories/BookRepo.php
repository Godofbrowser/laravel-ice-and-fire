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
			'name' => 'required',
			'isbn' => "required|string|regex:/\d{3}\-\d{10}/unique:books,isbn,{$isbn}",
			'country' => 'required',
			'number_of_pages' => 'required',
			'publisher' => 'required',
			'release_date' => 'required',
			'authors' => 'required|array'
		];
	}

	public function create(User $user = null, array $data): Book {
		$authorIds = $data['author_ids'];

		/** @var Book $book */
		$book = $this->getQuery()->create($data);
		$book->authors()->sync($authorIds);

		return $book;
	}

	public function update(User $user = null, array $data): Book
	{
		// TODO: Implement update() method.
	}

	public function delete(User $user = null, Book $model): bool
	{
		// TODO: Implement delete() method.
	}
}