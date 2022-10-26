@props(['active' => false])

<a
	{{ $attributes->except('active') }}

	@class([
  'flex items-center p-2 text-sm font-medium rounded',
  'bg-blue-600 text-white' => $active,
  'text-slate-500 hover:bg-blue-600 hover:text-white active:bg-blue-700' => !$active
])
>
	{{ $slot }}
</a>
