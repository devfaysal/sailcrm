<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visit extends Model
{
    protected $guarded = [];

    public function crop():BelongsTo
    {
        return $this->belongsTo(Crop::class);
    }
}
