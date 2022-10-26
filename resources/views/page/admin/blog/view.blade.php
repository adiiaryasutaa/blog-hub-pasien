@extends('layouts.index')

@section('title', $blog->title)

@section('body')
	<x-partials.admin.navbar :title="auth()->user()->is($blog->author) ? $blog->title : $blog->author->name .'\'s ' . $blog->title">
		<x-slot:actions>
			<div class="flex space-x-8">
				@if($blog->archived())
					<form class="inline" method="post" action="{{ route('admin.blog.upload', ['blog' => $blog]) }}">
						@csrf
						@method('PATCH')
						<x-button.button-link type="submit">
							<x-icon.upload class="w-4 h-4"/>
							<span class="ml-2">{{ __('Unggah') }}</span>
						</x-button.button-link>
					</form>
				@endif

				<x-button.link
					href="{{ route('admin.blog.edit', ['blog' => $blog]) }}"
				>
					<x-icon.edit class="w-4 h-4"/>
					<span class="ml-2">{{ __('Edit') }}</span>
				</x-button.link>
				<form class="inline" method="post" action="{{ route('admin.blog.destroy', ['blog' => $blog]) }}">
					@csrf
					@method('DELETE')
					<x-button.button-link color="red" type="submit">
						<x-icon.trash class="w-4 h-4"/>
						<span class="ml-2">{{ __('Hapus') }}</span>
					</x-button.button-link>
				</form>
			</div>
		</x-slot:actions>
	</x-partials.admin.navbar>

	@include('partials.admin.sidebar', ['active' => auth()->user()->is($blog->author) ? 'blog' : 'manager'])

	<x-partials.admin.main class="font-montserrat pt-24 py-40 min-h-screen">
		<div class="grid grid-cols-5 gap-10">
			@if(session()->has('upload-blog-success'))
				<section class="col-span-full">
					<x-alert
						:name="session('upload-blog-success') . ','"
						:action="['name' => 'lihat']"
						type="success"
					/>
				</section>
			@endif

			@error('upload-blog-failed')
			<section class="col-span-full">
				<x-alert
					:name="$errors->first('upload-blog-failed')"
					type="error"
				/>
			</section>
			@enderror

			<section class="col-span-3 space-y-8">
				<img class="rounded mb-4 w-full" src="{{ asset('storage/blog/thumbnail/' . $blog->thumbnail) }}"
						 alt="{{ $blog->title }}"/>

				<h1 class="text-xl font-bold">{{ $blog->title }}</h1>

				<div class="space-y-4">
					{!! $blog->content !!}
				</div>
			</section>

			<section class="col-span-2 space-y-8">
				<div>
					<h4 class="font-medium mb-2">{{ __('Kategori') }}</h4>
					<div class="flex flex-col">
						@forelse($blog->categories as $category)
							<div class="py-1 pl-2 ml-2 border-l-2 border-blue-400">{{ $category->name }}</div>
						@empty
							<span>{{ __('Tidak memiliki kategori') }},
								<a href="{{ route('admin.blog.edit', ['blog' => $blog]) }}" class="font-medium hover:text-blue-700 active:underline active:underline-offset-2">Tambahkan</a></span>
						@endforelse
					</div>
				</div>
				<div>
					<h4 class="font-medium mb-2">Informasi lengkap</h4>
					<div class="flex flex-col">
						<div class="py-1 pl-2 ml-2 border-l-2 border-blue-400">
							<span>Status </span>
							<x-badge.blog-status :status="\App\Enums\BlogStatus::from($blog->status)" />
						</div>
						<div class="py-1 pl-2 ml-2 border-l-2 border-blue-400">
							<span>Diciptakan oleh </span>
							<span class="font-medium">{{ $blog->author->name }}</span>
						</div>
						<div class="py-1 pl-2 ml-2 border-l-2 border-blue-400">
							<span>Diciptakan pada </span>
							<span class="font-medium">{{ \Carbon\Carbon::make($blog->created_at)->format('D, d F Y h:i:s') }}</span>
						</div>
						<div class="py-1 pl-2 ml-2 border-l-2 border-blue-400">
							<span>Terakhir diedit pada </span>
							<span class="font-medium">{{ \Carbon\Carbon::make($blog->updated_at)->format('D, d F Y h:i:s') }}</span>
						</div>
					</div>
				</div>
			</section>
		</div>
	</x-partials.admin.main>
@endsection
