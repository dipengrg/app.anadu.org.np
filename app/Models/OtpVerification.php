<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    /**
     * @param  Builder<OtpVerification>  $query
     * @return Builder<OtpVerification>
     */
    public function scopeValid(Builder $query): Builder
    {
        return $query->where('is_verified', false)
            ->where('expires_at', '>', now());
    }
}
