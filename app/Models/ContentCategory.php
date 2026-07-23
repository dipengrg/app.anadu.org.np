<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContentCategory extends Model
{
    public function contents(): HasMany
    {
        return $this->hasMany(Content::class);
    }
}
