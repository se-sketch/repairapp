<?php

namespace App\Policies;

use App\Models\OrderMaterial;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

class OrderMaterialPolicy
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
        return Gate::allows('order-material-settings');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OrderMaterial  $orderMaterial
     * @return mixed
     */
    public function view(User $user, OrderMaterial $orderMaterial)
    {
        if ($user->id !== $orderMaterial->user->id){
            if (!$user->hasRole('chief')){
                return false;
            }
        }

        return Gate::allows('order-material-settings');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return Gate::allows('order-material-settings');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OrderMaterial  $orderMaterial
     * @return mixed
     */
    public function update(User $user, OrderMaterial $orderMaterial)
    {
        if ($user->id !== $orderMaterial->user->id){
            return false;
        }
        
        return Gate::allows('order-material-settings');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OrderMaterial  $orderMaterial
     * @return mixed
     */
    public function delete(User $user, OrderMaterial $orderMaterial)
    {
        if ($orderMaterial->deleted_at){
            return false;
        }

        if ($user->id !== $orderMaterial->user->id){
            return false;
        }

        return Gate::allows('order-material-settings');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OrderMaterial  $orderMaterial
     * @return mixed
     */
    public function restore(User $user, OrderMaterial $orderMaterial)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OrderMaterial  $orderMaterial
     * @return mixed
     */
    public function forceDelete(User $user, OrderMaterial $orderMaterial)
    {
        return false;
    }
}
