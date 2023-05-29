@props([
'submit_method' => 'saf',
'id' => $attributes['id'] ?? 'formId'
])

<div>
    <form wire:submit.prevent="{{ $submit_method }}" {{ $attributes->merge([
        'class' => 'needs-validation'
        ]) }} autocomplete="off" id='{{ $id }}'>

        {{ $slot }}

        @isset($footer)
        <div class="mt-3 border-top p-2">
            {{ $footer }}
        </div>
        @endisset
    </form>

    @push('scripts')
    <script>
        (function() {
            let element $("#{{ $id }}");

            let firstInput = $(element).find('input[type=text],textarea,select').filter(':visible:first');
            
            firstInput.focus();
        })()
    </script>
    @endpush
</div>