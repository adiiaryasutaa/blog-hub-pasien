<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * @inheritDoc
	 */
	protected function prepareForValidation()
	{
		$this->merge([
			'categories' => str($this->get('categories'))->replace(', ', ',')->explode(',')->toArray(),
			'archived' => $this->boolean('archived'),
		]);
	}


	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules()
	{
		return [
			'thumbnail' => ['required', 'mimes:svg,png,jpg,jpeg'],
			'title' => ['required', 'min:10', 'max:100'],
			'content' => ['required', 'min:400'],
			'categories' => ['nullable', 'array'],
			'categories.*' => ['nullable', 'string', 'min:2', 'max:50'],
			'archived' => ['nullable', 'boolean'],
		];
	}
}
