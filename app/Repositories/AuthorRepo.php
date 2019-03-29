<?php
/**
 * Created by PhpStorm.
 * User: Ajeh Emeke
 * Date: 3/29/2019
 * Time: 12:46 AM
 */

namespace App\Repositories;


use App\Models\Author;
use Illuminate\Database\Eloquent\Model;

class AuthorRepo extends AbstractRepository
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
}