@props([
  'id' => '',
	'label' => '',
	'showError' => true,
])

<div>
	<div class="flex flex-col space-y-2">
		@if(str($label)->isNotEmpty())
			<div class="text-sm font-medium text-slate-600">{{ $label }}</div>
		@endif

		<input id="{{ $id }}" {{ $attributes }} type="hidden">

		<trix-editor
			class="border border-slate-300 rounded text-sm space-y-4 px-4 py-2.5 placeholder:text-slate-200 focus:outline-0 focus:ring focus:ring-blue-300 disabled:bg-white disabled:border-slate-100 disabled:text-slate-400"
			input="{{ $id }}"
		></trix-editor>

		@if($showError)
			<div class="text-sm font-medium text-red-600">{{ $errors->first($attributes->get('name')) }}</div>
		@endif
	</div>
</div>
