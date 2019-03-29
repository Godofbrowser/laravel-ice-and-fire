<?php
/**
 * Created by PhpStorm.
 * User: Ajeh Emeke
 * Date: 3/29/2019
 * Time: 12:47 AM
 */

namespace App\Repositories;


use App\Contracts\RepositoryContract;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository implements RepositoryContract
{
	abstract public function instantiateModel(): Model;

	public final function getQuery() {
		return $this->instantiateModel()->query();
	}
}