@extends('layouts.index')

@section('title', 'Tempat Sampah')

@section('body')
    <x-partials.admin.navbar :title="$blog->title">
        <x-slot:actions>
            <div class="flex space-x-8">
                <form action="{{ route('admin.blog.trash.restore', ['blog' => $blog]) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <x-button.button-link type="submit">
                        <x-icon.return class="w-4 h-4"/>
                        <span class="ml-2">{{ __('Kembalikan') }}</span>
                    </x-button.button-link>
                </form>

                <form action="{{ route('admin.blog.trash.force-delete', ['blog' => $blog]) }}" method="post">
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

    @include('partials.admin.sidebar', ['active' => 'trash'])

    <x-partials.admin.main class="font-montserrat pt-24 py-40 min-h-screen">
        <div class="grid grid-cols-5 gap-10">
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
                    <h4 class="font-medium mb-2">Kategori</h4>
                    <div class="flex flex-col">
                        @forelse($blog->categories as $category)
                            <div class="py-1 pl-2 ml-2 border-l-2 border-blue-400">{{ $category->name }}</div>
                        @empty
                            <span>Tidak memiliki kategori</span>
                        @endforelse
                    </div>
                </div>
                <div>
                    <h4 class="font-medium mb-2">Informasi lengkap</h4>
                    <div class="flex flex-col">
                        <div class="py-1 pl-2 ml-2 border-l-2 border-blue-400">
                            <span>Status </span>
                            <span class="font-bold text-red-600">{{ str(\App\Enums\BlogStatus::from($blog->status)->name)->title() }}</span>
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
                            <span>Dihapus pada </span>
                            <span class="font-medium">{{ \Carbon\Carbon::make($blog->deleted_at)->format('D, d F Y h:i:s') }}</span>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </x-partials.admin.main>
@endsection
