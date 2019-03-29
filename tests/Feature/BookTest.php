<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase
{
	use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCanCreateBook()
    {
    	$bookData = json_decode('{
			"name":"My first Book",
			"isbn":"123-3213243567",
			"country":"United States",
			"number_of_pages":"337",
			"publisher":"Acme Books",
			"release_date":"2019-08-01",
			"authors": ["John Doe"]
		}', true);

    	$response = $this->json(
    		'POST',
			'/api/v1/books',
			$bookData
		);

		$this->assertDatabaseHas('publishers', [
			'name' => 'Acme Books'
		]);

		$this->assertDatabaseHas('authors', [
			'name' => 'John Doe'
		]);

		$this->assertDatabaseHas('books', [
			'name' => 'My first Book'
		]);

		$response
			->assertStatus(Response::HTTP_CREATED)
			->assertJson([
				'status' => 'success',
			]);
    }

    public function testCanDeleteBook() {
		/** @var Book $book */
		$book = factory(Book::class)->create();
		$book->authors()->sync(factory(Author::class, 2)->create());

		$response = $this->json(
			'DELETE',
			'/api/v1/books/'. $book->id
		);

		$response
			->assertStatus(Response::HTTP_NO_CONTENT);
	}
}
