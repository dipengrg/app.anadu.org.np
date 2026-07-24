<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_id', 'clan_id', 'title', 'name', 'gender', 'dob', 'photo', 'phone', 'ancestral_address', 'residence_type'])]
#[Guarded(['id', 'created_at', 'updated_at'])]

class Profile extends Model
{
    /**
     * @return BelongsTo<Clan, $this>
     */
    public function clan(): BelongsTo
    {
        return $this->belongsTo(Clan::class);
    }

    /**
     * @return HasMany<CommitteeMember, $this>
     */
    public function committeeRoles(): HasMany
    {
        return $this->hasMany(CommitteeMember::class);
    }

    /**
     * @return HasMany<EventSessionParticipation, $this>
     */
    public function sessionParticipations(): HasMany
    {
        return $this->hasMany(EventSessionParticipation::class);
    }

    public function getTotalSocialScoreAttribute(): int
    {
        return (int) $this->sessionParticipations()->sum('calculated_points');
    }
}
