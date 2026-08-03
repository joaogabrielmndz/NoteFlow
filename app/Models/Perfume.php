<?php

namespace App\Models;

use App\EnumTypes\PerfumeConcentration;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Override;

#[Fillable(['name', 'brand', 'concentration', 'image_url'])]
class Perfume extends Model
{
    /** @use HasFactory<\Database\Factories\PerfumeFactory> */
    use HasFactory;
    /** @use SoftDeletes */
    use SoftDeletes;

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn (string $v) => str($v)->trim()->lower()->title()->toString()
        );
    }

    #[Override]
    protected function casts()
    {
        return [
            'concentration' => PerfumeConcentration::class
        ];
    }

    public function notes()
    {
        return $this->belongsToMany(Note::class)
            ->withPivot('type'); // Allows access $note->pivot->type
    }

    // utils for future filter features

    public function topNotes()
    {
        return $this->notes()->wherePivot('type', 'top');
    }

    public function heartNotes()
    {
        return $this->notes()->wherePivot('type', 'heart');
    }

    public function baseNotes()
    {
        return $this->notes()->wherePivot('type', 'base');
    }

    /** Get a inventory */
    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }
}
