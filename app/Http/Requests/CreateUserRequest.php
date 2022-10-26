<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return auth()->user()->isOwner();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules()
	{
		return [
			'avatar' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,svg'],
			'name' => ['required', 'string', 'max:255'],
			'username' => ['required', 'string', 'min:6', 'max:20'],
			'email' => ['required', 'string', 'email', 'max:255'],
			'password' => ['required', 'string', 'min:6', 'max:20'],
			'role' => ['required', 'int'],
		];
	}
}
