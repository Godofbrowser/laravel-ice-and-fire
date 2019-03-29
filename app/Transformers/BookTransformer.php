<?php
/**
 * Created by PhpStorm.
 * User: Ajeh Emeke
 * Date: 3/28/2019
 * Time: 9:00 PM
 */

namespace App\Transformers;


use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class BookTransformer extends AbstractTransformer
{
	protected static function transform(array $data): array
	{
		return [
			'id' => $data['id'],
			'name' => $data['name'],
			'isbn' => $data['isbn'],
			'authors' => static::transformAuthors($data['authors'] ?? []),
			'country' => $data['country'],
			'number_of_pages' => $data['number_of_pages'],
			'publisher' => static ::transformPublisher($data['publisher'] ?? null),
			'release_date' => Carbon::parse($data['release_date'])->format('Y-m-d'),
		];
	}

	private static function transformAuthors(array $data) {
		if (!isset($data[0])) return [];
		return Collection::make($data)->pluck('name')->toArray();
	}

	private static function transformPublisher(array $data = null) {
		if (!$data) return '';
		return $data['name'];
	}
}
