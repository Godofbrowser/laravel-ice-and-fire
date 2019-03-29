<?php

namespace App\Http\Controllers\Api\Services;

use App\Services\IceAndFire\Contracts\IceAndFireContract;
use App\Transformers\IceAndFire\BookTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IceAndFireController extends Controller
{
	/**
	 * @var \App\Services\IceAndFire\Contracts\IceAndFireContract
	 */
	private $iceAndFireService;

	/**
	 * IceAndFireController constructor.
	 *
	 * @param \App\Services\IceAndFire\Contracts\IceAndFireContract $iceAndFireService
	 */
	public function __construct(IceAndFireContract $iceAndFireService)
	{
		$this->iceAndFireService = $iceAndFireService;
	}

	public function getBook(Request $request) {
    	$book_name = $request->input('book');
    	$page = $request->input('page');
    	$page_size = $request->input('per_page');

		$books = $this->iceAndFireService->findBooksByName($book_name, $page, $page_size);
		$books = BookTransformer::collection($books);

		return $this->xhrResponse()->fetchSuccess($books);
	}
}
