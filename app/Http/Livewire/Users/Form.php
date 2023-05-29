<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Http\Livewire\Traits\HasConfirmation;
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

    public function render()
    {
        return view('livewire.users.form')
            ->layout('layouts.app');
    }

    public function edit(User $user)
    {
        $this->authorize('update', $this->user);

        $this->user = $user;
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
        $this->validate();
        $this->confirm('deleteConfirmed');
    }

    protected function deleteConfirmed()
    {
        abort_if(auth()->user()->id === $this->user->id, 403, 'You can\'t delete yourself');

        $this->user->delete();

        $this->resetValidation();

        $this->emit('userUpdated');

        $this->flash("User {$this->user->name} Deleted!", 'error');

        $this->dispatchBrowserEvent('closeModal');
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
