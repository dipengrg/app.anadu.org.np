<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

#[Fillable(['profile_id', 'clan_id', 'mid', 'phone', 'rank', 'designation', 'role', 'ancestral_address', 'residence_type', 'started_on', 'ended_on', 'end_reason'])]
#[Guarded(['id', 'created_at', 'updated_at'])]

class Member extends Authenticatable
{
    protected function casts(): array
    {
        return [
            'rank' => 'integer',
            'started_on' => 'date',
            'ended_on' => 'date',
        ];
    }

    /**
     * @return BelongsTo<Profile, $this>
     */
    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    /**
     * @return BelongsTo<Clan, $this>
     */
    public function clan(): BelongsTo
    {
        return $this->belongsTo(Clan::class);
    }

    /**
     * @return HasMany<MemberDependent, $this>
     */
    public function dependents(): HasMany
    {
        return $this->hasMany(MemberDependent::class);
    }
}