<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
  /**
   * Determine whether the user can view any models.
   */
  public function viewAny(User $user): bool
  {
    return $user->isSuperadmin();
  }

  /**
   * Determine whether the user can view the model.
   */
  public function view(User $user, User $model): bool
  {
    return $user->isSuperadmin();
  }

  /**
   * Determine whether the user can create models.
   */
  public function create(User $user): bool
  {
    return $user->isSuperadmin();
  }

  /**
   * Determine whether the user can update the model.
   */
  public function update(User $user, User $model): bool
  {
    return $user->isSuperadmin();
  }

  /**
   * Determine whether the user can delete the model.
   */
  public function delete(User $user, User $model): bool
  {
    // Superadmins only
    if (!$user->isSuperadmin()) return false;

    // Δεν μπορεί να διαγραφεί ο συνδεδεμένος χρήστης
    if ($user->id === $model->id) return false;

    // Check for relations
    // TODO

    // ok
    return true;
  }

  // ---------------------------------------------------------------------------------------
  // Update roles
  // ---------------------------------------------------------------------------------------
  public function updateRoles(User $user, User $model): bool
  {
    // Θα πρέπει να μπορεί να γίνει update το model γενικά
    if (!$this->update($user, $model)) return false;

    // Δεν μπορεί να αλλάξει η κατάσταση του συνδεδεμένου χρήστη
    if ($user->id === $model->id) return false;

    // ok
    return true;
  }

  // ---------------------------------------------------------------------------------------
  // update status
  // ---------------------------------------------------------------------------------------
  public function updateStatus(User $user, User $model): bool
  {
    // Θα πρέπει να μπορεί να γίνει update το model γενικά
    if (!$this->update($user, $model)) return false;

    // Δεν μπορεί να αλλάξει η κατάσταση του συνδεδεμένου χρήστη
    if ($user->id === $model->id) return false;

    // ok
    return true;
  }

  // ---------------------------------------------------------------------------------------
  // Reset password
  // ---------------------------------------------------------------------------------------
  public function resetPassword(User $user, User $model)
  {
    return $user->isSuperadmin();
  }
}
