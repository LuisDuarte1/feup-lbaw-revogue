<?php

namespace App\Policies;

use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
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
    public function view(User $user, Product $product): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //TODO (luisd): check if the user has all the required settings to sell the item
        return $user->account_status === 'active';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Product $product): bool
    {
        if ($product === null) {
            return false;
        }
        if ($user->id !== $product->sold_by) {
            return false;
        }
        if (ProductController::isProductSold($product)) {
            return false;
        }
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product): bool
    {
        if ($product === null) {
            return false;
        }
        if ($user->id !== $product->sold_by) {
            return false;
        }
        if (ProductController::isProductSold($product)) {
            return false;
        }
        return true;
    }
}
