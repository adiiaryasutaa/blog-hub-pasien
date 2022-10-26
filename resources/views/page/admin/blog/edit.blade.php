@extends('layouts.index')

@section('title', 'Edit Blog')

@push('style')
    <link rel="stylesheet" href="{{ asset('css/trix.css') }}">
    <script type="text/javascript" src="{{ asset('js/trix-core.js') }}"></script>
@endpush

@section('body')
    <x-partials.admin.navbar :title="__('Edit ') . (!auth()->user()->is($blog->author) ? $blog->author->name . __('\'s ') : '') . $blog->title"/>

    @include('partials.admin.sidebar', ['active' => auth()->user()->is($blog->author) ? 'blog' : 'manager'])

    <form action="{{ route('admin.blog.update', ['blog' => $blog]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <x-partials.admin.main class="font-montserrat pt-24 pb-40 min-h-screen">
            <div class="w-[64rem] space-y-10">
                @if(session()->has('update-blog-success'))
                    <x-alert
                            :name="session('update-blog-success')"
                            :action="['name' => 'lihat', 'path' => route('admin.blog.show', ['blog' => $blog])]"
                            type="success"
                    />
                @endif

                @error('update-blog-failed')
                <x-alert
                        :name="$errors->first('update-blog-failed')"
                        type="error"
                />
                @enderror

                <x-form.input.image
                        id="thumbnail"
                        name="thumbnail"
                        :label="__('Thumbnail')"
                        :value="old('thumbnail', asset('storage/blog/thumbnail/' . $blog->thumbnail))"
                />

                <x-form.input
                        id="title"
                        name="title"
                        :label="__('Judul')"
                        :placeholder="$blog->title"
                        :value="old('title', $blog->title)"
                />

                <x-form.input.trix
                        id="content"
                        name="content"
                        :label="__('Isi')"
                        value="{!! old('content', $blog->content) !!}"
                />

                <x-form.input
                        id="categories"
                        name="categories"
                        :label="__('Kategori (pisahkan dengan koma jika kategori lebih dari satu, contoh: Kesehatan, Teknologi, ...)')"
                        :value="old('categories', $blog->categoryList())"
                />

                <x-form.input.checkbox
                        id="archived"
                        name="archived"
                        :label="__('Simpan sebagai arsip (Simpan sebagai arsip jika blog Anda belum siap untuk dipublikasikan)')"
                        :value="old('archived')"
                        :checked="$blog->status === \App\Enums\BlogStatus::ARCHIVED->value"
                />

                <x-button.primary type="submit">
                    {{ __('Simpan') }}
                </x-button.primary>
            </div>
        </x-partials.admin.main>
    </form>
@endsection
