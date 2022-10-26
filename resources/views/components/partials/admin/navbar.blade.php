@props([
	'title' => '',
	'actions' => ''
])

<div class="fixed w-screen h-16 bg-white z-20">
	<div class="flex justify-between items-center pl-72 py-4 pr-8">
		<h1 class="text-lg font-medium text-slate-700">{{ $title }}</h1>
		{{ $actions }}
	</div>
</div>
