<div>
    <x-modal modal-name="{{ $modalName }}">
        <x-slot name="header">
            <h5 class="text-bold text-uppsercase 
            @if($user->deleted_at)
                text-red
            @elseif(! $user->email_verified_at) 
                text-black-50 
            @endif
            ">{{ $user->name }}</h5>
        </x-slot>

        <form wire:submit.prevent='update' class="needs-validation" novalidate id="form">
            <div class="modal-body">
                <x-inputs.input field="user.name">
                    <x-inputs.label field="user.name">
                        Name:
                    </x-inputs.label>
                </x-inputs.input>


                <x-inputs.input type="email" field="user.email">
                    <x-inputs.label field="user.email">
                        Email:
                    </x-inputs.label>
                </x-inputs.input>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-primary" type="submit">Save
                    changes</button>
            </div>
        </form>

        <div class="modal-footer bg-light d-flex justify-content-between">
            @if ($user->deleted_at)
            <button class="btn btn-secondary btn-sm" wire:click.prevent='restore'>Restore User</button>
            @else
            <button class="btn btn-danger btn-sm" wire:click.prevent='delete'>Delete User</button>
            @endif

            @if ($user->email_verified_at)
            <button class="btn btn-warning btn-sm" wire:click.prevent='unverify'>Unverify</button>
            @else
            <button class="btn btn-success btn-sm" wire:click.prevent='verify'>Verify</button>
            @endif
        </div>
    </x-modal>
</div>