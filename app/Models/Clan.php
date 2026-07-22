<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
