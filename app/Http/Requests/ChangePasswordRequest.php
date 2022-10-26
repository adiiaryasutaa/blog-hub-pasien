<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
			'old-password' => ['required', 'current_password'],
			'new-password' => ['required', 'min:6', 'max:20'],
			'confirm-password' => ['required', 'same:new-password'],
		];
	}

	public function attributes()
	{
		return [
			'old-password' => __('Password lama'),
			'new-password' => __('Password baru'),
			'confirm-password' => __('Konfirmasi password')
		];
	}
}
