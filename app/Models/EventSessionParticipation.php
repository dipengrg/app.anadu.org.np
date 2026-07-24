<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['event_session_id', 'profile_id', 'participation_tier_id', 'hours_contributed', 'calculated_points', 'remarks'])]
#[Guarded(['id', 'created_at', 'updated_at'])]

class EventSessionParticipation extends Model
{
    protected function casts(): array
    {
        return [
            'hours_contributed' => 'decimal:2',
            'calculated_points' => 'integer',
        ];
    }

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
