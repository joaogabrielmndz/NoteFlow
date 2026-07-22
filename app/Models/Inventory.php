<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Override;

#[Fillable(['user_id', 'perfume_id', 'status'])]
class Inventory extends Model
{
    /** @use HasFactory<\Database\Factories\InventoryFactory> */
    use HasFactory,
    /** @use Illuminate\Database\Eloquent\SoftDeletes */
    SoftDeletes;

    /** Get the user from a inventory */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** Get the perfume from inventory */
    public function perfume(): BelongsTo
    {
        return $this->belongsTo(Perfume::class);
    }

    #[Override]
    public static function booted(): void
    {
        static::saving(function (Inventory $inventory) {
            if ($inventory->remaining_ml <= 0) {
                $inventory->remaining_ml = 0;
                $inventory->status = 'Finished';
            }
        });
    }
}
