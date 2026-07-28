<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserObserver
{
    public function updated(User $user): void
    {
        if (! $user->wasChanged('is_active') || $user->is_active) {
            return;
        }

        DB::table('sessions')->where('user_id', $user->id)->delete();
    }
}
