<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['title'])]
#[Guarded(['id', 'created_at', 'updated_at'])]

class Clan extends Model
{
    /**
     * @return HasMany<Profile, $this>
     */
    public function profiles(): HasMany
    {
        return $this->hasMany(Profile::class);
    }
}
