<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire;

use App\Livewire\UserTable;
use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\TestCase;

#[CoversClass(UserTable::class)]
final class UserTableTest extends TestCase
{
    public function test_render(): void
    {
        /** @var Collection<User> $users */
        $users = User::factory(10)->create();

        Livewire::test(UserTable::class)
            ->assertSeeHtml($users->pluck('name')->toArray());
    }
}
