@props([
	'role' => \App\Enums\UserRole::NORMAL,
])

<span @class([
  'rounded font-bold',
  'text-red-600' => $role === \App\Enums\UserRole::OWNER,
  'text-yellow-600' => $role === \App\Enums\UserRole::ADMIN,
  'text-green-600' => $role === \App\Enums\UserRole::NORMAL,
])>
	{{ $role->name }}
</span>
