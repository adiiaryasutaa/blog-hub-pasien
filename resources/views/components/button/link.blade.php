<a
	{{ $attributes->merge(['class' => 'inline-flex items-center text-slate-600 font-medium rounded text-sm px-2 py-1 hover:text-blue-600 hover:underline hover:underline-offset-2 focus:text-blue-600 focus:underline focus:underline-offset-2']) }}
	type="_button"
>
	{{ $slot }}
</a>
