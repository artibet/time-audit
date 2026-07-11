<?php

namespace App\Policies;

use App\Models\Punch;
use App\Models\User;

class PunchPolicy
{
  /**
   * Determine whether the user can view any models.
   */
  public function viewAny(User $user): bool
  {
    return $user->hasEditorRights();
  }

  /**
   * Determine whether the user can view the model.
   */
  public function view(User $user, Punch $punch): bool
  {
    return $user->hasEditorRights();
  }

  /**
   * Determine whether the user can create models.
   */
  public function create(User $user): bool
  {
    return $user->hasEditorRights();
  }

  /**
   * Determine whether the user can update the model.
   */
  public function update(User $user, Punch $punch): bool
  {
    return $user->hasEditorRights();
  }

  /**
   * Determine whether the user can delete the model.
   */
  public function delete(User $user, Punch $punch): bool
  {
    return $user->hasEditorRights();
  }
}
