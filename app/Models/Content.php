<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Content extends Model
{
    public function category(): BelongsTo
    {
        return $this->belongsTo(ContentCategory::class, 'content_category_id');
    }

    // Accessor for header image URL
    public function getHeaderImageUrlAttribute(): ?string
    {
        return $this->header_image_path ? Storage::url($this->header_image_path) : null;
    }
}
