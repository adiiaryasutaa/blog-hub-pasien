@extends('layouts.index')

@section('title', 'Tempat Sampah')

@section('body')
	<x-partials.admin.navbar :title="__('Trash')">
		<x-slot:actions>
			<div class="flex space-x-4">
				<form action="{{ route('admin.blog.trash.restore-all') }}" method="post">
					@csrf
					@method('PATCH')
					<x-button.button-link type="submit">
						<x-icon.return class="w-4 h-4"/>
						<span class="ml-2">{{ __('Kembalikan semua') }}</span>
					</x-button.button-link>
				</form>

				<form action="{{ route('admin.blog.trash.force-delete-all') }}" method="post">
					@csrf
					@method('DELETE')
					<x-button.button-link color="red" type="submit">
						<x-icon.trash class="w-4 h-4"/>
						<span class="ml-2">{{ __('Hapus semua') }}</span>
					</x-button.button-link>
				</form>
			</div>
		</x-slot:actions>
	</x-partials.admin.navbar>

	@include('partials.admin.sidebar', ['active' => 'trash'])

	<x-partials.admin.main class="font-montserrat pt-24 min-h-screen">
		<section class="mb-40">
			<div class="grid grid-cols-3 gap-6">
				@error('restore-blog-failed')
				<div class="col-span-full">
					<x-alert
						:name="$errors->first('restore-blog-failed')"
						type="error"
					/>
				</div>
				@enderror

				@if(session()->has('delete-blog-success'))
				<div class="col-span-full">
					<x-alert
						:name="session('delete-blog-success')"
						type="success"
					/>
				</div>
				@endif

				@error('delete-blog-failed')
				<div class="col-span-full">
					<x-alert
						:name="$errors->first('delete-blog-failed')"
						type="error"
					/>
				</div>
				@enderror

				@forelse($blogs as $blog)
					<div class="space-y-4">
						<div class="relative">
							<img src="{{ asset("storage/blog/thumbnail/{$blog->thumbnail}") }}" alt="{{ $blog->title }}"
									 class="rounded">
							<div class="absolute rounded-r bg-red-300/50 text-sm font-medium px-4 py-1 top-2 left-0">
								{{ __('Dihapus') }}
							</div>
						</div>
						<div class="bg-slate-100 rounded text-sm px-4 py-2">
							<div class="inline-flex items-center">
								<x-icon.trash class="w-4 h-4"/>
								<span class="ml-2">{{ \Carbon\Carbon::make($blog->deleted_at)->format('D, d M Y h:m') }}</span>
							</div>
						</div>
						<h4 class="font-bold text-slate-900">{{ $blog->title }}</h4>
						<p class="text-slate-600 text-sm">{{ $blog->excerpt }}</p>
						<div class="space-x-8">
							@can('viewTrash', $blog)
								<x-button.link href="{{ route('admin.blog.trash.view', ['blog' => $blog]) }}">
									<x-icon.eye class="w-4 h-4"/>
									<span class="ml-2">{{ __('Lihat') }}</span>
								</x-button.link>
							@endcan

							@can('restore', $blog)
								<form class="inline" method="post"
											action="{{ route('admin.blog.trash.restore', ['blog' => $blog]) }}">
									@csrf
									@method('PATCH')
									<x-button.button-link type="submit">
										<x-icon.return class="w-4 h-4"/>
										<span class="ml-2">{{ __('Kembalikan') }}</span>
									</x-button.button-link>
								</form>
							@endcan

							@can('forceDelete', $blog)
								<form class="inline" method="post"
											action="{{ route('admin.blog.trash.force-delete', ['blog' => $blog]) }}">
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
						<x-alert message="Anda tidak memiliki sampah" type="info"/>
					@else
						<x-alert :message="$user->name . 'tidak memiliki sampah'" type="info"/>
					@endif
				@endforelse
			</div>
		</section>
	</x-partials.admin.main>
@endsection
