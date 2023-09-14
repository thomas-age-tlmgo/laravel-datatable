<?php

declare(strict_types=1);

namespace Tests\Unit\Livewire;

use App\Livewire\Column;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Column::class)]
final class ColumnTest extends TestCase
{
    public function test_create_column(): void
    {
        $column = new Column(
            'My label',
            'table.field',
            static fn (): string => 'a'
        );

        self::assertSame('My label', $column->label);
        self::assertSame('table.field', $column->field);
        self::assertSame('a', call_user_func($column->display));
    }
}
