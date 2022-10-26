@props([
  'name' => '',
  'message' => '',
  'action' => ['name' => '', 'path' => '#'],
  'type' => 'info',
])

<div @class([
  'flex items-start p-4 text-sm rounded w-full',
  'text-blue-700 bg-blue-100' => $type === 'info',
  'text-red-700 bg-red-100' => $type === 'error',
  'text-green-700 bg-green-100' => $type === 'success',
  'text-yellow-700 bg-yellow-100' => $type === 'warning',
]) role="alert">
	<x-icon.info class="inline mr-3 w-5 h-5"/>
	<div class="space">
		@if(str($name)->isNotEmpty())
			<span class="font-bold">{{ $name }}</span>
		@endif
		<span>
			@if(str($message)->isNotEmpty())
				{{ $message }}
			@endif
			@if(str(\Illuminate\Support\Arr::get($action, 'name', ''))->isNotEmpty())
				<a
					href="{{ $action['path'] ?? '#' }}"
					class="underline underline-offset-2 hover:text-blue-600 active:text-blue-700 focus:text-blue-800"
				>{{ $action['name'] }}</a>
			@endif
		</span>
	</div>
</div>
