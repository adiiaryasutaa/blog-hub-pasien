@props([
	'showError' => true,
	'error' => null,
	'label' => '',
])

<div class="w-full">
	<label>
		<div class="flex flex-col space-y-2">
			@if(str($label)->isNotEmpty())
				<div class="text-sm font-medium text-slate-600">{{ $label }}</div>
			@endif

			<input {{ $attributes->merge(['class' => 'border border-slate-300 rounded text-sm px-4 py-2.5 placeholder:text-slate-300 focus:outline-0 focus:ring focus:ring-blue-300 disabled:bg-white disabled:border-slate-100 disabled:text-slate-400']) }}>

			@if($showError)
				<div class="text-sm font-medium text-red-600">{{ $error ?? $errors->first($attributes->get('name')) }}</div>
			@endif
		</div>
	</label>
</div>
