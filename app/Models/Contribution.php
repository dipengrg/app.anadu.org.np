<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['profile_id', 'contribution_category_id', 'contribution_tier_id', 'title', 'description', 'received_on'])]
#[Guarded(['id', 'created_at', 'updated_at'])]

class Contribution extends Model
{
    protected function casts(): array
    {
        return [
            'received_on' => 'date',
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
     * @return BelongsTo<ContributionCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ContributionCategory::class, 'contribution_category_id');
    }

    /**
     * @return BelongsTo<ContributionTier, $this>
     */
    public function tier(): BelongsTo
    {
        return $this->belongsTo(ContributionTier::class, 'contribution_tier_id');
    }
}
