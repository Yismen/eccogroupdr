<div>
    {{-- <div class="modal fade" id="{{ $modalName }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent='update' class="needs-validation" novalidate>
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ $user->name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
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
                        <button class="btn btn-primary" type="submit">Save
                            changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        (function() {
            window.addEventListener("{{ $modalName }}", (e) => {
                let element = $("#{{ $modalName }}");
                
                element.modal('show');               

                element.on('shown.bs.modal', function (event) {

                    let firstInput = $(element).find('input[type=text],textarea,select').filter(':visible:first');
                    
                    firstInput.focus();
                });
            })
            document.addEventListener('closeAllModals', (event) => {
                let element = $('#' + '{{ $modalName }}');
                element.modal('hide');
            })
        })()
    </script>
    @endpush --}}

    <x-modal modal-name="{{ $modalName }}">
        <x-slot name="header">
            <h5 class="text-bold text-uppsercase">{{ $user->name }}</h5>
        </x-slot>

        <form wire:submit.prevent='update' class="needs-validation" novalidate>
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
        <div class="modal-footer">
            <button class="btn btn-danger btn-sm" wire:click.prevent='delete'>Delete User</button>
        </div>
    </x-modal>
</div>