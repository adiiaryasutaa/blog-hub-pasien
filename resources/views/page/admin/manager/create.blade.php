@extends('layouts.index')

@section('title', 'Admin')

@section('body')
	<x-partials.admin.navbar :title="__('Buat Admin')"/>

	@include('partials.admin.sidebar', ['active' => 'manager'])

	<x-partials.admin.main class="font-montserrat pt-24 min-h-screen">
		@error('create-user-failed')
		<div class="mb-4 w-96">
			<x-alert
				:name="$errors->first('create-user-failed')"
				type="error"
			/>
		</div>
		@enderror

		<form action="{{ route('manager.user.store') }}" method="post" enctype="multipart/form-data">
			@csrf
			<div class="flex space-x-20">
				<div>
					<div class="flex flex-col items-center space-y-4">
						<img class="rounded-full border border-slate-600 w-40"
								 src="{{ asset("storage/avatar/default.png") }}">
						<form action="{{ '' }}" method="post">
							<button type="submit"
											class="font-medium text-slate-600 hover:text-blue-700 active:text-blue-800">{{ __('Unggah avatar') }}</button>
						</form>
					</div>
				</div>

				<div class="flex flex-col space-y-6 w-96">
					<x-form.input
						id="name"
						name="name"
						:label="__('Nama')"
						:value="old('name')"
					/>

					<x-form.input
						id="username"
						name="username"
						:label="__('Username')"
						:value="old('username')"
					/>

					<x-form.input
						id="email"
						name="email"
						type="email"
						:label="__('Email')"
						:value="old('email')"
					/>

					<x-form.input
						id="password"
						name="password"
						type="password"
						:label="__('Password')"
					/>

					<div class="flex flex-col space-y-2">
						<span class="text-sm font-medium text-slate-600">{{ __('Role') }}</span>
						<label>
							<div class="inline-flex items-center space-x-1">
								<input id="role" type="radio" name="role"
											 value="{{ \App\Enums\UserRole::ADMIN->value }}">
								<span
									class="text-sm font-medium text-slate-600">{{ Str::title(\App\Enums\UserRole::ADMIN->name) }}</span>
							</div>
						</label>
						<label>
							<div class="inline-flex items-center space-x-1">
								<input id="role" type="radio" name="role"
											 value="{{ \App\Enums\UserRole::NORMAL->value }}">
								<span
									class="text-sm font-medium text-slate-600">{{ Str::title(\App\Enums\UserRole::NORMAL->name) }}</span>
							</div>
						</label>
					</div>

					<button type="submit"
									class="text-sm font-medium rounded text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 px-4 py-2">
						<span>{{ __('Buat') }}</span>
					</button>
				</div>
			</div>
		</form>
	</x-partials.admin.main>
@endsection
