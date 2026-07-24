<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['event_id', 'title'])]
#[Guarded(['id', 'created_at', 'updated_at'])]

class EventSession extends Model
{
    /**
     * @return BelongsTo<Event, $this>
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * @return HasMany<EventSessionParticipation, $this>
     */
    public function participations(): HasMany
    {
        return $this->hasMany(EventSessionParticipation::class);
    }
}
