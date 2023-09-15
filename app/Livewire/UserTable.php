<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

final class UserTable extends DataTable
{
    public function mount(): void
    {
        $this->sortField = 'name';
    }

    /**
     * @return Column[]
     */
    public function getColumns(): array
    {
        return [
            'name' => new Column(
                'Name',
                'users.name',
                static fn (User $user): string => $user->name,
            ),
            'client' => new Column(
                'Client',
                'clients.name',
                static fn (User $user): string => $user->client->name,
            ),
        ];
    }

    protected function getBuilder(): Builder
    {
        return User::query()
            ->select('users.*')
            ->leftJoin('clients', 'users.client_id', 'clients.id')
            ->with(['client']);
    }
}
