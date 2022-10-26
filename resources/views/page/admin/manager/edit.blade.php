@extends('layouts.index')

@section('title', "Edit - {$user->name}")

@section('body')
    <x-partials.admin.navbar :title="__('Edit profil')">
        <x-slot:actions>
            @can('delete', $user)
                <form action="{{ route('manager.user.delete', ['user' => $user]) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <x-button.button-link color="red">
                        <x-icon.trash class="w-4 h-4"/>
                        <span class="ml-2">{{ __('Hapus') }}</span>
                    </x-button.button-link>
                </form>
            @endcan
        </x-slot:actions>
    </x-partials.admin.navbar>

    @include('partials.admin.sidebar', ['active' => 'manager'])

    <x-partials.admin.main class="ml-96 font-montserrat pt-24 pb-72">
        <div class="grid grid-cols-2 gap-20">
            <section id="avatar-update" class="col-span-2">
                <div class="space-y-6">
                    <div class="flex space-x-12">
                        <img class="rounded-full border border-slate-600 w-40"
                             src="{{ asset("storage/avatar/{$user->avatar}") }}">
                        <div class="flex flex-col justify-center space-y-4">
                            <h1 class="font-medium text-4xl text-slate-900">{{ $user->name }}</h1>
                            <div class="flex space-x-2 divide-x divide-slate-400 text-slate-600">
                                <span>{{ $user->role() }}</span>
                                <span class="pl-2">{{ $user->email }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="profile-update">
                <form action="{{ route('manager.user.update', ['user' => $user]) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="space-y-6 pt-6">
                        <div class="font-light border-b border-slate-100 pb-6">{{ __('Informasi Pribadi') }}</div>
                        @if(session()->has('update-user-profile-success'))
                            <x-alert
                                    :name="session('update-user-profile-success')"
                                    type="success"
                            />
                        @endif

                        @error('update-user-profile-failed')
                        <x-alert
                                :name="$errors->first('update-user-profile-failed')"
                                type="error"
                        />
                        @enderror

                        <x-form.input
                                id="name"
                                name="name"
                                :label="__('Nama')"
                                :value="old('name', $user->name)"
                                :placeholder="$user->name"
                        />

                        <x-form.input
                                id="username"
                                name="username"
                                :label="__('Username')"
                                :value="old('username', $user->username)"
                                :placeholder="$user->username"
                        />

                        <x-form.input
                                id="email"
                                name="email"
                                type="email"
                                :label="__('Email')"
                                :value="old('email', $user->email)"
                                :placeholder="$user->email"
                        />

                        @can('attachRole', $user)
                            <div class="flex flex-col space-y-2">
                                <span class="text-sm font-medium text-slate-600">{{ __('Role') }}</span>
                                <label>
                                    <div class="inline-flex items-center space-x-1">
                                        <input id="role" type="radio" name="role"
                                               value="{{ \App\Enums\UserRole::ADMIN->value }}" {{ $user->isAdmin() ? 'checked' : '' }}>
                                        <span
                                                class="text-sm font-medium text-slate-600">{{ Str::title(\App\Enums\UserRole::ADMIN->name) }}</span>
                                    </div>
                                </label>
                                <label>
                                    <div class="inline-flex items-center space-x-1">
                                        <input id="role" type="radio" name="role"
                                               value="{{ \App\Enums\UserRole::NORMAL->value }}" {{ $user->isNormal() ? 'checked' : '' }}>
                                        <span
                                                class="text-sm font-medium text-slate-600">{{ Str::title(\App\Enums\UserRole::NORMAL->name) }}</span>
                                    </div>
                                </label>
                                @error('role')
                                <div class="text-sm font-medium text-red-600">{{ $errors->first('role') }}</div>
                                @enderror
                            </div>
                        @endcan

                        <x-button.primary type="submit">
                            <span>{{ __('Update profil') }}</span>
                        </x-button.primary>
                    </div>
                </form>
            </section>

            <section id="change-password">
                <form action="{{ route('manager.user.update.password', ['user' => $user]) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="space-y-6 pt-6">
                        <div class="font-light border-b border-slate-100 pb-6">{{ __('Password') }}</div>

                        @if(session()->has('change-user-password-success'))
                            <x-alert
                                    :name="session('change-user-password-success')"
                                    type="success"
                            />
                        @endif

                        @error('change-user-password-failed')
                        <x-alert
                                :name="$errors->first('change-user-password-failed')"
                                type="error"
                        />
                        @enderror

                        <x-form.input
                                id="new-password"
                                name="new-password"
                                type="password"
                                :label="__('Password baru')"
                        />

                        <x-form.input
                                id="admin-password"
                                name="admin-password"
                                type="password"
                                :label="__('Password anda')"
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
