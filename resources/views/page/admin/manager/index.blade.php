@extends('layouts.index')

@section('title', 'Users')

@section('body')
	<x-partials.admin.navbar :title="__('Users')">
		<x-slot:actions>
			@can('create', \App\Models\User::class)
				<x-button.link href="{{ route('manager.user.create') }}">
					<x-icon.plus class="w-4 h-4"/>
					<span class="ml-2">{{ __('Register user') }}</span>
				</x-button.link>
			@endcan
		</x-slot:actions>
	</x-partials.admin.navbar>

	@include('partials.admin.sidebar', ['active' => 'manager'])

	<x-partials.admin.main class="font-montserrat pt-24 min-h-screen">

		<div class="mb-4 w-96">
			@if(session()->has('create-user-success'))
				<x-alert
					:name="session('create-user-success')"
					type="success"
				/>
			@endif

			@if(session()->has('delete-user-success'))
				<x-alert
					:name="session('delete-user-success')"
					type="success"
				/>
			@endif

			@error('delete-user-failed')
			<x-alert
				:name="$errors->first('delete-user-failed')"
				type="error"
			/>
			@enderror
		</div>

		<div class="overflow-x-auto">
			<table class="w-full text-sm">
				<thead class="text-xs text-slate-700 bg-slate-50 text-left">
				<tr>
					<th scope="col" class="py-3 px-6">
						{{ __('Nama') }}
					</th>
					<th scope="col" class="py-3 px-6">
						{{ __('Email') }}
					</th>
					<th scope="col" class="py-3 px-6">
						{{ __('Username') }}
					</th>
					<th scope="col" class="py-3 px-6">
						{{ __('Role') }}
					</th>
					<th scope="col" class="py-3 px-6">
						{{ __('Tanggal dibuat') }}
					</th>
					<th scope="col" class="py-3 px-6 text-right">
						{{ __('Total blog') }}
					</th>
					<th scope="col" class="py-3 px-6">
						{{ __('Aksi') }}
					</th>
				</tr>
				</thead>
				<tbody>

				@foreach($users as $user)
					<tr class="bg-white border-b border-slate-100">
						<td class="py-4 px-4">
							<div class="flex items-center">
								<img class="w-8 h-8 rounded-full" src="{{ asset("storage/avatar/{$user->avatar}") }}"
										 alt="{{ $user->username }} avatar">
								<span class="ml-4">{{ $user->name }}</span>
							</div>
						</td>
						<td class="py-4 px-6">
							{{ $user->email }}
						</td>
						<td class="py-4 px-6">
							{{ $user->username }}
						</td>
						<td class="py-4 px-6">
							<x-badge.role :role="\App\Enums\UserRole::from($user->role)"/>
						</td>
						<td class="py-4 px-6">
							{{ \Illuminate\Support\Carbon::make($user->created_at)->format('d F Y') }}
						</td>
						<td class="py-4 px-6 text-right">
							<x-button.link href="{{ route('manager.user.blog', ['user' => $user]) }}">
								{{ $user->blogs_count }}
							</x-button.link>
						</td>
						<td class="py-4 px-6">
							<div class="flex space-x-4">
								@can('view', $user)
									<a href="{{ route('manager.user.profile', ['user' => $user]) }}"
										 class="text-slate-600 hover:text-blue-700 active:text-blue-800 p-2">
										<x-icon.info class="w-4 h-4"/>
									</a>
								@endcan

								@can('update', $user)
									<a href="{{ route('manager.user.edit', ['user' => $user]) }}"
										 class="text-slate-600 hover:text-blue-700 active:text-blue-800 p-2">
										<x-icon.edit class="w-4 h-4"/>
									</a>
								@endcan

								@can('delete', $user)
									<form action="{{ route('manager.user.delete', ['user' => $user]) }}" method="post">
										@csrf
										@method('DELETE')
										<button type="submit"
														class="text-slate-600 hover:text-red-700 active:text-red-800 p-2">
											<x-icon.trash class="w-4 h-4"/>
										</button>
									</form>
								@endcan
							</div>
						</td>
					</tr>
				@endforeach

				</tbody>
			</table>
		</div>
	</x-partials.admin.main>
	<span class="text-red-600 text-yellow-600 text-green-600"></span>
@endsection
