@props([
	'color' => 'blue'
])

<button
	{{ $attributes->merge(['class' => "inline-flex items-center text-slate-600 font-medium rounded text-sm px-2 py-1 hover:text-$color-600 hover:underline hover:underline-offset-2 focus:text-$color-600 focus:underline focus:underline-offset-2"]) }}
>
	{{ $slot }}
</button>
