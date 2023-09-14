<?php

declare(strict_types=1);

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

abstract class DataTable extends Component
{
    use WithPagination;

    public string $query = '';

    public ?string $sortField = null;

    public bool $sortReverse = false;

    public function render(): View
    {
        $builder = $this->getBuilder();

        if ($this->query !== '') {
            $builder->where(function (Builder $builder): void {
                foreach ($this->getColumns() as $column) {
                    $builder->orWhere($column->field, 'LIKE', '%'.$this->query.'%');
                }
            });
        }

        if ($this->sortField !== null && isset($this->getColumns()[$this->sortField])) {
            $builder->orderBy(
                $this->getColumns()[$this->sortField]->field,
                $this->sortReverse ? 'desc' : 'asc'
            );
        }

        return view('livewire.data-table', [
            'columns' => $this->getColumns(),
            'results' => $builder->paginate(10),
        ]);
    }

    public function search(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        if ($field === $this->sortField) {
            $this->sortReverse = ! $this->sortReverse;
        } else {
            $this->sortField = $field;
            $this->sortReverse = false;
        }
    }

    /**
     * @return Column[]
     */
    abstract public function getColumns(): array;

    abstract protected function getBuilder(): Builder;
}
