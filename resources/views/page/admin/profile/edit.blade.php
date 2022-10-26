@extends('layouts.index')

@section('title', "Edit Profil")

@section('body')
    <x-partials.admin.navbar :title="__('Edit profil')"/>

    @include('partials.admin.sidebar', ['active' => 'profile'])

    <x-partials.admin.main class="ml-96 font-montserrat pt-24 pb-72">
        <div class="grid grid-cols-2 gap-20">
            <section id="avatar-update" class="col-span-2">
                <div class="space-y-6">
                    <span class="font-light">{{ __('Avatar') }}</span>
                    <div class="flex space-x-12">
                        <img class="rounded-full border border-slate-600 w-40"
                             src="{{ asset("storage/avatar/{$user->avatar}") }}">
                        <div class="flex flex-col justify-center space-y-8">
                            <form action="{{ '' }}" method="post">
                                <button type="submit"
                                        class="font-medium text-slate-600 hover:text-blue-700 active:text-blue-800">{{ __('Unggah avatar') }}</button>
                            </form>
                            <form action="{{ '' }}" method="post">
                                <button type="submit"
                                        class="font-medium text-slate-600 hover:text-red-700 active:text-red-800">{{ __('Hapus avatar') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

            <section id="profile-update">
                <form action="{{ route('admin.profile.update', ['admin' => $user]) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="space-y-6 pt-6">
                        <div class="font-light border-b border-slate-100 pb-6">{{ __('Informasi Pribadi') }}</div>
                        @if(session()->has('update-profile-success'))
                            <x-alert
                                    :name="session('update-profile-success')"
                                    type="success"
                            />
                        @endif

                        @error('update-profile-failed')
                        <x-alert
                                :name="$errors->first('update-profile-failed')"
                                type="error"
                        />
                        @enderror

                        <x-form.input
                                id="name"
                                name="name"
                                :label="__('Nama')"
                                :value="old('name', $user->name)"
                                :placeholder="$user->name"
                                :error="$errors->first('name')"
                        />

                        <x-form.input
                                id="username"
                                name="username"
                                :label="__('Username')"
                                :value="old('username', $user->username)"
                                :placeholder="$user->username"
                                :error="$errors->first('username')"
                        />

                        <x-form.input
                                id="email"
                                name="email"
                                type="email"
                                :label="__('Email')"
                                :value="old('email', $user->email)"
                                :placeholder="$user->email"
                                :error="$errors->first('email')"
                        />

                        <x-button.primary type="submit">
                            {{ __('Update profil') }}
                        </x-button.primary>
                    </div>
                </form>
            </section>

            <section id="change-password">
                <form action="{{ route('admin.profile.update.password') }}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="space-y-6 pt-6">
                        <div class="font-light border-b border-slate-100 pb-6">{{ __('Password') }}</div>

                        @if(session()->has('change-password-success'))
                            <x-alert
                                    :name="session('change-password-success')"
                                    type="success"
                            />
                        @endif

                        @error('change-password-failed')
                        <x-alert
                                :name="$errors->first('change-password-failed')"
                                type="error"
                        />
                        @enderror

                        <x-form.input
                                id="old-password"
                                name="old-password"
                                type="password"
                                :label="__('Password lama')"
                                :error="$errors->first('old-password')"
                        />

                        <x-form.input
                                id="new-password"
                                name="new-password"
                                type="password"
                                :label="__('Password baru')"
                                :error="$errors->first('new-password')"
                        />

                        <x-form.input
                                id="confirm-password"
                                name="confirm-password"
                                type="password"
                                :label="__('Konfirmasi password')"
                                :error="$errors->first('confirm-password')"
                        />

                        <x-button.primary type="submit">
                            <span>{{ __('Ganti password') }}</span>
                        </x-button.primary>
                    </div>
                </form>
            </section>
        </div>
    </x-partials.admin.main>
@endsection
