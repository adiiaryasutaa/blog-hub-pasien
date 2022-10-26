<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return auth()->user()->is($this->user());
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules()
	{
		return [
			'name' => ['nullable', 'string', 'max:255'],
			'username' => ['nullable', 'string', 'max:20', Rule::unique('users', 'username')->ignoreModel($this->user())],
			'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignoreModel($this->user())],
		];
	}
}
