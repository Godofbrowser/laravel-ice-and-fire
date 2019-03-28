<?php
/**
 * Created by PhpStorm.
 * User: Ajeh Emeke
 * Date: 3/28/2019
 * Time: 6:51 PM
 */

namespace App\Services\IceAndFire\Contracts;


interface IceAndFireContract
{
	public function findBooksByName(string $name = null, $page = 1, $page_size = 12): array;
	public function getAllBooks($page = 1, $page_size = 12): array;
}