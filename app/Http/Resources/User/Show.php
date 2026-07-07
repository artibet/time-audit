<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Role\Index as RoleIndexResource;
use Illuminate\Support\Facades\Gate;

class Show extends JsonResource
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
      'is_active_label' => $this->isActiveLabel(),
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
      'roles' => RoleIndexResource::collection($this->roles),

      'policy' => [
        'update' => Gate::allows('update', $this->resource),
        'update_status' => Gate::allows('updateStatus', $this->resource),
        'update_roles' => Gate::allows('updateRoles', $this->resource),
        'delete' => Gate::allows('delete', $this->resource),
        'reset_password' => Gate::allows('resetPassword', $this->resource),
      ],

      'url' => [
        'update' => route('users.update', $this->id),
        'delete' => route('users.destroy', $this->id),
        'reset-password' => route('users.reset-password', $this->id),
      ]
    ];
  }
}
