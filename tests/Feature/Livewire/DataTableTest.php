<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire;

use App\Livewire\Column;
use App\Livewire\DataTable;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\TestCase;

#[CoversClass(DataTable::class)]
final class DataTableTest extends TestCase
{
    public function test_render(): void
    {
        /** @var Collection<User> $users */
        $users = User::factory(10)->create();

        $datatable = new class extends DataTable
        {
            public function mount(): void
            {
                $this->sortField = 'name';
            }

            public function getColumns(): array
            {
                return [
                    'name' => new Column('Name', 'name', static fn (User $user): string => $user->name),
                ];
            }

            protected function getBuilder(): Builder
            {
                return User::query();
            }
        };

        Livewire::test($datatable)
            ->assertSeeHtml($users->pluck('name')->toArray());
    }

    public function test_sort(): void
    {
        /** @var Collection<User> $users */
        $users = User::factory(10)->create();

        $datatable = new class extends DataTable
        {
            public function getColumns(): array
            {
                return [
                    'name' => new Column('Name', 'name', static fn (User $user): string => $user->name),
                ];
            }

            protected function getBuilder(): Builder
            {
                return User::query();
            }
        };

        $names = $users->pluck('name')->toArray();
        sort($names);

        Livewire::test($datatable)
            ->call('sortBy', 'name')
            ->assertSeeHtmlInOrder($names);
    }

    public function test_sort_reverse(): void
    {
        /** @var Collection<User> $users */
        $users = User::factory(10)->create();

        $datatable = new class extends DataTable
        {
            public function mount(): void
            {
                $this->sortField = 'name';
            }

            public function getColumns(): array
            {
                return [
                    'name' => new Column('Name', 'name', static fn (User $user): string => $user->name),
                ];
            }

            protected function getBuilder(): Builder
            {
                return User::query();
            }
        };

        $names = $users->pluck('name')->toArray();
        rsort($names);

        Livewire::test($datatable)
            ->call('sortBy', 'name')
            ->assertSeeHtmlInOrder($names);
    }

    public function test_search(): void
    {
        /** @var Collection<User> $users */
        $users = User::factory(10)->create();

        $datatable = new class extends DataTable
        {
            public function getColumns(): array
            {
                return [
                    'name' => new Column('Name', 'name', static fn (User $user): string => $user->name),
                ];
            }

            protected function getBuilder(): Builder
            {
                return User::query();
            }
        };

        $names = $users
            ->pluck('name')
            ->filter(static fn (string $name): bool => str_contains($name, 'a'))
            ->toArray();

        Livewire::test($datatable)
            ->set('query', 'a')
            ->call('search')
            ->assertSeeHtml($names);
    }
}
