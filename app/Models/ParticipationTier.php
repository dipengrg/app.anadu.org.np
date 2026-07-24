<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['title', 'summary', 'points'])]
#[Guarded(['id', 'created_at', 'updated_at'])]

class ParticipationTier extends Model
{
    protected function casts(): array
    {
        return [
            'points' => 'integer',
        ];
    }

    /**
     * @return HasMany<EventSessionParticipation, $this>
     */
    public function sessionParticipations(): HasMany
    {
        return $this->hasMany(EventSessionParticipation::class);
    }
}
