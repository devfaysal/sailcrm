<?php

namespace App\Models;

use App\Enums\LeadType;
use Devfaysal\BangladeshGeocode\Models\District;
use Devfaysal\BangladeshGeocode\Models\Division;
use Devfaysal\BangladeshGeocode\Models\Union;
use Devfaysal\BangladeshGeocode\Models\Upazila;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Lead extends Model implements HasMedia
{
    use InteractsWithMedia;
    
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'type' => LeadType::class,
        ];
    }

    protected $appends = ['picture'];

    protected $hidden = ['media'];

    protected $with = ['territory'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('picture')
            ->singleFile();
    }

    public function getPictureAttribute()
    {
        return $this->getFirstMediaUrl('picture');
    }

    public function attachPicture($path)
    {
        $this->addMediaFromDisk($path, 'public')
            ->preservingOriginal()
            ->toMediaCollection('picture');
    }

    public function territory(): BelongsTo
    {
        return $this->belongsTo(Territory::class);
    }

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function upazila(): BelongsTo
    {
        return $this->belongsTo(Upazila::class);
    }

    public function union(): BelongsTo
    {
        return $this->belongsTo(Union::class);
    }
}
