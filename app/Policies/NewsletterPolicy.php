<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Newsletter;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsletterPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Tous les utilisateurs authentifiés peuvent lister les newsletters
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Newsletter $newsletter): bool
    {
        return true; // Tous les utilisateurs authentifiés peuvent voir une newsletter
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Tous les utilisateurs authentifiés peuvent créer des newsletters
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Newsletter $newsletter): bool
    {
        return true; // Tous les utilisateurs authentifiés peuvent mettre à jour les newsletters
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Newsletter $newsletter): bool
    {
        return $user->isAdmin(); // Seuls les admins peuvent supprimer les newsletters
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Newsletter $newsletter): bool
    {
        return false; // Pas de restauration pour l'instant
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Newsletter $newsletter): bool
    {
        return false; // Pas de suppression définitive pour l'instant
    }
}