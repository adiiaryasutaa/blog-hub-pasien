<button
	{{ $attributes->merge(['class' => 'text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5']) }}>
	{{ $slot }}
</button>
