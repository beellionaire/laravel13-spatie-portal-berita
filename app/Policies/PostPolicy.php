<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use App\PermissionEnum;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionEnum::VIEW_POSTS->value);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Post $post): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionEnum::CREATE_POSTS->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        // Pengecualian: Jika dia Admin, langsung izinkan
        if ($user->hasRole('admin')) {
            return true;
        }

        return $user->hasPermissionTo(PermissionEnum::EDIT_POSTS->value) && $user->id === $post->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        // Pengecualian: Jika dia Admin, langsung izinkan
        if ($user->hasRole('admin')) {
            return true;
        }
        
        return $user->hasPermissionTo(PermissionEnum::DELETE_POSTS->value) && $user->id === $post->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return false;
    }
}
