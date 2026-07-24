<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

#[Fillable(['content_category_id', 'title', 'summary', 'body', 'header_image_path', 'is_pinned'])]
#[Guarded(['id', 'created_at', 'updated_at'])]

class Content extends Model
{
    protected function casts(): array
    {
        return [
            'is_pinned' => 'boolean',
        ];
    }

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
