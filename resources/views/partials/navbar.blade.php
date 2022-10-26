<nav class="px-8 py-4 border-b border-slate-50 backdrop-blur-sm bg-slate-50/90 fixed w-full z-20">
	<div class="flex justify-between">
		<a href="{{ route('index') }}">
			<div class="flex items-center space-x-1">
				<img src="{{ asset('images/logo.svg') }}" class="w-52" alt="Logo Hub Pasien">
				<span class="font-medium text-sm text-slate-500">{{ __('Blog') }}</span>
			</div>
		</a>

		<div>
			<a
				href="#"
				type="_button"
				class="inline-flex items-center bg-blue-100 rounded px-4 py-1 text-slate-900 hover:bg-blue-400 hover:text-white active:bg-blue-600 focus:ring-4 focus:ring-blue-200">
				<x-icon.arrow-left-long class="w-4 h-4" />
				<span class="ml-2">{{ __('Halaman Utama') }}</span>
			</a>
		</div>
	</div>
</nav>
