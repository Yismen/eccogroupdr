<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Livewire\Traits\HasConfirmation;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;

class UsersTable extends DataTableComponent
{
    use HasConfirmation;
    protected $model = User::class;

    public function configure(): void
    {
        $this->theme = 'bootstrap-4';
        $this->setPrimaryKey('id');
        $this->setQueryStringDisabled();
        $this->setColumnSelectDisabled();

        $this->setTableAttributes([
            'class' => 'table-sm table-hover',
        ]);
    }

    public function bulkActions(): array
    {
        return [
            'activate' => 'Activate',
            'inactivate' => 'Deactivate',
        ];
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id')
                ->hideIf(true),
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

    public function applySearch(): Builder
    {
        if ($this->searchIsEnabled() && $this->hasSearch()) {
            $searchableColumns = $this->getSearchableColumns();

            if ($searchableColumns->count()) {
                $this->setBuilder($this->getBuilder()->where(function ($query) use ($searchableColumns) {
                    $searchTerms = preg_split("/[\s]+/", $this->getSearch(), -1, PREG_SPLIT_NO_EMPTY);

                    foreach ($searchTerms as $value) {
                        $query->where(function ($query) use ($searchableColumns, $value) {
                            foreach ($searchableColumns as $index => $column) {
                                if ($column->hasSearchCallback()) {
                                    ($column->getSearchCallback())($query, $this->getSearch());
                                } else {
                                    $query->{$index === 0 ? 'where' : 'orWhere'}($column->getColumn(), 'like', '%' . $value . '%');
                                }
                            }
                        });
                    }
                }));
            }
        }

        return $this->getBuilder();
    }
}
