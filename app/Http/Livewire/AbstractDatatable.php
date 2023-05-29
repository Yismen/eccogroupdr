<?php

namespace App\Http\Livewire;

use Illuminate\Support\Stringable;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Livewire\Traits\HasConfirmation;
use Rappasoft\LaravelLivewireTables\DataTableComponent;

abstract class AbstractDatatable extends DataTableComponent
{
    use HasConfirmation;

    public bool $with_create_button = true;
    public bool $with_edit_button = true;
    public bool $with_show_button = true;

    public function title(): string
    {
        return $this->model()->headline()->plural() . ' Table';
    }

    public function model(): Stringable
    {
        return str(get_class($this->getBuilder()->getModel()))->afterLast('\\');
    }

    public function configure(): void
    {
        $this->theme = 'bootstrap-4';
        $this->setPrimaryKey('id');
        $this->setQueryStringDisabled();
        $this->setColumnSelectDisabled();

        $this->setTableAttributes([
            'class' => 'table-sm table-hover',
        ]);

        $this->setConfigurableAreas([
            'before-toolbar' => [
                'tables.count', [
                    'count' => $this->builder()->count(),
                ],
            ],
        ]);
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

    protected function disableCreateButton()
    {
        $this->with_create_button = false;
    }

    protected function disableEditButton()
    {
        $this->with_edit_button = false;
    }

    protected function disableShowButton()
    {
        $this->with_show_button = false;
    }
}
