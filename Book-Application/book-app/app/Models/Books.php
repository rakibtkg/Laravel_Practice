<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
	protected $table = 'books';
	protected $fillable = [
        'id',
		'title',
		'author',
		'published_date',
		'genre',
	];

	protected $casts = [
		'id' => 'integer',
        'title' => 'string',
        'author' => 'string',
		'published_date' => 'date',
		'genre' => 'string',
	];
}

