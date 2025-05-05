<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Http\Livewire\Traits\HasConfirmation;
use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Form extends Component
{
    use HasConfirmation;
    use AuthorizesRequests;
    public $user;
    public $modalName = 'show-users-form-modal';
    protected $listeners = [
        'editUser' => 'edit'
    ];

    public function mount()
    {
        $this->user = new User();
    }

    public function edit($id)
    {
        $this->user = User::withTrashed()->findOrFail($id);

        $this->authorize('update', $this->user);

        $this->resetValidation();

        $this->dispatchBrowserEvent($this->modalName);
    }

    public function update()
    {
        $this->authorize('update', $this->user);

        $this->user->save();

        $this->emit('userUpdated');

        $this->resetValidation();

        $this->flash("User {$this->user->name} Updated!");

        $this->dispatchBrowserEvent('closeModal');
    }

    public function delete()
    {
        $this->confirm('deleteConfirmed', 'You are about to delete this user and all of his records. Are you sure?', NotificationInterface::ERROR);
    }

    protected function deleteConfirmed()
    {
        abort_if(auth()->user()->id === $this->user->id, 403, 'You can\'t delete yourself');

        $this->authorize('delete', $this->user);

        $this->user->delete();

        $this->emit('userUpdated');

        $this->flash("User {$this->user->name} Deleted!", 'error');
    }

    public function restore()
    {
        $this->confirm('restoreConfirmed', 'You are about to restore this user and all of his records. Are you sure?', NotificationInterface::INFO);
    }

    protected function restoreConfirmed()
    {
        abort_if(auth()->user()->id === $this->user->id, 403, 'You can\'t restore yourself');

        $this->authorize('restore', $this->user);

        $this->user->restore();

        $this->emit('userUpdated');

        $this->flash("User {$this->user->name} Restored!", 'info');
    }

    public function verify()
    {
        $this->confirm(
            confirmation_method: 'verifyConfirmed',
            // message: "Do you really want to unverify user {$this->user->name}?",
            type: NotificationInterface::SUCCESS
        );
    }

    public function verifyConfirmed()
    {
        abort_if(auth()->user()->id === $this->user->id, 403, 'You can\'t verify yourself');

        $this->authorize('update', $this->user);

        $this->user->forceFill(['email_verified_at' => now()])->save();

        $this->emit('userUpdated');

        $this->flash("User {$this->user->name} has been verified!", 'warning');
    }

    public function unverify()
    {
        $this->confirm(
            confirmation_method: 'unverifyConfirmed',
            message: "Do you really want to unverify user {$this->user->name}?",
            type: NotificationInterface::WARNING
        );
    }

    public function unverifyConfirmed()
    {
        abort_if(auth()->user()->id === $this->user->id, 403, 'You can\'t unverify yourself');

        $this->authorize('update', $this->user);

        $this->user->forceFill(['email_verified_at' => null])->save();

        $this->emit('userUpdated');

        $this->flash("User {$this->user->name} has been unverified!", 'error');
    }

    protected function rules()
    {
        return [
            'user.name' => [
                'required',
                'min:3',
                Rule::unique(User::class, 'email')->ignore($this->user->id),
            ],
            'user.email' => [
                'required',
                'email',
                'min:3',
                Rule::unique(User::class, 'email')->ignore($this->user->id),
            ],
        ];
    }
}
