<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Author;
use App\Models\Publisher;
use App\Repositories\AuthorRepo;
use App\Repositories\BookRepo;
use App\Repositories\Contracts\BookRepoContract;
use App\Transformers\BookTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class BookController extends Controller
{
	/**
	 * @var \App\Repositories\Contracts\BookRepoContract
	 */
	private $bookRepo;

	/**
	 * BookController constructor.
	 *
	 * @param \App\Repositories\Contracts\BookRepoContract $bookRepo
	 */
	public function __construct(BookRepoContract $bookRepo)
	{
		$this->bookRepo = $bookRepo;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$books = $this->bookRepo
			->getQuery()
			->with('authors', 'publisher')
			->paginate(24)
			->toArray();

		$books['data'] = BookTransformer::collection($books['data']);

		return $this->xhrResponse()->createSuccess([
			'book' => $books['data']
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$user = $request->user();

		// Validate entire payload
		$data = $this->validateXhrRequest($request, BookRepo::resourceCreateRule());

		// Validate Authors array
		$data['authors'] = collect($data['authors'])->map(function ($item, $idx) {
			$nth = ordinal_number($idx + 1);
			return $this->validateXhrRequest(
				['name' => $item],
				['name' => 'required|string'],
				[],
				['name' => $nth . ' author\'s name']
			);
		})->toArray();

		// Get publisher's model id
		$data['publisher_id'] = Publisher::query()->firstOrCreate([
			'name' => $data['publisher']
		])->getKey();

		// Get authors model ids
		$data['author_ids'] = Collection::make($data['authors'])
			->map(function ($item) {
				return Author::query()->firstOrCreate([
					'name' => $item['name']
				])->getKey();
			});

		$book = $this->bookRepo->create($user, $data);
		$book->load('authors', 'publisher');

		return $this->xhrResponse()->createSuccess([
			'book' => BookTransformer::model($book->toArray())
		]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}
}
