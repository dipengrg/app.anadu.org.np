<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ParticipationTier extends Model
{
    /**
     * @return HasMany<EventSessionParticipation, $this>
     */
    public function sessionParticipations(): HasMany
    {
        return $this->hasMany(EventSessionParticipation::class);
    }
}
