<?php

namespace App\Policies;

use App\Models\Reports\ReportType;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ReportTypePolicy
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
     * @param ReportType $reportType
     * @return void
     */
    public function view(User $user, ReportType $reportType)
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
     * @param ReportType $reportType
     * @return void
     */
    public function update(User $user, ReportType $reportType)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param ReportType $reportType
     * @return void
     */
    public function delete(User $user, ReportType $reportType)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param ReportType $reportType
     * @return void
     */
    public function restore(User $user, ReportType $reportType)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param ReportType $reportType
     * @return void
     */
    public function forceDelete(User $user, ReportType $reportType)
    {
        //
    }
}
