<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class View extends JsonResource
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
      'is_active' => $this->is_active,
      'is_active_label' => $this->is_active_label,
      'is_superadmin_label' => $this->is_superadmin_label,
      'is_admin_label' => $this->is_admin_label,
      'is_editor_label' => $this->is_editor_label,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,

      'url' => [
        'show' => route('users.show', $this->id),
      ]
    ];
  }
}
