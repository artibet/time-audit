<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Auth extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'id' => $this->id,
      'email' => $this->email,
      'name' => $this->name,
      'is_superadmin' => $this->isSuperadmin(),
      'is_admin' => $this->isAdmin(),
      'is_editor' => $this->isEditor(),
      'has_admin_rights' => $this->hasAdminRights(),
      'has_editor_rights' => $this->hasEditorRights(),
    ];
  }
}
