<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['notification_id', 'profile_id', 'status', 'provider_message_id'])]
#[Guarded(['id', 'created_at', 'updated_at'])]

class NotificationDelivery extends Model
{
    public function notification(): BelongsTo
    {
        return $this->belongsTo(Notification::class);
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
