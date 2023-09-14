<?php

declare(strict_types=1);

namespace App\Livewire;

final class Column
{
    public function __construct(
        public readonly string $label,
        public readonly string $field,
        public readonly \Closure $display,
    ) {
    }
}
