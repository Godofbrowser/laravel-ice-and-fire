<?php
/**
 * Created by PhpStorm.
 * User: Ajeh Emeke
 * Date: 3/30/2019
 * Time: 10:49 AM
 */

namespace App\Contracts;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;

interface RepositoryReadContract
{
	public function firstOrCreate(User $user = null, array $data): Model;

	public function findById(int $id): Model;
}