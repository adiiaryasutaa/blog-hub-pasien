@props([
	'showError' => true,
	'label' => '',
])

<div>
	<label class="cursor-pointer">
		<div class="flex flex-col space-y-2">
			<div class="flex items-center">
				<input type="checkbox" {{ $attributes->merge(['class' => 'w-4 h-4 focus:ring focus:ring-blue-300']) }}>
				<div class="text-sm font-medium text-slate-600 ml-2 select-none">{{ $label }}</div>
			</div>
		</div>
	</label>
</div>
