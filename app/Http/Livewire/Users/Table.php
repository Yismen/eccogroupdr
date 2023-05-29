<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use App\Http\Livewire\AbstractDatatable;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Livewire\Traits\HasConfirmation;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Flasher\Prime\Notification\NotificationInterface;
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
        return User::query()
            ->addSelect(['deleted_at'])
            ->withTrashed();
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
            BooleanColumn::make('Active', 'id')
                ->setCallback(function (string $value, $row) {
                    return !$row->deleted_at;
                })
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
            'verify' => 'Verify',
            'unverify' => 'Unverify',
            'restore' => 'Restore',
        ];
    }

    public function verify()
    {
        $this->confirm('verifyConfirmed', 'Are you sure you want to verify these users?', NotificationInterface::WARNING);
    }

    protected function verifyConfirmed()
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

        $this->clearSelected();

        $this->flash('Users unverified', NotificationInterface::SUCCESS);
    }

    public function unverify()
    {
        $this->confirm('unverifyConfirmed', 'These users will no longer be able to log in the application unless they confirm their email. Are you sure of this action?', NotificationInterface::ERROR);
    }

    protected function unverifyConfirmed()
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

        $this->clearSelected();

        $this->flash('Users unverified', NotificationInterface::ERROR);
    }

    public function restore()
    {
        $this->confirm('restoreConfirmed', 'Are you sure you want to restore these users?', NotificationInterface::SUCCESS);
    }

    public function restoreConfirmed()
    {
        User::query()
            ->onlyTrashed()
            ->whereIn('id', $this->getSelected())
            ->where('id', '!=', auth()->user()->id)
            ->get()
            ->each
            ->restore();

        $this->clearSelected();

        $this->flash('Users unverified', NotificationInterface::INFO);
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Verified', 'email_verified_at')
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

            SelectFilter::make('Active', 'deleted_at')
                ->options([
                    '' => 'All',
                    'yes' => 'Yes',
                    'no' => 'No',
                ])
                ->filter(function (Builder $query, string $value) {
                    $query->when(
                        $value === 'yes',
                        function ($query) {
                            $query->whereNull('deleted_at');
                        },
                        function ($query) {
                            $query->whereNotNull('deleted_at');
                        }
                    );
                }),
        ];
    }
}
