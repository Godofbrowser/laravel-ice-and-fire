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

interface RepositoryWriteContract
{
	public function create(User $user = null, array $data): Model;
	public function update(User $user = null, Model $model, array $data): Model;
	public function delete(User $user = null, Model $model): bool;
}