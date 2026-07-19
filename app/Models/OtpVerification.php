<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mobile_number',
        'otp_code',
        'expires_at',
        'is_verified',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expires_at'  => 'datetime',
        'is_verified' => 'boolean',
    ];

    /**
     * Scope a query to only include active, unexpired OTP tokens.
     * 
     * This keeps your service layer clean by letting you do:
     * OtpVerification::valid()->where('mobile_number', $number)->first();
     */
    public function scopeValid($query)
    {
        return $query->where('is_verified', false)
                     ->where('expires_at', '>', now());
    }
}