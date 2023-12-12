<?php

namespace App\Policies;

use App\Models\Notification;
use App\Models\User;

class NotificationPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Notification $notification): bool
    {
        return $user->id == $notification->belongs_to;
    }

    public function toggleRead(User $user, Notification $notification): bool 
    {
        return $user->id == $notification->belongs_to;
    }

    public function toggleDismissed(User $user, Notification $notification): bool 
    {
        return $user->id == $notification->belongs_to;
    }
}
