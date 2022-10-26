@extends('layouts.index')

@section('title', 'Login')

@section('body')
	<div class="fixed p-6 top-0">
		<x-button.link href="{{ route('index') }}">
			<x-icon.arrow-left-long class="w-4 h-4"/>
			<span class="ml-2">{{ __('Halaman blog') }}</span>
		</x-button.link>
	</div>

	<form action="{{ route('admin.auth') }}" method="post">
		@csrf

		<section class="container mx-auto px-4 font-montserrat mt-24">
			<div class="flex justify-center">
				<div class="w-96 flex flex-col items-center space-y-12">
					<h1 class="text-3xl font-medium">{{ __('Login') }}</h1>

					@error('login-failed')
					<x-alert :name="$errors->first('login-failed')" type="error"/>
					@enderror

					<div class="flex flex-col items-start space-y-4 w-full">
						<x-form.input name="username" :placeholder="__('Username')" :value="old('username')"/>
						<x-form.input name="password" :placeholder="__('Password')" type="password"/>
						<x-form.input.checkbox name="remember" :label="__('Ingat saya')"/>
					</div>

					<x-button.primary type="submit" class="w-full">
						{{ __('Masuk') }}
					</x-button.primary>
				</div>
			</div>
		</section>

	</form>
@endsection
