<?php

namespace App\Policies;

use App\Models\Surveykendaraan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SurveykendaraanPolicy
{
    // /**
    //  * Determine whether the user can view any models.
    //  */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin' or $user->penyelia === '1';
    }

    // /**
    //  * Determine whether the user can view the model.
    //  */
    // public function view(User $user, Surveykendaraan $surveykendaraan): bool
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
    // public function update(User $user, Surveykendaraan $surveykendaraan): bool
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can delete the model.
    //  */
    // public function delete(User $user, Surveykendaraan $surveykendaraan): bool
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can restore the model.
    //  */
    // public function restore(User $user, Surveykendaraan $surveykendaraan): bool
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can permanently delete the model.
    //  */
    // public function forceDelete(User $user, Surveykendaraan $surveykendaraan): bool
    // {
    //     //
    // }
}
