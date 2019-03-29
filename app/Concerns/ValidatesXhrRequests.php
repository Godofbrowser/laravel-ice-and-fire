<?php
/**
 * Created by PhpStorm.
 * User: Ajeh Emeke
 * Date: 3/29/2019
 * Time: 1:41 AM
 */

namespace App\Concerns;


use App\Exceptions\XhrException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Contracts\Validation\Factory;

trait ValidatesXhrRequests
{
	public function validateXhrRequest(
		$request,
		array $rules,
		array $messages = [],
		array $customAttributes = []
	)
	{
		$requestData = $request instanceof Request ? $request->all() : $request;

		$v = $this->getXhrValidationFactory()
			->make($requestData, $rules, $messages, $customAttributes);

		if ($v->fails()) {
			throw XhrException::failedToPassValidation($v);
		}

		return $this->extractInputFromRulesOnArray($requestData, $rules);
	}


	/**
	 * Get the request input based on the given validation rules.
	 *
	 * @param array $data
	 * @param  array $rules
	 *
	 * @return array
	 */
	protected function extractInputFromRulesOnArray(array $data, array $rules)
	{
		return Arr::only($data, collect($rules)->keys()->map(function ($rule) {
			return explode('.', $rule)[0];
		})->unique()->toArray());
	}

	/**
	 * Get a validation factory instance.
	 *
	 * @return \Illuminate\Contracts\Validation\Factory
	 */
	protected function getXhrValidationFactory()
	{
		return app(Factory::class);
	}
}