@extends('layouts.index')

@section('title', 'Profil')

@section('body')
    <x-partials.admin.navbar :title="__('Profile')">
        <x-slot:actions>
            <div class="flex space-x-4">
                @can('update', $user)
                    <x-button.link href="{{ route('manager.user.edit', ['user' => $user]) }}">
                        <x-icon.edit class="w-4 h-4"/>
                        <span class="ml-2">{{ __('Edit') }}</span>
                    </x-button.link>
                @endcan

                @can('delete', $user)
                    <form action="{{ route('manager.user.delete', ['user' => $user]) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <x-button.button-link color="red" type="submit">
                            <x-icon.trash class="w-4 h-4"/>
                            <span class="ml-2">{{ __('Hapus') }}</span>
                        </x-button.button-link>
                    </form>
                @endcan

                @if($user->is(auth()->user()))
                    <form action="{{ route('admin.auth.logout') }}" method="post">
                        @csrf
                        <x-button.button-link color="red" type="submit">
                            <x-icon.out class="w-4 h-4"/>
                            <span class="ml-2">{{ __('Keluar') }}</span>
                        </x-button.button-link>
                    </form>
                @endif
            </div>
        </x-slot:actions>
    </x-partials.admin.navbar>

    @include('partials.admin.sidebar', ['active' => str(url()->current())->is(route('manager.user.profile', ['user' => $user])) ? 'manager' : 'profile'])

    <x-partials.admin.main class="font-montserrat py-24">
        <div class="flex flex-col space-y-8">
            <div class="grid grid-cols-2 gap-10">
                <section class="col-span-2">
                    <div class="space-y-6">
                        <div class="flex space-x-12">
                            <img class="rounded-full border border-slate-600 w-40"
                                 src="{{ asset("storage/avatar/{$user->avatar}") }}">
                            <div class="flex flex-col justify-center space-y-4">
                                <h1 class="font-medium text-4xl text-slate-900">{{ $user->name }}</h1>
                                <div class="flex space-x-2 divide-x divide-slate-400 text-slate-600">
                                    <x-badge.role :role="\App\Enums\UserRole::tryFrom($user->role)"/>
                                    <span class="pl-2">{{ $user->email }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="space-y-4">
                    <div class="pb-4 border-b border-slate-100">{{ __('Informasi pribadi') }}</div>
                    <div class="flex flex-col space-y-1 text-slate-900">
                        <div class="font-medium">{{ __('Nama') }}</div>
                        <div>{{ $user->name }}</div>
                    </div>
                    <div class="flex flex-col space-y-1 text-slate-900">
                        <div class="font-medium">{{ __('Username') }}</div>
                        <div>{{ $user->username }}</div>
                    </div>
                    <div class="flex flex-col space-y-1 text-slate-900">
                        <div class="font-medium">{{ __('Email') }}</div>
                        <div>{{ $user->email }}</div>
                    </div>
                </section>

                <section class="space-y-4">
                    <div class="pb-4 border-b border-slate-100">{{ __('Detail user') }}</div>
                    <div class="flex flex-col space-y-1 text-slate-900">
                        <div class="font-medium">{{ __('Role') }}</div>
                        <x-badge.role :role="\App\Enums\UserRole::tryFrom($user->role)"/>
                    </div>
                    <div class="flex flex-col space-y-1 text-slate-900">
                        <div class="font-medium">{{ __('Tanggal dibuat') }}</div>
                        <div>{{ \Illuminate\Support\Carbon::parse($user->created_at)->format('d F Y h:m:s') }}</div>
                    </div>
                    <div class="flex flex-col space-y-1 text-slate-900">
                        <div class="font-medium">{{ __('Tanggal terakhir diedit') }}</div>
                        <div>{{ \Illuminate\Support\Carbon::parse($user->updated_at)->format('d F Y h:m:s') }}</div>
                    </div>
                </section>
            </div>
        </div>
    </x-partials.admin.main>
@endsection
