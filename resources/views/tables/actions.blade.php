<div class="d-flex " style="gap: 10px;">
    @if ($this->with_show_button)
    <button class="btn btn-xs btn-secondary" wire:click.prevent='$emit("show{{ $this->model() }}", "{{ $row->id }}")'>{{
        __('Details')
        }}</button>
    @endif

    @if ($this->with_edit_button)
    <button class="btn btn-xs btn-warning" wire:click.prevent='$emit("edit{{ $this->model() }}", "{{ $row->id }}")'>{{
        __('Edit')
        }}</button>
    @endif
</div>