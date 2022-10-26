@extends('layouts.index')

@section('title', 'Dashboard')

@section('body')
	@include('partials.admin.navbar', ['title' => 'Dashboard'])
	@include('partials.admin.sidebar', ['active' => 'dashboard'])

	<x-partials.admin.main class="grid grid-cols-12 gap-10 font-montserrat pt-24 min-h-screen">
		<section class="col-span-full">
			<div class="text-4xl font-medium">
				{{ __('Selamat Datang, ') }}
				<span class="text-blue-600">{{ $user->name }}</span>
			</div>
		</section>

		<section class="col-span-full">
			<div class="grid grid-cols-4 gap-x-4 h-fit">
				<div class="flex items-center bg-slate-100 p-6 rounded space-x-4">
					<x-icon.newspaper class="w-12 h-12 fill-slate-400" />
					<div class="flex flex-col space-y-2">
						<div class="text-2xl text-slate-900">
							{{ $totalAllBlogs }}
						</div>
						<h5 class="text-sm font-medium text-slate-600">{{ __('Jumlah seluruh blog') }}</h5>
					</div>
				</div>
				<div class="flex items-center bg-slate-100 p-6 rounded space-x-4">
					<x-icon.newspaper class="w-12 h-12 fill-slate-400" />
					<div class="flex flex-col space-y-2">
						<div class="text-2xl text-slate-900">
							{{ $totalBlogsOwned }}
						</div>
						<h5 class="text-sm font-medium text-slate-600">{{ __('Jumlah blog dimiliki') }}</h5>
					</div>
				</div>
				<div class="flex items-center bg-slate-100 p-6 rounded space-x-4">
					<x-icon.person class="w-12 h-12 fill-slate-400" />
					<div class="flex flex-col space-y-2">
						<div class="text-2xl text-slate-900">
							{{ $totalViewers }}
						</div>
						<h5 class="text-sm font-medium text-slate-600">{{ __('Jumlah pembaca') }}</h5>
					</div>
				</div>
				<div class="flex items-center bg-slate-100 p-6 rounded space-x-4">
					<x-icon.person class="w-12 h-12 fill-slate-400" />
					<div class="flex flex-col space-y-2">
						<div class="text-2xl text-slate-900">
							{{ $totalViewersToday }}
						</div>
						<h5 class="text-sm font-medium text-slate-600">{{ __('Jumlah pembaca hari ini') }}</h5>
					</div>
				</div>
			</div>
		</section>

		<section class="col-span-6">
			<div class="rounded p-4 border border-slate-100">
				<h5 class="text-sm font-medium mb-6">{{ __('Blog yang memiliki jumlah pembaca terbanyak') }}</h5>
				<div class="flex flex-col">
					@foreach($mostViewedBlogs as $index => $blog)
						<div class="grid grid-cols-12 gap-2 p-2">
							<div class="p-2">
								{{ ++$index }}
							</div>
							<div>
								<img class="w-30" src="{{ asset('storage/blog/thumbnail/' . $blog->thumbnail) }}">
							</div>
							<div class="col-span-9">
								<h1 class="block whitespace-nowrap truncate font-medium">{{ $blog->title }}</h1>
								<div class="text-sm">{{ __('Oleh') . ' ' . $blog->author->name }}</div>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</section>

		<section class="col-span-6">
			<div class="rounded p-4 border border-slate-100">
				<h5 class="text-sm font-medium mb-6">{{ __('Kategori Blog yang banyak dibaca') }}</h5>
				<div class="flex flex-col">
					@foreach($mostViewedCategories as $index => $category)
						<div class="grid grid-cols-12 gap-6">
							<div class="text-center">{{ ++$index }}</div>
							<div class="col-span-9">{{ $category->name }}</div>
						</div>
					@endforeach
				</div>
			</div>
		</section>
	</x-partials.admin.main>
@endsection
