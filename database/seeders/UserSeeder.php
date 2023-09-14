<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

final class UserSeeder extends Seeder
{
    public function run(): void
    {
        Client::factory(50)->create();

        User::factory(150)
            ->state(
                new Sequence(fn (Sequence $sequence): array => [
                    'client_id' => Client::all()->random(),
                ])
            )
            ->create();
    }
}
