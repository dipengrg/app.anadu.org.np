<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['channel', 'title', 'body', 'scheduled_at'])]
#[Guarded(['id', 'created_at', 'updated_at'])]

class Notification extends Model
{
    public function deliveries(): HasMany
    {
        return $this->hasMany(NotificationDelivery::class);
    }
}
