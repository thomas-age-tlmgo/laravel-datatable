<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $name
 * @property Client $client
 */
final class User extends Model
{
    use HasFactory;

    /**
     * @return BelongsTo<Client, User>
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
