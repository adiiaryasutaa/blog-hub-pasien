@props([
	'toggleSelector' => '',
	'modalId' => Str::random(),
])

<div id="{{ $modalId }}" class="hidden fixed w-screen h-screen bg-slate-600/50 backdrop-blur z-50">
	<div class="flex justify-center items-center h-full">
		{{ $slot }}
	</div>
</div>

<script>
	const toggler = document.querySelector('{{ $toggleSelector }}');
	const modal = document.querySelector('#{{ $modalId }}');

	toggler.addEventListener('click', () => {
		modal.classList.toggle('hidden');
	});

</script>
