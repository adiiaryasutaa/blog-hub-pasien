<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewedBlog extends Model
{
	use HasFactory;

	protected $fillable = ['blog_id'];

	public $timestamps = false;
}
