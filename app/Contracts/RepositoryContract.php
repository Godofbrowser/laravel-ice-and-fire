<?php
/**
 * Created by PhpStorm.
 * User: Ajeh Emeke
 * Date: 3/29/2019
 * Time: 2:42 AM
 */

namespace App\Contracts;


use Illuminate\Database\Eloquent\Model;

interface RepositoryContract
{
	public static function resourceCreateRule();
	public static function resourceUpdateRule(Model $model);
}