<?php
/**
 * Created by PhpStorm.
 * User: Ajeh Emeke
 * Date: 3/28/2019
 * Time: 9:38 PM
 */

namespace App\Transformers;


use Illuminate\Support\Collection;

abstract class AbstractTransformer
{
	abstract protected static function transform(array $data): array;

	public static final function model(array $data) {
		return static::transform($data);
	}

	public static final function collection(array $data): array {
		return Collection::make($data)->map(function(array $item) {
			return self::model($item);
		})->toArray();
	}
}