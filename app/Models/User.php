<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\RoleEnum;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Casts\Attribute;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
  /** @use HasFactory<UserFactory> */
  use HasFactory, Notifiable, HasRoles;

  protected $table = 'users';
  public $timestamps = true;
  protected $guarded = [];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
      'is_active' => 'boolean',
    ];
  }

  // ---------------------------------------------------------------------------------------
  // TODO: Relations
  // ---------------------------------------------------------------------------------------


  // ---------------------------------------------------------------------------------------
  // Roles
  // ---------------------------------------------------------------------------------------

  public function isSuperadmin(): bool
  {
    return $this->hasRole(RoleEnum::SUPERADMIN);
  }

  public function isAdmin(): bool
  {
    return $this->hasRole(RoleEnum::ADMIN);
  }

  public function isEditor(): bool
  {
    return $this->hasRole(RoleEnum::EDITOR);
  }

  public function hasAdminRights(): bool
  {
    return $this->isSuperadmin() || $this->isAdmin();
  }

  public function hasEditorRights(): bool
  {
    return $this->isEditor() || $this->hasAdminRights();
  }

  // ---------------------------------------------------------------------------------------
  // active status label
  // ---------------------------------------------------------------------------------------
  public function isActiveLabel(): string
  {
    return $this->is_active ? 'Ενεργός' : 'Ανενεργός';
  }
}
