@extends('layouts.index')

@section('title', 'Blog | Buat')

@push('style')
    <link rel="stylesheet" href="{{ asset('css/trix.css') }}">
    <script type="text/javascript" src="{{ asset('js/trix-core.js') }}"></script>
@endpush

@section('body')
    <x-partials.admin.navbar :title="__('Buat Blog')"/>

    @include('partials.admin.sidebar', ['active' => 'blog'])

    <form action="{{ route('admin.blog.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <x-partials.admin.main class="font-montserrat pt-24 pb-40 min-h-screen">
            <div class="w-[64rem] space-y-10">
                @error('create-blog-failed')
                <x-alert
                        :name="$errors->first('create-blog-failed')"
                        type="error"
                />
                @enderror

                <x-form.input.image
                        id="thumbnail"
                        name="thumbnail"
                        :label="__('Thumbnail')"
                />

                <x-form.input
                        id="title"
                        name="title"
                        :label="__('Judul')"
                        :value="old('title')"
                />

                <x-form.input.trix
                        id="content"
                        name="content"
                        :label="__('Isi')"
                        value="{!! old('content') !!}"
                />

                <x-form.input
                        id="categories"
                        name="categories"
                        :label="__('Kategori (pisahkan dengan koma jika kategori lebih dari satu, contoh: Kesehatan, Teknologi, ...)')"
                        :value="old('categories')"
                />

                <x-form.input.checkbox
                        id="archived"
                        name="archived"
                        :label="__('Simpan sebagai arsip (Simpan sebagai arsip jika blog Anda belum siap untuk dipublikasikan)')"
                        :value="old('archived')"
                />

                <x-button.primary type="submit">
                    {{ __('Simpan') }}
                </x-button.primary>
            </div>
        </x-partials.admin.main>
    </form>
@endsection
