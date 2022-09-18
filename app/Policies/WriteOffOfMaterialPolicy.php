<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WriteOffOfMaterial;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

class WriteOffOfMaterialPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return Gate::allows('write-off-of-material-settings');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WriteOffOfMaterial  $writeOffOfMaterial
     * @return mixed
     */
    public function view(User $user, WriteOffOfMaterial $writeOffOfMaterial)
    {
        if ($user->id !== $writeOffOfMaterial->user->id){
            if (!$user->hasRole('chief')){
                return false;
            }
        }

        return Gate::allows('write-off-of-material-settings');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return Gate::allows('write-off-of-material-settings');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WriteOffOfMaterial  $writeOffOfMaterial
     * @return mixed
     */
    public function update(User $user, WriteOffOfMaterial $writeOffOfMaterial)
    {
        if ($user->id !== $writeOffOfMaterial->user->id){
            return false;
        }
        
        return Gate::allows('write-off-of-material-settings');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WriteOffOfMaterial  $writeOffOfMaterial
     * @return mixed
     */
    public function delete(User $user, WriteOffOfMaterial $writeOffOfMaterial)
    {
        if ($writeOffOfMaterial->deleted_at){
            return false;
        }

        if ($user->id !== $writeOffOfMaterial->user->id){
            return false;
        }

        return Gate::allows('write-off-of-material-settings');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WriteOffOfMaterial  $writeOffOfMaterial
     * @return mixed
     */
    public function restore(User $user, WriteOffOfMaterial $writeOffOfMaterial)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WriteOffOfMaterial  $writeOffOfMaterial
     * @return mixed
     */
    public function forceDelete(User $user, WriteOffOfMaterial $writeOffOfMaterial)
    {
        return false;
    }
}
