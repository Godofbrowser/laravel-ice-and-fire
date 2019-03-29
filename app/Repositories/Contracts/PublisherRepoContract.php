<?php
/**
 * Created by PhpStorm.
 * User: Ajeh Emeke
 * Date: 3/29/2019
 * Time: 11:05 AM
 */

namespace App\Repositories\Contracts;


use App\Models\Publisher;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

interface PublisherRepoContract
{
	public function getQuery(): Builder;
	public function create(User $user = null, array $data): Publisher;
	public function firstOrCreate(User $user = null, array $data): Publisher;
	public function update(User $user = null, array $data): Publisher;
	public function delete(User $user = null, Publisher $model): bool;
	public function findById(int $id): Publisher;
}