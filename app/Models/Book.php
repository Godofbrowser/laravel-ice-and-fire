<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
		'name',
		'isbn',
		'country',
		'number_of_pages',
		'publisher_id',
		'release_date',
	];

    protected $hidden = [
		'publisher_id',
	];

    public function authors() {
    	return $this->belongsToMany(
    		Author::class,
			'book_author',
			'book_id',
			'author_id'
		);
	}

    public function publisher() {
    	return $this->belongsTo(Publisher::class);
	}
}
