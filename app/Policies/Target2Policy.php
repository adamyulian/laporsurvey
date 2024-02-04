<?php

namespace App\Policies;

use App\Models\Target2;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class Target2Policy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin' || $user->penyelia === 1;
    }

    // /**
    //  * Determine whether the user can view the model.
    //  */
    // public function view(User $user, Target2 $target2): bool
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can create models.
    //  */
    // public function create(User $user): bool
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can update the model.
    //  */
    // public function update(User $user, Target2 $target2): bool
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can delete the model.
    //  */
    // public function delete(User $user, Target2 $target2): bool
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can restore the model.
    //  */
    // public function restore(User $user, Target2 $target2): bool
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can permanently delete the model.
    //  */
    // public function forceDelete(User $user, Target2 $target2): bool
    // {
    //     //
    // }
}