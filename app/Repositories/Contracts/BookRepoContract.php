<?php
/**
 * Created by PhpStorm.
 * User: Ajeh Emeke
 * Date: 3/29/2019
 * Time: 2:46 AM
 */

namespace App\Repositories\Contracts;


use App\Models\Book;
use App\Models\User;

interface BookRepoContract
{
	public function create(User $user = null, array $data): Book;
	public function update(User $user = null, array $data): Book;
	public function delete(User $user = null, Book $model): bool;
}