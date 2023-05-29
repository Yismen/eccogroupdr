<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use App\Http\Livewire\AbstractDatatable;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Livewire\Traits\HasConfirmation;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;

class Table extends AbstractDatatable
{
    use HasConfirmation;

    protected $listeners = [
        'userUpdated' => '$refresh'
    ];

    public function builder(): Builder
    {
        return User::query();
    }

    public function columns(): array
    {
        $this->disableCreateButton();
        // $this->disableEditButton();
        $this->disableShowButton();

        return [
            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),
            Column::make('Email', 'email')
                ->sortable()
                ->searchable(),
            BooleanColumn::make('Verified', 'email_verified_at')
                ->sortable(),
            // Column::make('Updated at', 'updated_at')
            //     ->sortable(),
            Column::make('Actions', 'id')
                ->view('tables.actions')
        ];
    }

    public function bulkActions(): array
    {
        return [
            'activate' => 'Activate',
            'inactivate' => 'Deactivate',
        ];
    }

    public function activate()
    {
        $this->confirm('activateConfirmed', 'Are you sure you want to activate these users?');
    }

    public function inactivate()
    {
        $this->confirm('inactivateConfirmed', 'These users will no longer be able to log in the application unless they confirm their email. Are you sure of this action?');
    }

    protected function activateConfirmed()
    {
        User::query()
            ->whereIn('id', $this->getSelected())
            ->whereNull('email_verified_at')
            ->where('id', '!=', auth()->user()->id)
            ->get()
            ->each
            ->forceFill(['email_verified_at' => now()])
            ->each
            ->save();
    }

    protected function inactivateConfirmed()
    {
        User::query()
            ->whereIn('id', $this->getSelected())
            ->whereNotNull('email_verified_at')
            ->where('id', '!=', auth()->user()->id)
            ->get()
            ->each
            ->forceFill(['email_verified_at' => null])
            ->each
            ->save();
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Active', 'email_verified_at')
                ->options([
                    '' => 'All',
                    'yes' => 'Yes',
                    'no' => 'No',
                ])
                ->filter(function (Builder $query, string $value) {
                    $query->when(
                        $value === 'yes',
                        function ($query) {
                            $query->whereNotNull('email_verified_at');
                        },
                        function ($query) {
                            $query->whereNull('email_verified_at');
                        }
                    );
                }),
        ];
    }
}
