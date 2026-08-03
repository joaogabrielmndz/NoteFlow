<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name'])]
class Note extends Model
{
    /** @use HasFactory<\Database\Factories\NoteFactory> */
    use HasFactory,
    /**@use  Illuminate\Database\Eloquent\SoftDeletes */
    SoftDeletes;

    public function perfumes(): BelongsToMany
    {
        return $this->belongsToMany(Perfume::class)->withPivot('type');
    }
}
