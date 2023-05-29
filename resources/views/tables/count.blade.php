<div class="d-flex justify-content-between mb-3">
    <h5>{{ $this->title() }} <span class="badge badge-primary">{{ $count }}</span></h5>

    @if ($this->with_create_button)
    <button class="btn btn-sm btn-primary" wire:click.prevent='$emit("create"{{ $this->model() }})'>
        {{ __('Create') }}
    </button>
    @endif
</div>