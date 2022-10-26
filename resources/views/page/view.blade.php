@extends('layouts.index')

@section('title', 'Blog')

@section('body')
	@include('partials.navbar')

	<main class="font-montserrat py-40">
		<div class="container px-40 mx-auto">
			<div class="flex flex-col items-center">
				<section class="col-span-3 space-y-8 w-[50rem]">
					<div class="w-full">
						<x-button.link href="{{ route('index') }}">
							<x-icon.arrow-left-long class="w-4 h-4" />
							<span class="ml-2">{{ __('Kembali') }}</span>
						</x-button.link>
					</div>

					<img class="rounded mb-4 w-full" src="{{ asset('storage/blog/thumbnail/' . $blog->thumbnail) }}" alt="{{ $blog->title }}"/>

					<div class="flex items-center text-slate-900">
						<div class="inline-flex items-center space-x-2">
							<img src="{{ asset('storage/avatar/' . $blog->author->avatar) }}" class="w-10 rounded-full border border-slate-300">
							 <div>oleh <span class="font-medium">{{ $blog->author->name }}</span></div>
						</div>
						<div class="before:content-['\2014'] pl-1">
							{{ \Carbon\Carbon::make($blog->created_at)->format('D F Y') }}
						</div>
					</div>

					<h1 class="text-4xl font-bold">{{ $blog->title }}</h1>

					<div class="space-y-4">
						{!! $blog->content !!}
					</div>
				</section>
		</div>
	</main>
@endsection
