<?php

namespace App\Http\Controllers\Api\V1;

use App\Repositories\BookRepo;
use App\Repositories\Contracts\AuthorRepoContract;
use App\Repositories\Contracts\BookRepoContract;
use App\Repositories\Contracts\PublisherRepoContract;
use App\Transformers\BookTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class BookController extends Controller
{
	/**
	 * @var \App\Repositories\Contracts\BookRepoContract
	 */
	private $bookRepo;
	/**
	 * @var \App\Repositories\Contracts\AuthorRepoContract
	 */
	private $authorRepo;
	/**
	 * @var \App\Repositories\Contracts\PublisherRepoContract
	 */
	private $publisherRepo;

	/**
	 * BookController constructor.
	 *
	 * @param \App\Repositories\Contracts\BookRepoContract $bookRepo
	 * @param \App\Repositories\Contracts\AuthorRepoContract $authorRepo
	 * @param \App\Repositories\Contracts\PublisherRepoContract $publisherRepo
	 */
	public function __construct(
		BookRepoContract $bookRepo,
		AuthorRepoContract $authorRepo,
		PublisherRepoContract $publisherRepo
	)
	{
		$this->bookRepo = $bookRepo;
		$this->authorRepo = $authorRepo;
		$this->publisherRepo = $publisherRepo;
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
		$data['publisher_id'] = $this->publisherRepo
			->firstOrCreate($user, [
				'name' => $data['publisher']
			])->getKey();

		// Get authors model ids
		$data['author_ids'] = Collection::make($data['authors'])
			->map(function ($item) use ($user) {
				return $this->authorRepo
					->firstOrCreate($user, [
						'name' => $item['name']
					])->getKey();
			});

		$book = $this->bookRepo->create($user, $data);
		$book->load('authors', 'publisher');
		$jsonData = BookTransformer::model($book->toArray());

		unset($jsonData['id']);

		return $this->xhrResponse()->createSuccess([
			'book' => $jsonData
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
		$book = $this->bookRepo->findById($id);
		$book->load('authors', 'publisher');
		$jsonData = BookTransformer::model($book->toArray());

		return $this->xhrResponse()->fetchSuccess($jsonData);
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
		$book = $this->bookRepo->findById($id);
		$bookName = $book->getAttributeValue('name');

		$this->bookRepo->delete(null, $book);

		$message = sprintf('The book %s was deleted successfully', $bookName);
		return $this->xhrResponse()->success($message, [], Response::HTTP_NO_CONTENT);
	}
}
