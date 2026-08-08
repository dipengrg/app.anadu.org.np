<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['zodiac_id', 'title', 'name', 'gender', 'dob', 'marital_status', 'photo', 'deceased_on'])]
#[Guarded(['id', 'created_at', 'updated_at'])]

class Profile extends Model
{
    protected function casts(): array
    {
        return [
            'dob' => 'date'
        ];
    }

    /**
     * @return HasMany<Member, $this>
     */
    public function communityRoles(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    /**
     * @return HasOne<MotherGroup, $this>
     */
    public function motherGroup(): HasOne
    {
        return $this->hasOne(MotherGroup::class);
    }

    /**
     * @return HasMany<EventSessionParticipation, $this>
     */
    public function sessionParticipations(): HasMany
    {
        return $this->hasMany(EventSessionParticipation::class);
    }

    /**
     * @return BelongsTo<Zodiac, $this>
     */
    public function zodiac(): BelongsTo
    {
        return $this->belongsTo(Zodiac::class);
    }

    public function getTotalSocialScoreAttribute(): int
    {
        return (int) $this->sessionParticipations()->sum('calculated_points');
    }
}
