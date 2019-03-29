<?php
/**
 * Created by PhpStorm.
 * User: Ajeh Emeke
 * Date: 3/29/2019
 * Time: 11:04 AM
 */

namespace App\Repositories\Contracts;


use App\Models\Author;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

interface AuthorRepoContract
{
	public function getQuery(): Builder;
	public function create(User $user = null, array $data): Author;
	public function firstOrCreate(User $user = null, array $data): Author;
	public function update(User $user = null, array $data): Author;
	public function delete(User $user = null, Author $model): bool;
	public function findById(int $id): Author;
}