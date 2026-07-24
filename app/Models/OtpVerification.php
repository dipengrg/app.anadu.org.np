<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['mobile_number', 'otp_code', 'expires_at', 'is_verified'])]
#[Guarded(['id', 'created_at', 'updated_at'])]

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
