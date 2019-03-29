<?php
/**
 * Created by PhpStorm.
 * User: Ajeh Emeke
 * Date: 3/29/2019
 * Time: 12:46 AM
 */

namespace App\Repositories;


use App\Models\Publisher;
use Illuminate\Database\Eloquent\Model;

class PublisherRepo extends AbstractRepository
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
}