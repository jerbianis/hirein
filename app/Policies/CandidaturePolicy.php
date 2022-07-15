<?php

namespace App\Policies;

use App\Models\Candidature;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CandidaturePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
        return $user->isCandidate();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Candidature  $candidature
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Candidature $candidature)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
        return $user->isCandidate();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Candidature  $candidature
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Candidature $candidature)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Candidature  $candidature
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Candidature $candidature)
    {
        //
        return $user->profile->id === $candidature->candidate_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Candidature  $candidature
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Candidature $candidature)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Candidature  $candidature
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Candidature $candidature)
    {
        //
    }
}
