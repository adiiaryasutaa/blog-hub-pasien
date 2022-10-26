<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Model;
use Str;

class User extends Model
{
	use HasFactory;

	protected $hidden = [
		'password'
	];

	protected $guarded = [
		'id'
	];

	public function blogs(): HasMany
	{
		return $this->hasMany(Blog::class);
	}

	public function role(): string
	{
		return Str::title(UserRole::from($this->role)->name);
	}

	public function isOwner(): bool
	{
		return $this->role === UserRole::OWNER->value;
	}

	public function isAdmin(): bool
	{
		return $this->role === UserRole::ADMIN->value;
	}

	public function isNormal(): bool
	{
		return $this->role === UserRole::NORMAL->value;
	}
}
