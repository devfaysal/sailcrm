<?php

namespace App\Models;

use App\Enums\LeadType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lead extends Model
{
    protected function casts(): array
    {
        return [
            'type' => LeadType::class,
        ];
    }

    public function territorty(): BelongsTo
    {
        return $this->belongsTo(Territory::class);
    }

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }
}
