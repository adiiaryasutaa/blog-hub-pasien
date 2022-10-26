<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class SimilarBlog extends Model
{
	use HasFactory;

	protected $fillable = [
		'blog_id',
		'similar_with_id',
	];
}
