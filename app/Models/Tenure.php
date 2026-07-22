<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenure extends Model
{
    /**
     * @return HasMany<CommitteeMember, $this>
     */
    public function committeeMembers(): HasMany
    {
        return $this->hasMany(CommitteeMember::class)->orderBy('rank', 'asc');
    }
}
