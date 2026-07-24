<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['profile_id', 'rank', 'designation', 'role', 'started_on', 'ended_on'])]
#[Guarded(['id', 'created_at', 'updated_at'])]

class CommitteeMember extends Model
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
}
