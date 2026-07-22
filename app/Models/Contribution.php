<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contribution extends Model
{
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
