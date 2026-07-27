<?php

namespace App\Models;

use App\Enums\Barga;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['clan_id', 'title', 'name', 'gender', 'dob', 'barga', 'photo', 'phone', 'ancestral_address', 'residence_type', 'deceased_on'])]
#[Guarded(['id', 'created_at', 'updated_at'])]

class Profile extends Model
{
    protected function casts(): array
    {
        return [
            'dob' => 'date',
            'barga' => Barga::class,
        ];
    }

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
     * @return HasOne<MotherGroup, $this>
     */
    public function motherGroup(): HasOne
    {
        return $this->hasOne(MotherGroup::class);
    }

    /**
     * @return HasOne<FamilyRelation, $this>
     */
    public function familyRelation(): HasOne
    {
        return $this->hasOne(FamilyRelation::class);
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
