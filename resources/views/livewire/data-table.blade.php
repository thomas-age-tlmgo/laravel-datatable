<div class="mt-5">
    <form wire:submit="search">
        <input type="search" name="query" wire:model="query" class="form-control" placeholder="Search...">
    </form>
    <table class="table table-striped mt-3">
        <thead>
        <tr>
            @foreach($columns as $id => $column)
                <th wire:click="sortBy('{{ $id }}')">
                    {{ $column->label }}

                    @if($sortField === $id && $sortReverse)
                        <i class='bx bx-sort-down' ></i>
                    @endif

                    @if($sortField === $id && ! $sortReverse)
                        <i class='bx bx-sort-up' ></i>
                    @endif
                </th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($results as $result)
            <tr>
                @foreach($columns as $column)
                    <td>{{ call_user_func($column->display, $result) }}</td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $results->links() }}
</div>
