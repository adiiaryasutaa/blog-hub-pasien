@props([
	'status',
])

<span @class([
  'rounded font-bold',
  'text-red-600' => $status === \App\Enums\BlogStatus::DELETED,
  'text-yellow-600' => $status === \App\Enums\BlogStatus::ARCHIVED,
  'text-green-600' => $status === \App\Enums\BlogStatus::PUBLISHED,
])>
	{{ str($status->name)->title() }}
</span>
