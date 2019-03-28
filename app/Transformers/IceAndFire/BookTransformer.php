<?php
/**
 * Created by PhpStorm.
 * User: Ajeh Emeke
 * Date: 3/28/2019
 * Time: 9:00 PM
 */

namespace App\Transformers\IceAndFire;


use App\Transformers\AbstractTransformer;
use Illuminate\Support\Carbon;

class BookTransformer extends AbstractTransformer
{
	protected static function transform(array $data): array
	{
		return [
			'name' => $data['name'],
			'isbn' => $data['isbn'],
			'authors' => $data['authors'],
			'country' => $data['country'],
			'number_of_pages' => $data['numberOfPages'],
			'publisher' => $data['publisher'],
			'release_date' => Carbon::parse($data['released'])->format('Y-m-d'),
		];
	}
}
