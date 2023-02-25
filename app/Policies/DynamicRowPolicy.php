<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DynamicAttributes\DynamicRow;
use Illuminate\Auth\Access\HandlesAuthorization;

class DynamicRowPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return void
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param DynamicRow $dynamicRow
     * @return void
     */
    public function view(User $user, DynamicRow $dynamicRow)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return void
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param DynamicRow $dynamicRow
     * @return void
     */
    public function update(User $user, DynamicRow $dynamicRow)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param DynamicRow $dynamicRow
     * @return void
     */
    public function delete(User $user, DynamicRow $dynamicRow)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param DynamicRow $dynamicRow
     * @return void
     */
    public function restore(User $user, DynamicRow $dynamicRow)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param DynamicRow $dynamicRow
     * @return void
     */
    public function forceDelete(User $user, DynamicRow $dynamicRow)
    {
        //
    }
}
