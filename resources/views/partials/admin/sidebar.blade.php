@props(['active' => ''])

<aside class="fixed font-montserrat w-64 z-30">
	<div class="overflow-y-auto py-4 pl-4 pr-6 border-r border-slate-100 h-screen">
		<div class="flex flex-col justify-between h-full">
			<div>
				<div class="flex justify-center space-x-1 items-baseline py-2 mb-8">
					<img class="w-48" src="{{ asset('images/logo.svg') }}" alt="Logo Hub Pasien"/>
				</div>

				<div class="flex flex-col space-y-2">
					<x-sidebar.navigation-link href="{{ route('admin.dashboard') }}" :active="$active === 'dashboard'">
						<x-icon.rectangle-group class="inline w-5 h-5"/>
						<span class="ml-4">{{ __('Dashboard') }}</span>
					</x-sidebar.navigation-link>

					<x-sidebar.navigation-link href="{{ route('manager.user') }}" :active="$active === 'manager'">
						<x-icon.user-circle class="inline w-5 h-5"/>
						<span class="ml-4">{{ __('User manager') }}</span>
					</x-sidebar.navigation-link>

					<x-sidebar.navigation-link href="{{ route('admin.blog') }}" :active="$active === 'blog'">
						<x-icon.newspaper class="inline w-5 h-5"/>
						<span class="ml-4">{{ __('Blog') }}</span>
					</x-sidebar.navigation-link>

					<x-sidebar.navigation-link href="{{ route('admin.blog.trash') }}" :active="$active === 'trash'">
						<x-icon.trash class="inline w-5 h-5"/>
						<span class="ml-4">{{ __('Tempat sampah') }}</span>
					</x-sidebar.navigation-link>

					<x-sidebar.navigation-link href="{{ route('admin.profile') }}" :active="$active === 'profile'">
						<x-icon.person class="inline w-5 h-5"/>
						<span class="ml-4">{{ __('Profil') }}</span>
					</x-sidebar.navigation-link>
				</div>
			</div>

			<div class="border-t border-slate-100 pt-4 space-y-4">
				<a
					class="flex items-center text-slate-900 text-sm font-medium px-2 py-1.5 hover:text-blue-500 active:text-blue-600"
					href="{{ route('admin.profile') }}">
					<img class="w-5 h-5 rounded-full border border-slate-600"
							 src="{{ asset("storage/avatar/" . auth()->user()->avatar) }}">
					<span class="ml-2">{{ auth()->user()->name }}</span>
				</a>

				<form action="{{ route('admin.auth.logout') }}" method="post">
					@csrf
					<button type="submit"
									class="flex w-full items-center p-2 text-sm font-medium text-slate-800 hover:text-red-500 active:text-red-600">
						<x-icon.out class="w-5 h-5"/>
						<span class="ml-3">{{ __('Keluar') }}</span>
					</button>
				</form>
			</div>
		</div>
	</div>
</aside>
