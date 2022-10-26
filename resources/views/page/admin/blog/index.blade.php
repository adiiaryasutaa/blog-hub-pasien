@extends('layouts.index')

@section('title', 'Blog')

@section('body')
	<x-partials.admin.navbar :title="__(auth()->user()->is($user) ? 'Blog' : $user->name . '\'s Blog')">
		@if($user->is(auth()->user()))
			<x-slot:actions>
				<div class="flex space-x-4">
					<x-button.link href="{{ route('admin.blog.create') }}">
						<x-icon.plus class="w-4 h-4"/>
						<span class="ml-2">{{ __('Buat blog') }}</span>
					</x-button.link>

					<x-button.link href="{{ route('admin.blog.trash') }}">
						<x-icon.trash class="w-4 h-4"/>
						<span class="ml-2">{{ __('Tempat sampah') }}</span>
					</x-button.link>
				</div>
			</x-slot:actions>
		@endif
	</x-partials.admin.navbar>

	@include('partials.admin.sidebar', ['active' => auth()->user()->is($user) ? 'blog' : 'manager'])

	<x-partials.admin.main class="font-montserrat pt-24 min-h-screen">
		<section class="mb-40">
			{{--			@if(session()->has('create-blog-success'))--}}
			{{--				<x-alert--}}
			{{--					:name="session('create-blog-success')"--}}
			{{--					:action="['name' => 'Lihat', 'path' => route('admin.blog.show', ['blog' => $blog])]"--}}
			{{--					type="success"--}}
			{{--				/>--}}
			{{--			@endif--}}

			<div class="grid grid-cols-3 gap-6">
				@error('delete-blog-failed')
				<section class="col-span-full">
					<x-alert
						:name="$errors->first('delete-blog-failed')"
						type="error"
					/>
				</section>
				@enderror

				@forelse($blogs as $blog)
					<div class="space-y-4">
						<div class="relative">
							<img src="{{ asset("storage/blog/thumbnail/{$blog->thumbnail}") }}" alt="{{ $blog->title }}"
									 class="rounded">
							@if($blog->archived())
								<div class="absolute rounded-r bg-slate-100/50 text-sm font-medium px-4 py-1 top-2 left-0">
									{{ __('Diarsipkan') }}
								</div>
							@endif
						</div>
						<div class="bg-slate-100 rounded text-sm px-4 py-2">
							<div class="inline-flex items-center">
								<x-icon.edit class="w-4 h-4"/>
								<span class="ml-2">{{ \Carbon\Carbon::make($blog->updated_at)->format('D, d M Y h:m') }}</span>
							</div>
						</div>
						<h4 class="font-bold text-slate-900">{{ $blog->title }}</h4>
						<p class="text-slate-600 text-sm">{{ $blog->excerpt }}</p>
						<div class="space-x-8">
							@can('view', $blog)
								<x-button.link href="{{ route('admin.blog.show', ['blog' => $blog]) }}">
									<x-icon.eye class="w-4 h-4"/>
									<span class="ml-2">{{ __('Lihat') }}</span>
								</x-button.link>
							@endcan

							@can('update', $blog)
								<x-button.link href="{{ route('admin.blog.edit', ['blog' => $blog]) }}">
									<x-icon.edit class="w-4 h-4"/>
									<span class="ml-2">{{ __('Edit') }}</span>
								</x-button.link>
							@endcan

							@can('delete', $blog)
								<form class="inline" method="post"
											action="{{ route('admin.blog.destroy', ['blog' => $blog]) }}">
									@csrf
									@method('DELETE')
									<x-button.button-link color="red" type="submit">
										<x-icon.trash class="w-4 h-4"/>
										<span class="ml-2">{{ __('Hapus') }}</span>
									</x-button.button-link>
								</form>
							@endcan
						</div>
					</div>
				@empty
					@if($user->is(auth()->user()))
						<x-alert
							message="Anda tidak memiliki blog,"
							:action="['name' => 'Buat', 'path' => route('admin.blog.create')]">
						</x-alert>
					@else
						<x-alert type="info">
							<x-icon.info class="w-5 h-5"/>
							<span class="ml-2">{{ $user->name . ' ' . __(' tidak memiliki blog') }}</span>
						</x-alert>
					@endif
				@endforelse
			</div>
		</section>
	</x-partials.admin.main>
@endsection
