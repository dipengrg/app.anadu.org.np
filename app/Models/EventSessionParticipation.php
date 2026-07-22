<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventSessionParticipation extends Model
{
    /**
     * @return BelongsTo<EventSession, $this>
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(EventSession::class, 'event_session_id');
    }

    /**
     * @return BelongsTo<Profile, $this>
     */
    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    /**
     * @return BelongsTo<ParticipationTier, $this>
     */
    public function tier(): BelongsTo
    {
        return $this->belongsTo(ParticipationTier::class, 'participation_tier_id');
    }
}
