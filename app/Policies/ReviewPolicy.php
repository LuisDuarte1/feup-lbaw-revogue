<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Review $review): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, ?Order $order): bool
    {
        if ($order === null) {
            return false;
        }
        if ($order->reviewedOrder()->get()->first() !== null) {
            return false;
        }

        if ($order->status !== 'received') {
            return false;
        }

        return $user->account_status === 'active';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Review $review): bool
    {
        if ($review === null) {
            return false;
        }
        if ($user->id !== $review->reviewer) {
            return false;
        }
        if ($review->reviewedOrder()->get()->first() === null) {
            return false;
        }
        if ($review->reviewedOrder()->get()->first()->status !== 'received') {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Review $review): bool
    {
        if ($review === null) {
            return false;
        }

        if ($user->id !== $review->reviewer) {
            return false;
        }
        if ($review->reviewedOrder()->get()->first() === null) {
            return false;
        }
        if ($review->reviewedOrder()->get()->first()->status !== 'received') {
            return false;
        }

        return true;
    }
}
