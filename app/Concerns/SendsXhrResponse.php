<?php
/**
 * Created by PhpStorm.
 * User: Ajeh Emeke
 * Date: 3/29/2019
 * Time: 1:01 AM
 */

namespace App\Concerns;


use App\Http\XhrResponse;

trait SendsXhrResponse
{
	public function xhrResponse() {
		return new XhrResponse();
	}
}