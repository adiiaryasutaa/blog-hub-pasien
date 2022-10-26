@extends('layouts.index')

@section('title', 'Blog')

@section('body')
	@include('partials.navbar')

	<main class="py-20">
		<section class="font-montserrat container mx-auto px-4">
			<div class="flex flex-col items-center space-y-2 p-20">
				<h1 class="text-4xl font-bold text-slate-800">{{ __('Blog Hub Pasien') }}</h1>
				<p class="text-slate-600">{{ __('Menambah wawasan Anda dengan blog yang kami bagikan') }}</p>
			</div>
		</section>

		<section class="font-montserrat container mx-auto px-32">
			<div class="grid grid-cols-3 gap-10">

				@foreach($blogs as $blog)
					<div class="space-y-4">
						<div class="relative">
							<img src="{{ asset("storage/blog/thumbnail/{$blog->thumbnail}") }}" alt="{{ $blog->title }}"
									 class="rounded">
						</div>

						<div class="bg-slate-100 rounded text-sm px-4 py-2">
							<div class="flex space-x-1 items-center">
								@foreach($blog->categories as $category)
									<span>{{ $category->name }}</span>
									@if(!$loop->last)
										{{ __(',') }}
									@endif
								@endforeach
							</div>
						</div>

						<h4 class="font-bold text-slate-900">{{ $blog->title }}</h4>
						<p class="text-slate-600 text-sm">{{ $blog->excerpt }}</p>
						<x-button.link class="text-blue-400" href="{{ route('blog.view', ['blog' => $blog]) }}">
							<span class="mr-1">{{ __('Selengkapnya') }}</span>
							<x-icon.arrow-right-long class="w-4 h-4" />
						</x-button.link>
					</div>
				@endforeach
			</div>
			<div class="mt-20">
				{!! $blogs->links('pagination::tailwind') !!}
			</div>
		</section>
	</main>
@endsection
