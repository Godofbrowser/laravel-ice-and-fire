<?php
/**
 * Created by PhpStorm.
 * User: Ajeh Emeke
 * Date: 3/30/2019
 * Time: 10:48 AM
 */

namespace App\Contracts;


use Illuminate\Database\Eloquent\Model;

interface RepositoryValidationContract
{
	public static function resourceCreateRule();
	public static function resourceUpdateRule(Model $model);
}