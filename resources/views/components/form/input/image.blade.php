@props([
  'id' => '',
	'label' => '',
	'withPreview' => true,
	'showError' => true,
])

<div>
	<label>
		<div class="space-y-2">
			<div class="block mb-2 text-sm font-medium text-slate-600">{{ $label }}</div>

			@if($withPreview)
				<img id="preview-image" class="rounded" {{ $attributes->has('value') ? 'src=' . $attributes->get('value') . ' alt=preview' : '' }}>
			@endif

			<input
				id="{{ $id }}"
				{{ $attributes->except('value')->merge(['class' => 'w-full text-sm text-slate-900 border border-slate-300 rounded cursor-pointer px-4 py-2.5 focus:outline-none file:mr-4 file:py-1 file:px-2 file:rounded file:border-0 file:text-slate-700 file:cursor-pointer']) }}
				type="file">

			@if($showError)
				<div class="text-sm font-medium text-red-600">{{ $errors->first($attributes->get('name')) }}</div>
			@endif
		</div>
	</label>
</div>

@if($withPreview)
	<script type="text/javascript">
		const previewImage = document.getElementById('preview-image')
		const fileInput = document.getElementById('{{ $id }}')

		fileInput.addEventListener('change', () => {
			const file = fileInput.files[0]

			if (file) {
				const fileReader = new FileReader()

				fileReader.onload = () => {
					previewImage.setAttribute('src', fileReader.result)
				}

				fileReader.readAsDataURL(file)
			}
		})
	</script>
@endif
