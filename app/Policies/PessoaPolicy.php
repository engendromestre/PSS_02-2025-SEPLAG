<?php

namespace App\Policies;

use App\Models\Pessoa;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Log;

class PessoaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
         return in_array($user->role, ['admin', 'editor', 'user']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Pessoa $pessoa): bool
    {
        return in_array($user->role, ['admin', 'editor', 'user']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
         return in_array($user->role, ['admin', 'editor']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Pessoa $pessoa): bool
    {
        Log::info('Policy UPDATE chamada', [
            'user_id' => $user->id,
            'user_role' => $user->role,
            'pessoa_id' => $pessoa->id,
        ]);
        return in_array($user->role, ['admin', 'editor']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Pessoa $pessoa): bool
    {
        return in_array($user->role, ['admin', 'editor']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Pessoa $pessoa): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Pessoa $pessoa): bool
    {
        return false;
    }
}
